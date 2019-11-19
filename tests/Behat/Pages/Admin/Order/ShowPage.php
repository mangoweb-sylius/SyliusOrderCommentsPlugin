<?php

declare(strict_types=1);

namespace Tests\MangoSylius\OrderCommentsPlugin\Behat\Pages\Admin\Order;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ShowPage extends SymfonyPage implements ShowPageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_admin_order_show';
    }

    public function sendOrderEmail(): void
    {
        $this->getElement('send_message')->click();
    }

    public function addMessage(): void
    {
        $this->getElement('message')->setValue('message');
    }

    public function showMessage(): void
    {
        $lastM = $this->getElement('order_message')->getText();
        if (empty($lastM)) {
            throw new \RuntimeException(sprintf('no message found'));
        }
    }

    public function checkOption($checkbox): void
    {
        $Page = $this->getSession()->getPage();
        $Page->find('css', '#' . $checkbox)->setValue(true);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'send_message' => '#mango_sylius_order_message_sendMessage',
            'message' => '#mango_sylius_order_message_message',
            'order_message' => '#orderMessage',
        ]);
    }
}
