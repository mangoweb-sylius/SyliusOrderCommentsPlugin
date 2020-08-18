<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="mangoweb_order_message")
 */
class OrderMessage implements OrderMessageInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", length=65535, nullable=false)
     *
     * @var string|null
     * @Assert\NotBlank
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime|null
     */
    protected $sendTime;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $sendMail = false;

    /**
     * @var OrderInterface|null
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Order\Model\OrderInterface")
     */
    protected $order;

    /**
     * @var AdminUserInterface|null
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\AdminUserInterface")
     */
    protected $sender;

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getSendTime(): ?\DateTime
    {
        return $this->sendTime;
    }

    public function setSendTime(?\DateTime $sendTime): void
    {
        $this->sendTime = $sendTime;
    }

    public function isSendMail(): bool
    {
        return $this->sendMail;
    }

    public function setSendMail(bool $sendMail): void
    {
        $this->sendMail = $sendMail;
    }

    public function getOrder(): ?OrderInterface
    {
        return $this->order;
    }

    public function setOrder(?OrderInterface $order): void
    {
        $this->order = $order;
    }

    public function getSender(): ?AdminUserInterface
    {
        return $this->sender;
    }

    public function setSender(?AdminUserInterface $sender): void
    {
        $this->sender = $sender;
    }
}
