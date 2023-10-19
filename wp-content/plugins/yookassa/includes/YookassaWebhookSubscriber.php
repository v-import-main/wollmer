<?php

use YooKassa\Model\NotificationEventType;

class YookassaWebhookSubscriber
{
    /**
     * Проверяет существующие подписки, удаляет некорректные и создает новые
     *
     * @param YooKassa\Client $client
     * @return void
     */
    public static function subscribe($client)
    {
        $needWebHookList = array(
            NotificationEventType::PAYMENT_SUCCEEDED,
            NotificationEventType::PAYMENT_CANCELED,
            NotificationEventType::PAYMENT_WAITING_FOR_CAPTURE,
            NotificationEventType::REFUND_SUCCEEDED,
        );

        $webHookUrl = site_url('/?yookassa=callback', 'https');

        $currentWebHookList = $client->getWebhooks()->getItems();
        foreach ($needWebHookList as $event) {
            $hookIsSet = false;
            foreach ($currentWebHookList as $webHook) {
                if ($webHook->getEvent() === $event) {
                    if ($webHook->getUrl() === $webHookUrl) {
                        $hookIsSet = true;
                        continue;
                    }

                    $client->removeWebhook($webHook->getId());
                }
            }
            if (!$hookIsSet) {
                $client->addWebhook(array('event' => $event, 'url' => $webHookUrl));
            }
        }
    }
}