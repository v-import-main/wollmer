(function ($) {
    'use strict';

    function activeTab(tab) {
        $('.yoo-tab .nav-tabs a[href="#' + tab + '"]').tab('show');
    }
    function settingsModeChange () {
        let $mode = $('#shop-mode');
        $('.tooltip-text').hide();
        $('#tooltip-' + $mode.val()).show();
        $('.nav-tabs > li').hide();
    }
    /**
     * Show tooltip with text
     * @param elem
     * @param msg
     * @param autohide
     */
    function showTooltip(elem, msg, autohide) {
        $(elem).tooltip({trigger: 'manual', title: msg}).tooltip('show');
        if (autohide !== undefined) {
            setTimeout(function () {
                $(elem).tooltip('hide');
            }, autohide);
        }
    }

    function buttonToggle () {
        $(document).on('click', '.btn-toggle', function() {
            $(this).find('.btn').toggleClass('active');
            if ($(this).find('.btn-primary').size()>0) {
                $(this).find('.btn').toggleClass('btn-primary');
            }
            if ($(this).find('.btn-danger').size()>0) {
                $(this).find('.btn').toggleClass('btn-danger');
            }
            if ($(this).find('.btn-success').size()>0) {
                $(this).find('.btn').toggleClass('btn-success');
            }
            if ($(this).find('.btn-info').size()>0) {
                $(this).find('.btn').toggleClass('btn-info');
            }
            $(this).find('.btn').toggleClass('btn-default');
        });
    }

    /**
     * Get array of form field names
     * @param form
     * @returns {[]}
     */
    function getAllFormInputs(form) {
        let fields = [];
        form.find('input,select,textarea').each(function (index, elm) {
            if (elm.name) {
                fields.push(elm.name.replace(/\[(.+)\]/g,''));
            }
        });
        return $.unique(fields);
    }

    buttonToggle();
    let clip = new ClipboardJS('button.copy-button');
    clip.on('success', function (e) {
        showTooltip(e.trigger, $(e.trigger).data('success'), 1000);
    });
    clip.on('error', function (e) {
        showTooltip(e.trigger, $(e.trigger).data('error'), 1000);
    });
    $(document).on('click', 'button.copy-button', function(e) { e.preventDefault(); });
    $(document).on('click', 'button.btn-forward', function(e) {
        e.preventDefault();
        let self = $(this).prop('disabled', true);
        if (self.hasClass('skip-send')) {
            activeTab(self.data('tab'));
            return;
        }
        let post = self.closest('.yoomoney-form').serializeArray();
        let fields = getAllFormInputs(self.closest('.yoomoney-form'));
        post.push({name: 'page_options', value: fields.join(',')});
        $.post(ajaxurl + '?action=yookassa_save_settings', post, function (res) {
            if (res.status === 'success') {
                activeTab(self.data('tab'));
            } else {
                console.log(res);
                self.prop('disabled', false);
            }
        });
    });
    $(document).on('click', 'button.btn-back', function(e) {
        e.preventDefault();
        activeTab($(this).data('tab'));
    });
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let target = $(e.target).attr("href");
        $(target).html('<div class="text-center offset-md-1"><div class="loader"></div></div>');
        $.ajax({
            url: ajaxurl,
            data: {
                action: 'yookassa_get_tab',
                tab: target.replace('#', '')
            },
            method : 'GET',
            success : function (data) {
                $(target).html(data);
                $(target).find('[data-toggle="tooltip"]').tooltip();
                $(target).find('#yookassa_pay_mode').on('change', function(e){
                    $('.pay-mode-block').hide();
                    $('#pay-mode-' + $(this).val()).show();
                    const saveCardBlock = $('div#save-card');
                    $(this).val() == '0' ? saveCardBlock.show() : saveCardBlock.hide();
                });
            },
            error : function(error){ console.log(error) }
        });
    });
    $('a[data-toggle="tab"].active').trigger('shown.bs.tab');

    function getRadioValue(elements) {
        for (let i = 0; i < elements.length; ++i) {
            if (elements[i].checked) {
                return elements[i].value;
            }
        }
        return elements.length ? elements[0].value : null;
    }

    function triggerPaymentMode(value) {
        if (value == '0') {
            $('.selectPayShop').slideUp();
            $('.selectPayKassa').slideDown();
        } else {
            $('.selectPayShop').slideDown();
            $('.selectPayKassa').slideUp();
        }
    }

    let paymentMode = $('input[name=yookassa_pay_mode]');
    paymentMode.change(function () {
        triggerPaymentMode(this.value);
    });
    triggerPaymentMode(getRadioValue(paymentMode));

    let yoomoneyNpsClose = $('.yoomoney_nps_close');
    function yoomoney_nps_close() {
        $.post(yoomoneyNpsClose.data('link'), {action: 'vote_nps'})
            .done(function () {
                $('.yoomoney_nps_block').slideUp();
            });
    }

    function yoomoney_nps_goto() {
        window.open('https://yandex.ru/poll/5f1ioMjEgV4Ha3DixySw3f');
        yoomoney_nps_close();
    }

    $('.yoomoney_nps_link').on('click', yoomoney_nps_goto);
    yoomoneyNpsClose.on('click', yoomoney_nps_close);

    /**
     * Событие на кнопки Подключить магазин и Сменить магазин
     */
    $(document).on('click', 'button.btn_oauth_connect', function(e) {
        $(this).attr('disabled', true);
        $(this).text('');
        $(this).html('<span class="spinner-border spinner-border-sm qa-spinner"></span>');
        e.preventDefault()
        fetchOauthLink();
    })

    /**
     * Перезагрузка страницы при закрытии алерта об ошибке подключения через OAuth
     */
    $(document).on('click', '.auth-error-alert .close', function(e) {
        location.reload();
    });

    /**
     * Запрос на бэк для получения ссылки на авторизацию в OAuth
     */
    function fetchOauthLink() {
        $.get(ajaxurl + '?action=yookassa_get_oauth_url',
            {},
            function (response) {
                showOauthWindow(response.oauth_url);
            })
            .fail(function(jqXHR, textStatus, error){
                $('.auth-error-alert').removeClass('d-none');
                if (typeof jqXHR.responseJSON == "undefined") {
                    console.error(jqXHR, textStatus, error);
                    return;
                }
                console.error(jqXHR.responseJSON.error, textStatus, error);
            });
    }

    /**
     * Показ окна с авторизацией в OAuth
     * @param url - Ссылка в OAuth
     */
    function showOauthWindow(url) {
        const oauthWindow = window.open(
            url,
            'Авторизация',
            'width=600,height=600, top='+((screen.height-600)/2)+', left='+((screen.width-600)/2 + window.screenLeft)+', menubar=no, toolbar=no, location=no, resizable=yes, scrollbars=no, status=yes');

        const timer = setInterval(function() {
            if(oauthWindow.closed) {
                if(oauthWindow.closed) {
                    clearInterval(timer);
                    getOauthToken();
                }
            }
        }, 1000);
    }

    /**
     * Инициализация получения OAuth токена
     */
    function getOauthToken() {
        $.get(ajaxurl + '?action=yookassa_get_oauth_token',
            {},
            function (res) {
                $('a[data-toggle="tab"].active').trigger('shown.bs.tab');
        })
            .fail(function(jqXHR, textStatus, error){
                $('.auth-error-alert').removeClass('d-none');
                if (typeof jqXHR.responseJSON == "undefined") {
                    console.error(jqXHR, textStatus, error);
                    return;
                }
                console.error(jqXHR.responseJSON.error, textStatus, error);
            });
    }

    /**
     * Переключение radio button между СМЗ и ИП
     */
    $(document).on('click', '.custom-switch-radio label', function() {
        $('div.content').hide().filter('.'+$(this).data('target')).show();
    });

})(jQuery);