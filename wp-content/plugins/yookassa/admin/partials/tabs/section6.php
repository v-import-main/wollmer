<?php

/** @var string $yookassaNonce */
?>
<form id="yoomoney-form-6" class="yoomoney-form">
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-12 text-center qa-success-info">
                <div class="label-container icon_name_checkmark-green qa-success-icon"></div>
                <h4 class="success"><?= __('Всё готово, чтобы принимать платежи', 'yookassa') ?></h4>
                <p><?= __('Вы можете вернуться и изменить настройки в любой момент', 'yookassa') ?></p>
            </div>
        </div>
        <div class="row form-footer">
            <div class="col-md-12 text-center">
                <button class="btn btn-default btn-back qa-back-to-settings-button" data-tab="section1" style="margin:0;"><?= __('К настройкам', 'yookassa') ?></button>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>
