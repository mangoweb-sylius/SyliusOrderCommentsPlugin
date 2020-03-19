<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface OrderMessageInterface extends ResourceInterface
{
    public function getMessage(): ?string;

    public function setMessage(?string $message): void;

    public function getSendTime(): ?\DateTime;

    public function setSendTime(?\DateTime $sendTime): void;

    public function isSendMail(): bool;

    public function setSendMail(bool $sendMail): void;

    public function getOrder(): ?OrderInterface;

    public function setOrder(?OrderInterface $order): void;

    public function getSender(): ?AdminUserInterface;

    public function setSender(?AdminUserInterface $sender): void;
}
