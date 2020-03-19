<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Controller;

use MangoSylius\OrderCommentsPlugin\Entity\OrderMessage;
use MangoSylius\OrderCommentsPlugin\Form\Type\OrderMessageType;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
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

    /** @var OrderRepositoryInterface */
    private $orderRepository;

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
    /**
     * @var RepositoryInterface
     */
    private $orderMessageRepository;

    public function __construct(
        TranslatorInterface $translator,
        EngineInterface $templatingEngine,
        OrderRepositoryInterface $orderRepository,
        SenderInterface $mailer,
        RouterInterface $router,
        FlashBagInterface $flashBag,
        FormFactoryInterface $builder,
        TokenStorageInterface $tokenStorage,
        RepositoryInterface $orderMessageRepository
    ) {
        $this->translator = $translator;
        $this->templatingEngine = $templatingEngine;
        $this->orderRepository = $orderRepository;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->flashBag = $flashBag;
        $this->builder = $builder;
        $this->token = $tokenStorage;
        $this->orderMessageRepository = $orderMessageRepository;
    }

    public function save(Request $request, int $orderId): Response
    {
        $orderMessage = new OrderMessage();
        $form = $this->builder->create(OrderMessageType::class, $orderMessage, [
            'action' => $this->router->generate('mango_sylius_admin_order_message_send', ['orderId' => $orderId]),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $order = $this->orderRepository->find($orderId);

                assert($order instanceof OrderInterface);
                $orderMessage->setOrder($order);

                $token = $this->token->getToken();
                assert($token !== null);
                $sender = $token->getUser();
                assert($sender instanceof AdminUserInterface);
                $orderMessage->setSender($sender);
                $orderMessage->setSendTime(new \DateTime());

                $this->orderMessageRepository->add($orderMessage);

                $customer = $order->getCustomer();
                if ($orderMessage->isSendMail()) {
                    assert($customer instanceof CustomerInterface);
                    $this->mailer->send('order_mail', [$customer->getEmail()], ['orderMessage' => $orderMessage]);
                    $this->flashBag->add('success', $this->translator->trans('mango_sylius.orderMessage.success.mail'));
                } else {
                    $this->flashBag->add('success', $this->translator->trans('mango_sylius.orderMessage.success.note'));
                }
            } else {
                $this->flashBag->add('error', $this->translator->trans('mango_sylius.orderMessage.error'));
            }

            return new RedirectResponse($this->router->generate('sylius_admin_order_show', ['id' => $orderId]));
        }

        return new Response($this->templatingEngine->render('@MangoSyliusOrderCommentsPlugin/Admin/Form/_form.html.twig', [
            'form' => $form->createView(),
        ]));
    }

    public function show(int $orderId)
    {
        $orderMessages = $this->orderMessageRepository->findBy(['order' => $orderId]);

        return new Response($this->templatingEngine->render('@MangoSyliusOrderCommentsPlugin/Admin/_show.html.twig', [
            'messages' => $orderMessages,
        ]));
    }
}
