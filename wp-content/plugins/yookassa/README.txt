=== ЮKassa для WooCommerce ===
Contributors: yoomoney
Tags: юkassa, yookassa, юmoney, yoomoney, woocommerce, payment, gateway
Requires PHP: 5.6.20
Requires at least: 5.2
Tested up to: 6.1
Stable tag: 2.5.2
License: License Agreement
License URI: https://yoomoney.ru/doc.xml?id=527132

Прием платежей на сайтах WooCommerce.
Разработка и поддержка — компания ЮMoney

== Description ==

**Важно**

Плагин «ЮKassa» разработан для WooCommerce 3.7 и выше.

The YooKassa plugin is compatible with WooCommerce version 3.7 or later.

**Описание**

Плагин «ЮKassa» – платежное решение для сайтов на WooCommerce:

* включает 12 способов приема платежей,
* подходит для юрлиц и ИП,
* деньги поступают на банковский счет компании.

**Description**

The YooKassa plugin is the payment solution for websites that use WooCommerce:

* includes 12 payment acceptance methods,
* suitable for companies and entrepreneurs,
* settlements are made to the company's bank account.

**Настройка плагина**

Чтобы принимать платежи через плагин, нужно подать [заявку на подключение ЮKassa](https://yoomoney.ru/joinups) и заключить договор с компанией «ЮMoney» (онлайн).
После этого вы получите нужные настройки.
[Инструкция по установке и настройке плагина](https://yookassa.ru/docs/support/payments/onboarding/integration/cms-module/woocommerce)

**Plugin configuration**

To accept payments via the plugin, apply for onboarding with YooKassa and enter into a contract with YooMoney (online).
We will send you the required settings afterwards.

**Поддержка передачи данных чека**
Если вы настраивали отправку чеков в налоговую через партнеров ЮKassa (по 54-ФЗ), в настройках модуля надо включить отправку данных для чека.
[Помощь ЮKassa отправка чеков по 54-ФЗ](https://yookassa.ru/docs/support/payments/tax-sync)

**We support the transmission of receipts**
If you configured the transmission of receipts to the Tax service via YooKassa (in accordance with Federal Law No. 54-FZ), enable the transmission of receipt data in the settings.
[YooKassa's guide for transmission of receipts in accordance with Federal Law No. 54-FZ](https://yookassa.ru/docs/support/payments/tax-sync?lang=en)

**Тарифы**

Подключение ЮKassa и настройка плагина – бесплатно. Комиссия за прием платежей – от 2,8%.
[Посмотреть все тарифы на сайте ЮKassa](https://yookassa.ru/fees/)

**Rates**
Onboarding with YooKassa and plugin configuration are free of charge. The commission for accepting payments starts at 2.8%.
[View all rates at the YooKassa website](https://yookassa.ru/en/fees/)

**Все возможности ЮKassa**

После подключения ЮKassa доступны:
* 12 способов приема платежей. Карты, электронные кошельки, интернет-банки, сервисы онлайн-кредитования, наличные, баланс телефона. Вы сами выбираете, какие способы нужны, и перечисляете их в договоре. Кнопки оплаты можно разместить на своем сайте или на сайте ЮMoney: выберите подходящий вариант при настройке плагина.
* Личный кабинет на сайте ЮKassa. В нем можно делать возвраты платежей, выставлять и отправлять счета, общаться с менеджерами ЮKassa.

[Перейти на сайт ЮKassa](https://yookassa.ru/)

**All features of YooKassa**

After the onboarding, you can access:

12 payment acceptance methods. Cards, e-wallets, online banking, installment plan services, cash, phone balance. Select the methods by yourself and specify them in the contract. You can place the payment buttons at your website or at the YooKassa website: choose the suitable option when setting up the plugin.
Your own Merchant Profile at the YooKassa website. Use it to make refunds, create and send invoices, or contact the YooKassa manager.
[Visit the YooKassa website](https://yookassa.ru/en/)

== Installation ==

[Инструкция по установке и настройке плагина](https://yookassa.ru/docs/support/payments/onboarding/integration/cms-module/woocommerce)

== Frequently Asked Questions ==

Раздел заполняется

== Screenshots ==

1. Настройки - Шаг 1
2. Настройки - Шаг 2
3. Настройки - Шаг 3
4. Настройки - Шаг 4
5. Настройки - Шаг 5
6. Настройки - Шаг 6
7. Оформление заказа - Выбор способа оплаты
8. Оплата на стороне ЮKassa - Выбор способа оплаты

== Changelog ==
= 2.5.2 =
* Добавлено ограничение на нулевые суммы для самозанятых
* Изменено подключение виджета, удален лишний параметр
* Обновление SDK до версии 2.9.0

= 2.5.1 =
* Отключен способ оплаты Альфа-Клик
* Обновление SDK до версии 2.8.1

= 2.5.0 =
* Добавлена поддержка самозанятых
* Обновлена поддерживаемая версия WooCommerce

= 2.4.4 =
* Обновлен SDK до версии 2.7.5

= 2.4.3 =
* Обновлены поддерживаемые версии WordPress и WooCommerce
* Обновлен SDK до версии 2.6.1

= 2.4.2 =
* Добавлена проверка повторной обработки уже полученных уведомлений при статусе Succeeded

= 2.4.1 =
* Замена названия товара для привязки рекуррента

= 2.4.0 =
* Добавлен метод оплаты СБП с выбором на стороне сайта
* Обновление SDK до версии 2.5.1

= 2.3.3 =
* Исправлена ошибка повторной обработки уже полученных уведомлений от ЮKassa
* Обновление SDK до 2.4.2

= 2.3.2 =
* Добавлена возможность разрешать пользователям сохранять карту после успешной оплаты

= 2.3.1 =
* Добавлена проверка роли пользователя при сохранении настроек (разрешено только administrator и manage_woocommerce)
* Добавлена проверка токена и сам токен в формах настроек для защиты от CSRF
* Обновление SDK до 2.4.1

= 2.3.0 =
* Добавлен способ авторизации в Юkassa через OAuth.
* Добавлена подписка на уведомления через OAuth токен
* Обновлен интерфейс настройки модуля
* Добавлен перевод
* Обновлен SDK до версии 2.3.0

= 2.2.5 =
* Отключен способ оплаты Webmoney
* Обновлен SDK до версии 2.2.6

= 2.2.4 =
* Изменена инициализация виджета
* Обновлен SDK до версии 2.2.5

= 2.2.3 =
* Обновлен SDK до версии 2.2.2

= 2.2.2 =
* Обновлен SDK до версии 2.1.8

= 2.2.1 =
* Очистка корзины при оплате через виджет

= 2.2.0 =
* Замена Сбербанк Онлайн на SberPay
* Исправлена работа по очистке корзины
* Добавлен файл переводов для en локали
* Обновлен SDK до версии 2.1.7

= 2.1.5 =
* Исправление конвертации стоимости товара и доставки

= 2.1.4 =
* Курсы валют с учетом номинала
* Обновлен SDK до версии 2.1.3

= 2.1.3 =
* Заменён файл верификации для ApplePay

= 2.1.2 =
* Поддержка сайтов без ЧПУ
* Обновлен SDK до версии 2.1.2

= 2.1.1 =
* Игнорируем заказы с другими платежными системами

= 2.1.0 =
* Установка системы налогообложения
* Исправлена ошибка пересчета кредитования при изменении способа доставки
* Небольшие поправки
* Обновлен SDK до версии 2.1.0

= 2.0.4 =
* Поддержка плагина WPML при возврате с формы оплаты
* Обновлен SDK до версии 2.0.7

= 2.0.3 =
* Работа вкладок на странице настроек при конфликте bootstrap

= 2.0.2 =
* Форматирование номера телефона для чеков
* Обновлен SDK до версии 2.0.5

= 2.0.1 =
* Сохранение всех попыток оплаты с привязкой к заказу

= 2.0.0 =
* Публикация в магазине приложений
