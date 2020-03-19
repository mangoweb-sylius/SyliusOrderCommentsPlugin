<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderMessageType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('sendMail', CheckboxType::class, [
                'label' => 'mango_sylius.orderMessage.sendMail',
                'required' => false,
                'value' => 0,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'mango_sylius.orderMessage.save',
            ]);
    }

    public function getBlockPrefix()
    {
        return 'mango_sylius_order_message';
    }
}
