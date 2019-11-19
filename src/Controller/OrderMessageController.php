<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Controller;

use Doctrine\ORM\EntityManagerInterface;
use MangoSylius\OrderCommentsPlugin\Entity\OrderMessage;
use MangoSylius\OrderCommentsPlugin\Form\Type\OrderMessageType;
use Sylius\Component\Core\Model\AdminUser;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderMessageController
{
    /** @var TranslatorInterface */
    private $translator;
    /** @var EngineInterface */
    private $templatingEngine;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var SenderInterface */
    private $mailer;
    /** @var RouterInterface */
    private $router;
    /** @var FlashBagInterface */
    private $flashBag;
    /** @var FormFactoryInterface */
    private $builder;
    /** @var TokenStorageInterface */
    private $token;

    public function __construct(
        TranslatorInterface $translator,
        EngineInterface $templatingEngine,
        EntityManagerInterface $entityManager,
        SenderInterface $mailer,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        FormFactoryInterface $builder,
        TokenStorageInterface $tokenStorage
    ) {
        $this->translator = $translator;
        $this->templatingEngine = $templatingEngine;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->builder = $builder;
        $this->token = $tokenStorage;
    }

    public function contactAction(Request $request, int $id): Response
    {
        $contact = new OrderMessage();
        $form = $this->builder->create(OrderMessageType::class, $contact, [
            'action' => $this->router->generate('mango_sylius_admin_order_message_send', ['id' => $id]),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $order = $this->entityManager->find(Order::class, $id);
                $token = $this->token->getToken();
                $sendMail = $form['sendMail']->getData();
                $contact->setSendTime(new \DateTime());
                $contact->setOrder($order);

                assert($token && $token->getUser() instanceof AdminUser);
                $sender = $token->getUser();
                $contact->setSender($sender);

                $this->entityManager->persist($contact);
                $this->entityManager->flush();
                assert($order instanceof OrderInterface);
                $customer = $order->getCustomer();
                if ($sendMail === true) {
                    assert($customer instanceof CustomerInterface);
                    $this->mailer->send('order_mail', [$customer->getEmail()], ['contact' => $contact]);
                    $this->flashBag->add('success', $this->translator->trans('mango_sylius.orderMessage.success.mail'));
                } else {
                    $this->mailer->send('note_mail', [$sender->getEmail()], ['contact' => $contact]);
                    $this->flashBag->add('success', $this->translator->trans('mango_sylius.orderMessage.success.note'));
                }
            } else {
                $this->flashBag->add('error', $this->translator->trans('mango_sylius.orderMessage.error'));
            }

            return new RedirectResponse($this->router->generate('sylius_admin_order_show', ['id' => $id]));
        }

        return new Response($this->templatingEngine->render('OrderMessage/Form/_form.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    public function showAction(int $id)
    {
        $orderMessage = $this->entityManager->getRepository(OrderMessage::class)->findBy(['order' => $id]);

        return new Response($this->templatingEngine->render('OrderMessage/show.html.twig', [
            'messages' => $orderMessage,
        ]));
    }
}
