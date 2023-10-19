<?php

/** @var string $descriptionTemplate */
/** @var WP_Post[] $pages */
/** @var bool $forceClearCart */
/** @var bool $isDebugEnabled */
/** @var array $kassaCurrencies */
/** @var string $kassaCurrency */
/** @var string $yookassaNonce */
?>
<form id="yoomoney-form-3" class="yoomoney-form">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-7">
                <div class="form-group qa-payment-description">
                    <label class="control-label qa-title" for="yookassa_description_template">
                        <?= __('Описание платежа', 'yookassa'); ?>
                        <span class="dashicons dashicons-info qa-tooltip-contriol" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Это описание транзакции, которое пользователь увидит при оплате, а вы — в личном кабинете ЮKassa. Например, «Оплата заказа №72». '.
                                  'Чтобы в описание подставлялся номер заказа (как в примере), поставьте на его месте %order_number% (Оплата заказа №%order_number%). '.
                                  'Ограничение для описания — 128 символов.',
                                  'yookassa'); ?>"><span>
                    </label>
                    <textarea type="text" id="yookassa_description_template" name="yookassa_description_template" class="form-control qa-input"
                              placeholder="<?= __('Заполните поле', 'yookassa'); ?>"><?= $descriptionTemplate ?></textarea>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group qa-success-page-data">
                    <label class="control-label qa-title" for="yookassa_success">
                        <?= __('Страница успеха', 'yookassa'); ?>
                        <span class="dashicons dashicons-info qa-tooltip-contriol" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Эту страницу увидит покупатель, когда оплатит заказ', 'yookassa'); ?>"><span>
                    </label>
                    <select id="yookassa_success" name="yookassa_success" class="form-control qa-control">
                        <option value="wc_success" <?php echo((get_option('yookassa_success') == 'wc_success') ? ' selected' : ''); ?>>
                            <?= __('Страница "Заказ принят" от WooCommerce', 'yookassa'); ?>
                        </option>
                        <option value="wc_checkout" <?php echo((get_option('yookassa_success') == 'wc_checkout') ? ' selected' : ''); ?>>
                            <?= __('Страница оформления заказа от WooCommerce', 'yookassa'); ?>
                        </option>
                        <?php
                        if ($pages) {
                            foreach ($pages as $page) {
                                $selected = ($page->ID == get_option('yookassa_success')) ? ' selected' : '';
                                echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="form-group qa-cancel-page-data">
                    <label class="control-label qa-title" for="yookassa_fail">
                        <?= __('Страница отказа', 'yookassa'); ?>
                        <span class="dashicons dashicons-info qa-tooltip-contriol" aria-hidden="true" data-toggle="tooltip"
                              title="<?= __('Эту страницу увидит покупатель, если что-то пойдет не так: например, если ему не хватит денег на карте',
                                  'yookassa'); ?>"><span>
                    </label>
                    <select id="yookassa_fail" name="yookassa_fail" class="form-control qa-control">
                        <option value="wc_checkout" <?= ((get_option('yookassa_fail') == 'wc_checkout') ? ' selected' : ''); ?>>
                            <?= __('Страница оформления заказа от WooCommerce', 'yookassa'); ?>
                        </option>
                        <option value="wc_payment" <?= ((get_option('yookassa_fail') == 'wc_payment') ? ' selected' : ''); ?>>
                            <?= __('Страница оплаты заказа от WooCommerce', 'yookassa'); ?>
                        </option>
                        <?php
                        if ($pages) {
                            foreach ($pages as $page) {
                                $selected = ($page->ID == get_option('yookassa_fail')) ? ' selected' : '';
                                echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>
            </div>
        </div>

        <div class="row"><div class="col-md-7"><hr></div></div>

        <!-- Currency Start-->
        <div class="row">
            <div class="col-md-7">
                <div class="form-group qa-currency-data">
                    <label class="control-label qa-title" for="yookassa_kassa_currency"><?= __('Валюта платежа в ЮKassa', 'yookassa'); ?></label>
                    <select id="yookassa_kassa_currency" name="yookassa_kassa_currency" class="form-control qa-control">
                        <?php foreach ($kassaCurrencies as $code => $title) : ?>
                        <option value="<?= $code ?>"<?= $kassaCurrency == $code ? ' selected' : '' ?>><?= $title ?> (<?= $code ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <p class="help-block qa-currency-match-info"><?= __('Валюты в ЮKassa и в магазине должны совпадать', 'yookassa'); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <div class="custom-control custom-checkbox qa-checkbox">
                        <input type="hidden" name="yookassa_kassa_currency_convert" value="0">
                        <input class="custom-control-input" type="checkbox" id="yookassa_kassa_currency_convert" name="yookassa_kassa_currency_convert" value="1" <?= $kassaCurrencyConvert ? ' checked="checked" ' : '' ?>>
                        <label class="custom-control-label" for="yookassa_kassa_currency_convert">
                            <?= __('Конвертировать сумму из текущей валюты магазина', 'yookassa'); ?>
                        </label>
                    </div>
                    <p class="help-block qa-currency-conversion-info"><?= __('Конвертация по курсу ЦБ РФ.', 'yookassa'); ?></p>
                </div>
            </div>
        </div>
        <!-- Currency End-->

        <div class="row"><div class="col-md-7"><hr></div></div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox qa-cart-checkbox">
                        <input type="hidden" name="yookassa_force_clear_cart" value="0">
                        <input class="custom-control-input" type="checkbox" id="yookassa_force_clear_cart" name="yookassa_force_clear_cart" value="1" <?= $forceClearCart ? ' checked="checked" ' : '' ?>>
                        <label class="custom-control-label" for="yookassa_force_clear_cart">
                            <?= __('Удалить товары из корзины, когда покупатель переходит к оплате', 'yookassa'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group qa-log-data">
                    <div class="custom-control custom-checkbox qa-log-checkbox">
                        <input type="hidden" name="yookassa_debug_enabled" value="0">
                        <input class="custom-control-input" type="checkbox" id="yookassa_debug_enabled" name="yookassa_debug_enabled" value="1" <?= $isDebugEnabled ? ' checked="checked" ' : '' ?>>
                        <label class="custom-control-label" for="yookassa_debug_enabled">
                            <?= __('Запись отладочной информации', 'yookassa'); ?>
                        </label>
                    </div>
                    <p class="help-block help-block-error qa-log-info">
                        <?= __('Настройку нужно будет поменять, только если попросят специалисты ЮMoney', 'yookassa'); ?>
                    </p>
                    <?php if ($isDebugEnabled && file_exists(WP_CONTENT_DIR.'/yookassa-debug.log')): ?>
                        <p>
                            <a class="btn-link qa-log-link" href="<?= content_url(); ?>/yookassa-debug.log"
                               target="_blank" rel="nofollow" download="debug.log"><?= __('Скачать лог', 'yookassa'); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back qa-back-button" data-tab="section2"><?= __('Назад', 'yookassa'); ?></button>
                <button class="btn btn-primary btn-forward qa-forward-button" data-tab="section4"><?= __('Сохранить и продолжить', 'yookassa'); ?></button>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>
