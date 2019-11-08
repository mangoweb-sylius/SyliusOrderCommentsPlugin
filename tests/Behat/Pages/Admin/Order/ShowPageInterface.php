<?php

declare(strict_types=1);

namespace Tests\MangoSylius\OrderCommentsPlugin\Behat\Pages\Admin\Order;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ShowPageInterface extends SymfonyPageInterface
{
    public function sendOrderEmail(): void;

    public function addMessage(): void;

    public function showMessage();

    public function checkOption($arg1);
}
