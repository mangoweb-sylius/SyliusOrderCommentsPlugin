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

    public function saveOrderEmail(): void
    {
        $this->getElement('save')->click();
    }

    public function addMessage(): void
    {
        $this->getElement('message')->setValue('Some message');
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

    public function uncheckOption($checkbox): void
    {
        $Page = $this->getSession()->getPage();
        $Page->find('css', '#' . $checkbox)->setValue(false);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'save' => '#mango_sylius_order_message_save',
            'message' => '#mango_sylius_order_message_message',
            'order_message' => '#orderMessage',
        ]);
    }
}
