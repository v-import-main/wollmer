<?php

/** @var string $yookassaNonce */
?>
<form id="yoomoney-form-5" class="yoomoney-form">
    <div class="col-md-12">

        <div class="row qa-notification">
            <div class="col-md-6 padding-bottom">
                <div class="row">
                    <div class="col-md-12">
                        <div class="info-block">
                            <span class="dashicons dashicons-info" aria-hidden="true"></span>
                            <p class="qa-info">
                                <?= __("Пропишите URL для уведомлений в <a data-qa-settings-link='https://yookassa.ru/my/shop-settings' target='_blank' href='https://yookassa.ru/my/shop-settings'>настройках личного кабинета ЮKassa</a>.", 'yookassa'); ?><br>
                                <?= __('Он позволит изменять статус заказа после оплаты в вашем магазине.', 'yookassa'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row padding-bottom">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <input type="text" id="notify_url" name="notify_url" class="form-control qa-input" readonly="readonly" aria-describedby="button-copy"
                                   value="<?=site_url('/?yookassa=callback', 'https');?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary copy-button" type="button" id="button-copy" data-toggle="tooltip" data-placement="top"
                                        data-clipboard-text="<?=site_url('/?yookassa=callback', 'https');?>"
                                        data-success="<?=__('Скопировано!', 'yookassa');?>" data-error="<?=__('Попробуйте Ctr+C!', 'yookassa');?>">
                                    <span class="dashicons dashicons-admin-page"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1 help-side">

            </div>
        </div>

        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back qa-back-button" data-tab="section4"><?= __('Назад', 'yookassa'); ?></button>
                <button class="btn btn-primary btn-forward qa-forward-button" data-tab="section6"><?= __('Сохранить и продолжить', 'yookassa'); ?></button>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>