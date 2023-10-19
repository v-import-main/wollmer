<?php

namespace Yoomoney\Includes;

use Yookassa\Model\Notification\NotificationWaitingForCapture;

class CaptureNotificationChecker
{
    /** @var PaymentsTableModel */
    private $paymentsTableModel;

    public function __construct($paymentsTableModel)
    {
        $this->paymentsTableModel = $paymentsTableModel;
    }

    public function isHandled(NotificationWaitingForCapture $notification)
    {
        $paymentId = $notification->getObject()->getId();

        return $this->paymentsTableModel->isPaymentPaid($paymentId);
    }
}