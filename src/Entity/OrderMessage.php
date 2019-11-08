<?php

declare(strict_types=1);

namespace MangoSylius\OrderCommentsPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\AdminUser;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_order_message")
 */
class OrderMessage implements ResourceInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string|null
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime|null
     */
    private $sendTime;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $sendMail = false;

    /**
     * @var Order|null
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\Order")
     */
    private $order;

    /**
     * @var AdminUser|null
     * @ORM\ManyToOne(targetEntity="Sylius\Component\Core\Model\AdminUser")
     */
    private $sender;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     */
    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return \DateTime|null
     */
    public function getSendTime(): ?\DateTime
    {
        return $this->sendTime;
    }

    /**
     * @param \DateTime|null $sendTime
     */
    public function setSendTime(?\DateTime $sendTime): void
    {
        $this->sendTime = $sendTime;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order|null $order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return AdminUser|null
     */
    public function getSender(): ?AdminUser
    {
        return $this->sender;
    }

    /**
     * @param AdminUser|null $sender
     */
    public function setSender(?AdminUser $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return bool
     */
    public function isSendMail(): bool
    {
        return $this->sendMail;
    }

    /**
     * @param bool $sendMail
     */
    public function setSendMail(bool $sendMail): void
    {
        $this->sendMail = $sendMail;
    }
}
