<?php
/**
 * @var int $validCredentials
 * @var int $isOauthTokenGotten
 * @var string $shopId
 * @var string $password
 * @var string $yookassaNonce
*/
?>
<?php if (!$isOauthTokenGotten && $shopId): ?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6 padding-bottom">
            <h5><?= __('Свяжите ваш сайт на WooCommerce с личным кабинетом ЮKassa', 'yookassa') ?></h5>
        </div>
    </div>
</div>
<form id="yoomoney-form-1" class="yoomoney-form">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="yookassa_shop_id">shopId</label>
                    <input type="text" id="yookassa_shop_id" name="yookassa_shop_id"
                           value="<?php echo $shopId; ?>" class="form-control"
                           placeholder="<?= __('Заполните поле', 'yookassa'); ?>" />
                    <p class="help-block help-block-error"></p>
                </div>
                <div class="form-group">
                    <label for="yookassa_shop_password"><?= __('Секретный ключ', 'yookassa') ?></label>
                    <input type="text" id="yookassa_shop_password" name="yookassa_shop_password"
                           value="<?php echo $password ?>" class="form-control"
                           placeholder="<?= __('Заполните поле', 'yookassa'); ?>" />
                    <p class="help-block help-block-error"></p>
                </div>
                <?php if (!$isOauthTokenGotten && $validCredentials !== 0) : ?>
                <div class="form-group">
                    <p class="help-block help-block-error">
                        <?= __('Кажется, есть ошибка в&nbsp;ShopID или секретном ключе. Пожалуйста, смените магазин по&nbsp;кнопке ниже, чтобы сюда автоматически подгрузились правильные данные.', 'yookassa'); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-5 col-md-offset-1 help-side">
                <p class="title"><b><?= __('Где найти ShopID и секретный ключ', 'yookassa'); ?></b></p>
                <p><?= __('Данные автоматически подтянутся сюда из&nbsp;личного кабинета. Для этого нажмите на&nbsp;<b>Сменить магазин</b>:<br>&mdash;&nbsp;во&nbsp;всплывающем окне войдите в&nbsp;ЮKassa<br>&mdash;&nbsp;разрешите поделиться данными с&nbsp;WooCommerce', 'yookassa'); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="row form-footer">
                    <div class="col-md-12">
                        <button class="btn btn-default btn_oauth_connect qa-change-shop-button">
                            <?= __('Сменить магазин', 'yookassa'); ?>
                        </button>
                        <button class="btn btn-primary btn-forward" data-tab="section2">
                            <?= __('Сохранить и продолжить', 'yookassa'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
</form>
<?php
    else: include(plugin_dir_path(__FILE__) . 'oauth_form.php');
    endif;
?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="row mt-3 auth-error-alert d-none qa-connect-error-block">
                <div class="col-md-8 col-lg-9">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?= __('Ошибка', 'yookassa'); ?>!</strong>
                        <span><?= __('Пожалуйста, попробуйте перезагрузить страницу и сменить магазин ещё раз.', 'yookassa'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>