<?php

declare(strict_types=1);

namespace Tests\MangoSylius\OrderCommentsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Component\Core\Test\Services\EmailCheckerInterface;
use Tests\MangoSylius\OrderCommentsPlugin\Behat\Pages\Admin\Order\ShowPageInterface;
use Webmozart\Assert\Assert;

final class ManagingOrderMessageContext implements Context
{
    /**
     * @var ShowPageInterface
     */
    private $showPage;
    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;
    /**
     * @var EmailCheckerInterface
     */
    private $emailChecker;

    public function __construct(
        ShowPageInterface $showPage,
        NotificationCheckerInterface $notificationChecker,
        EmailCheckerInterface $emailChecker
    ) {
        $this->showPage = $showPage;
        $this->notificationChecker = $notificationChecker;
        $this->emailChecker = $emailChecker;
    }

    /**
     * @When I write a message
     */
    public function iWriteAMessage()
    {
        $this->showPage->addMessage();
    }

    /**
     * @When I send the order message
     */
    public function iResendTheOrderEmail(): void
    {
        $this->showPage->sendOrderEmail();
    }

    /**
     * @Then an email generated for order :arg1 should be sent to :arg2
     */
    public function anEmailGeneratedForOrderShouldBeSentTo(string $arg1, string $arg2): void
    {
        Assert::true($this->emailChecker->hasMessageTo('Message regarding your order No.' . $arg1, $arg2));
    }

    /**
     * @Then I should be notified that the email was sent successfully
     */
    public function iShouldBeNotifiedThatTheEmailWasSentSuccessfully(): void
    {
        $this->notificationChecker->checkNotification(
            'The message to the customer has been sent',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the note as been create
     */
    public function iShouldBeNotifiedThatTheNoteAsBeenCreate()
    {
        $this->notificationChecker->checkNotification(
            'The note has been save',
            NotificationType::success()
        );
    }

    /**
     * @Then I see list of messages sended to the customer
     * @Then I see the note created
     */
    public function iSeeListOfMessagesSendedToTheCustomer()
    {
        $this->showPage->showMessage();
    }

    /**
     * @When I check :arg1
     */
    public function iCheck($arg1)
    {
        $this->showPage->checkOption($arg1);
    }
}
