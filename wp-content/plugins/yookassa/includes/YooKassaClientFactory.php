<?php

use YooKassa\Client;

/**
 * Фабрика для получения единственного статического экземляра клиента API Юkassa
 */
class YooKassaClientFactory
{
    const YOOKASSA_SHOP_ID = 'yookassa_shop_id';
    const YOOKASSA_SHOP_PASSWORD = 'yookassa_shop_password';
    const YOOKASSA_ACCESS_TOKEN_KEY = 'yookassa_access_token';

    const CMS_NAME = 'Wordpress';
    const FRAMEWORK_NAME = 'Woocommerce';
    const MODULE_NAME = 'PaymentGateway';

    /**
     * @var Client
     */
    private static $client;

    /**
     * Возвращает единственный инстанс клиента API Юkassa
     *
     * @return Client
     * @throws Exception
     */
    public static function getYooKassaClient()
    {
        if (!self::$client) {
            self::$client = self::getClient();
        }

        return self::$client;
    }

    /**
     * Возвращает объект клиента API Юkassa
     *
     * @return Client
     * @throws Exception
     */
    private static function getClient()
    {
        $apiClient = new Client();

        $oauthToken = get_option(self::YOOKASSA_ACCESS_TOKEN_KEY);

        if ($oauthToken) {
            $apiClient->setAuthToken($oauthToken);
            self::setApiClientData($apiClient);

            return $apiClient;
        }

        $shopId = get_option(self::YOOKASSA_SHOP_ID);
        $password = get_option(self::YOOKASSA_SHOP_PASSWORD);

        $apiClient->setAuth($shopId, $password);

        self::setApiClientData($apiClient);

        return $apiClient;
    }

    /**
     * Устанавливает значение свойств для user-agent
     *
     * @param $apiClient
     * @return void
     */
    private static function setApiClientData($apiClient)
    {
        $userAgent = $apiClient->getApiClient()->getUserAgent();
        $userAgent->setCms(self::CMS_NAME, get_bloginfo('version'));
        $userAgent->setFramework(self::FRAMEWORK_NAME, WOOCOMMERCE_VERSION);
        $userAgent->setModule(self::MODULE_NAME, YOOKASSA_VERSION);
        $apiClient->setLogger(new YooKassaLogger());
    }
}