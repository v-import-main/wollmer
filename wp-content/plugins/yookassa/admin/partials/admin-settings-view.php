<?php
/**
 * @var array $wcTaxes
 * @var WP_Post[] $pages
 * @var string $wcCalcTaxes
 * @var array $ymTaxRatesEnum
 * @var array $ymTaxes
 * @var string $isHoldEnabled
 * @var string $descriptionTemplate
 * @var string $isReceiptEnabled
 * @var bool $testMode
 * @var string $isDebugEnabled
 * @var string $forceClearCart
 * @var bool|null $validCredentials
 * @var string $active_tab
 * @var bool $isNeededShowNps
 * @var string $yookassaNonce
 */

?>

<!-- Start tabs -->
<h2 class="nav-tab-wrapper">
    <a class="nav-tab <?php echo $active_tab == 'yookassa-settings' ? 'nav-tab-active' : ''; ?>"
       href="?page=yoomoney_api_menu&tab=yookassa-settings">
        <?= __('Настройки модуля ЮKassa для WooCommerce', 'yookassa'); ?>
    </a>
    <a class="nav-tab <?php echo $active_tab == 'yookassa-transactions' ? 'nav-tab-active' : ''; ?>"
       href="?page=yoomoney_api_menu&tab=yookassa-transactions" style="display:none;">
        <?= __('Список платежей через модуль ЮKassa', 'yookassa'); ?>
    </a>
</h2>
<div class="wrap">

    <div class="tab-panel" id="yookassa-settings" <?php echo $active_tab != 'yookassa-settings' ? 'style="display: none;' : ''; ?>>

        <div class="container-max">
            <div class="container-fluid">
                <div class="row padding-bottom">
                    <div class="col-md-12 qa-title">
                        <h2><?= __('Настройки модуля ЮKassa для WooCommerce', 'yookassa'); ?></h2>
                    </div>
                 </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2 qa-module-version">
                        <p><?= __('Версия модуля', 'yookassa') ?> <?= YOOKASSA_VERSION; ?></p>
                    </div>
                    <div class="col-md-8 qa-info-label">
                        <p><?= __("Работая с модулем, вы автоматически соглашаетесь с <a data-qa-link='https://yoomoney.ru/doc.xml?id=527132' href='https://yoomoney.ru/doc.xml?id=527132' target='_blank'>условиями его использования</a>.", 'yookassa'); ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="yoo-tab">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-fill qa-layout-tabs" role="tablist">
                                <li id="tab-section1" class="nav-item" role="presentation">
                                    <a href="#section1" class="nav-link active" role="tab" data-toggle="tab"><?= __('Авторизация', 'yookassa'); ?></a>
                                </li>
                                <li id="tab-section2" class="nav-item" role="presentation">
                                    <a href="#section2" class="nav-link" role="tab" data-toggle="tab"><?= __('Способы оплаты', 'yookassa'); ?></a>
                                </li>
                                <li id="tab-section3" class="nav-item" role="presentation">
                                    <a href="#section3" class="nav-link" role="tab" data-toggle="tab"><?= __('Доп. функции', 'yookassa'); ?></a>
                                </li>
                                <li id="tab-section4" class="nav-item" role="presentation">
                                    <a href="#section4" class="nav-link" role="tab" data-toggle="tab"><?= __('Чеки', 'yookassa'); ?></a>
                                </li>
                                <li id="tab-section5" class="nav-item" role="presentation">
                                    <a href="#section5" class="nav-link" role="tab" data-toggle="tab"><?= __('Настройка уведомлений', 'yookassa');?></a>
                                </li>
                                <li id="tab-section6" class="nav-item" role="presentation">
                                    <a href="#section6" class="nav-link" role="tab" data-toggle="tab"><?= __('Готово', 'yookassa'); ?></a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content tabs">
                                <div role="tabpanel" class="tab-pane fade show active" id="section1"></div>
                                <div role="tabpanel" class="tab-pane fade show" id="section2"></div>
                                <div role="tabpanel" class="tab-pane fade show" id="section3"></div>
                                <div role="tabpanel" class="tab-pane fade show" id="section4"></div>
                                <div role="tabpanel" class="tab-pane fade show" id="section5"></div>
                                <div role="tabpanel" class="tab-pane fade show" id="section6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tab-panel" style="display:none;"
         id="yookassa-transactions" <?php echo $active_tab != 'yookassa-transactions' ? 'style="display: none;' : ''; ?>>
        <form id="events-filter" method="POST">
            <?php
            YooKassaTransactionsListTable::render();
            ?>
            <input name="form_nonce" type="hidden" value="<?=$yookassaNonce?>" />
        </form>
    </div>
</div>
<!-- End tabs -->
