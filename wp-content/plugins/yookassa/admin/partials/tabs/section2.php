<?php

/* @var int $testMode */
/* @var int $payMode */
/* @var int $isHoldEnabled */
/* @var int $isSbBOLEnabled */
/** @var array $isSaveCard */
/** @var string $wcCalcTaxes */
/** @var string $yookassaNonce */
?>
<form id="yoomoney-form-2" class="yoomoney-form">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 padding-bottom">
                <div class="form-group qa-payment-scenario">
                    <label for="yookassa_pay_mode"><?= __('Сценарий оплаты', 'yookassa'); ?></label>
                    <select id="yookassa_pay_mode" name="yookassa_pay_mode" class="form-control">
                        <option value="0" <?= ($payMode == 0) ? 'selected="selected"' : ''; ?>><?= __('Выбор оплаты на стороне магазина', 'yookassa'); ?></option>
                        <option value="1" <?= $payMode == 1 ? 'selected="selected"' : ''; ?>><?= __('Выбор оплаты на стороне сервиса ЮKassa', 'yookassa'); ?></option>
                    </select>
                    <p class="help-block help-block-error"></p>
                </div>

            </div>
            <div class="col-md-5 col-md-offset-1 help-side qa-payment-scenarios-info">
                <p class="title qa-title"><b><?= __('Способы оплаты', 'yookassa'); ?></b></p>
                <p id="pay-mode-1" class="pay-mode-block qa-text-info" style="<?= ($payMode == 1) ? '' : 'display:none;'; ?>">
                    <?= __('Покупатель выбирает способ оплаты и вводит платёжные данные на странице ЮKassa.', 'yookassa'); ?><br><br>
                    <a class="qa-link" target="_blank" href="https://yookassa.ru/docs/support/payments/accept-methods"><?= __('Подробнее о способах оплаты &gt;', 'yookassa'); ?></a>
                </p>
                <p id="pay-mode-0" class="pay-mode-block" style="<?= ($payMode == 0) ? '' : 'display:none;'; ?>">
                    <?= __('Выберите способы, которые подключены в ЮKassa.', 'yookassa'); ?><br>
                    <?= __('После этого они появятся в платёжной форме на сайте.', 'yookassa'); ?><br><br>
                    <a target="_blank" href="https://yookassa.ru/docs/support/payments/accept-methods"><?= __('Подробнее о способах оплаты &gt;', 'yookassa'); ?></a>
                </p>
            </div>
        </div>

        <div id="save-card" class="qa-save-card" style="<?= ($payMode == 0) ? '' : 'display:none;'; ?>">
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="custom-control custom-switch qa-checkbox">
                        <input type="hidden" name="yookassa_save_card" value="0">
                        <input <?= ($isSaveCard) ? ' checked' : ''; ?> type="checkbox" class="custom-control-input" id="yookassa_save_card" name="yookassa_save_card" value="1">
                        <label class="custom-control-label" for="yookassa_save_card">
                            <?= __('Покупатели могут сохранять данные карты в вашем магазине', 'yookassa'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row padding-bottom">
                <div class="col-md-6 qa-text-info">
                    <p><small class="text-muted"><?= __('Это поможет им быстрее оплачивать следующие покупки — достаточно будет ввести код из пуша или смс, иногда CVC.', 'yookassa'); ?></small></p>
                </div>
            </div>
        </div>

        <div id="yookassa_epl_installments_row" class="row qa-installments-pay-in-order" style="<?=($testMode) ? 'display:none;' : '' ?>">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="yookassa_epl_installments" value="0">
                        <input class="custom-control-input" type="checkbox" id="yookassa_epl_installments" name="yookassa_epl_installments" value="1" <?= get_option('yookassa_epl_installments') == '1' ? ' checked="checked" ' : '' ?>>
                        <label class="custom-control-label" for="yookassa_epl_installments">
                            <?= __('Добавить метод «Заплатить по частям» на страницу оформления заказа', 'yookassa'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row padding-bottom qa-installments-pay-in-product">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="hidden" name="yookassa_add_installments_block" value="0">
                        <input class="custom-control-input" type="checkbox" id="yookassa_add_installments_block" name="yookassa_add_installments_block" value="1" <?= get_option('yookassa_add_installments_block') == '1' ? ' checked="checked" ' : '' ?>>
                        <label class="custom-control-label" for="yookassa_add_installments_block">
                            <?= __('Добавить блок «Заплатить по частям» в карточки товаров', 'yookassa'); ?>
                        </label>
                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="qa-enable-hold">
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="custom-control custom-switch qa-checkbox">
                        <input type="hidden" name="yookassa_enable_hold" value="0">
                        <input <?=($isHoldEnabled)?' checked':'';?> type="checkbox" class="custom-control-input" id="yookassa_enable_hold" name="yookassa_enable_hold" value="1">
                        <label class="custom-control-label" for="yookassa_enable_hold">
                            <?= __('Отложенные платежи', 'yookassa'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row padding-bottom">
                <div class="col-md-6 qa-text-info">
                    <p><small class="text-muted"><?= __('Если опция включена, платежи с карт проходят в 2 этапа: у клиента сумма замораживается, и вам вручную нужно подтвердить её списание – через панель администратора', 'yookassa'); ?></small></p>
                </div>
            </div>
        </div>

        <div class="qa-sbbol">
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="custom-control custom-switch qa-checkbox">
                        <input type="hidden" name="yookassa_enable_sbbol" value="0">
                        <input <?=($isSbBOLEnabled)?' checked':'';?> type="checkbox" class="custom-control-input" id="yookassa_enable_sbbol" name="yookassa_enable_sbbol" value="1" data-toggle="collapse" data-target="#sbbol-collapsible" aria-controls="sbbol-collapsible">
                        <label class="custom-control-label" for="yookassa_enable_sbbol">
                            <?= __('Сбербанк Бизнес онлайн', 'yookassa'); ?>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 qa-text-info">
                    <p><small class="text-muted">
                            <?= __('Если опция включена, вы можете принимать онлайн-платежи от юрлиц через Сбербанк Бизнес Онлайн.', 'yookassa'); ?>
                            <?= __("Подробнее — на <a data-qa-link='https://yookassa.ru/docs/support/payments/extra/b2b-payments' target='_blank' href='https://yookassa.ru/docs/support/payments/extra/b2b-payments'>сайте ЮKassa</a>.", 'yookassa'); ?>
                        </small></p>
                </div>
            </div>
        </div>

        <div id="sbbol-collapsible" class="row in collapse<?=($isSbBOLEnabled)?' show':'';?>">

            <div class="col-md-7">

                <?php $ymSbbolTaxRatesEnum = get_option('yookassa_sbbol_tax_rates_enum'); ?>
                <div class="row">
                    <div class="col-md-5">
                        <label><?= __("Шаблон для назначения платежа", 'yookassa') ?></label>
                    </div>
                    <div class="col-md-7">
                        <textarea type="text" id="yookassa_sbbol_purpose" name="yookassa_sbbol_purpose" class="form-control"
                                  placeholder="<?= __('Заполните поле', 'yookassa'); ?>"><?= $sbbolTemplate ?></textarea>

                        <p><small class="text-muted"><?= __("Это назначение платежа будет в платёжном поручении.", 'yookassa') ?></small></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <label><?= __("Ставка по умолчанию", 'yookassa') ?></label>
                    </div>
                    <div class="col-md-7">
                        <select id="yookassa_default_tax_rate" name="yookassa_sbbol_default_tax_rate">
                            <?php foreach ($ymSbbolTaxRatesEnum as $taxId => $taxName) : ?>
                                <option value="<?php echo $taxId ?>" <?php echo $taxId == get_option('yookassa_sbbol_default_tax_rate') ? 'selected=\'selected\'' : ''; ?>><?php echo $taxName ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p><small class="text-muted"><?= __("Эта ставка передаётся в Сбербанк Бизнес Онлайн, если в карточке товара не указана другая ставка.", 'yookassa') ?></small></p>
                    </div>
                </div>
                <?php if ($wcCalcTaxes == 'yes' && $wcTaxes) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <label><?= __("Сопоставьте ставки НДС в вашем магазине со ставками для Сбербанка Бизнес Онлайн", 'yookassa'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <p><?= __("Ставка НДС в вашем магазине", 'yookassa'); ?></p>
                        </div>
                        <div class="col-sm-7">
                            <p><?= __("Ставка НДС для Сбербанк Бизнес Онлайн", 'yookassa'); ?></p>
                        </div>
                    </div>
                    <?php $ymTaxes = get_option('yookassa_sbbol_tax_rate'); ?>
                    <?php foreach ($wcTaxes as $wcTax) : ?>
                    <div class="row">
                        <div class="col-sm-5"><?= round($wcTax->tax_rate) ?>%</div>
                        <div class="col-sm-7">
                            <?php $selected = isset($ymTaxes[$wcTax->tax_rate_id]) ? $ymTaxes[$wcTax->tax_rate_id] : null; ?>
                            <select id="yookassa_sbbol_tax_rate[<?= $wcTax->tax_rate_id ?>]" name="yookassa_sbbol_tax_rate[<?= $wcTax->tax_rate_id ?>]">
                                <?php foreach ($ymSbbolTaxRatesEnum as $taxId => $taxName) : ?>
                                    <option value="<?php echo $taxId ?>" <?= $selected == $taxId ? 'selected' : ''; ?> >
                                        <?= $taxName ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="col-md-5">
                <div class="info-block">
                    <span class="dashicons dashicons-info" aria-hidden="true"></span>
                    <?= __('При оплате через Сбербанк Бизнес Онлайн есть ограничение: в одном чеке могут быть только товары с одинаковой ставкой НДС. Если клиент захочет оплатить за один раз товары с разными ставками — мы покажем ему сообщение, что так сделать не получится.', 'yookassa'); ?>
                </div>
            </div>
        </div>


        <div class="row form-footer">
            <div class="col-md-12">
                <button class="btn btn-default btn-back qa-back-button" data-tab="section1"><?= __('Назад', 'yookassa'); ?></button>
                <button class="btn btn-primary btn-forward qa-forward-button" data-tab="section3"><?= __('Сохранить и продолжить', 'yookassa'); ?></button>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>
