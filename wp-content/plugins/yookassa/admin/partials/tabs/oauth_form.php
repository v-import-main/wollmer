<?php
/**
 * @var int $validCredentials
 * @var bool $isOauthTokenGotten
 * @var bool $isTestShop
 * @var bool $isFiscalizationEnabled
 * @var int $shopId
 */
?>
<div class="col-md-12 oauth-form">
    <?php if ($isOauthTokenGotten) : ?>
        <?php if ($validCredentials === 0 && $shopId) : ?>
            <div class="row qa-oauth-info">
                <div class="col-md-6">
                    <?=$isTestShop
                        ? '<p class="qa-shop-type" data-qa-shop-type="test">' .  __('Тестовый магазин', 'yookassa') . '</p>'
                        : '<p class="qa-shop-type" data-qa-shop-type="prod">' .  __('Боевой магазин', 'yookassa') . '</p>'
                    ?>
                    <?=$shopId
                        ? '<p class="qa-shop-id" data-qa-shop-id="' . $shopId . '">Shop ID: ' . $shopId . '</p>'
                        : ''
                    ?>
                    <?=$isFiscalizationEnabled
                        ? '<p class="qa-fiscalization" data-qa-fiscalization="enabled">' .  __('Фискализация включена', 'yookassa') . '</p>'
                        : '<p class="qa-fiscalization" data-qa-fiscalization="disabled">' .  __('Фискализация отключена', 'yookassa') . '</p>'
                    ?>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group">
                <p class="help-block help-block-error">
                    <?= __('Произошла ошибка. Пожалуйста, смените магазин по&nbsp;кнопке ниже, чтобы сюда автоматически подгрузились правильные данные.', 'yookassa'); ?>
                </p>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="row form-footer">
                    <div class="col-md-12">
                        <button class="btn btn-default btn_oauth_connect qa-change-shop-button">
                            <?= __('Сменить магазин', 'yookassa'); ?>
                        </button>
                        <?php if ($validCredentials === 0) : ?>
                        <button class="btn btn-primary btn-forward qa-forward-button skip-send" data-tab="section2">
                            <?= __('Сохранить и продолжить', 'yookassa'); ?>
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="row">
            <div class="col-md-6 padding-bottom">
                <h5><?= __('Свяжите ваш сайт на WooCommerce с личным кабинетом ЮKassa', 'yookassa') ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <button class="btn btn-default btn_oauth_connect qa-connect-shop-button">
                    <?= __('Подключить магазин', 'yookassa'); ?>
                </button>
            </div>
        </div>

    <?php endif; ?>
</div>