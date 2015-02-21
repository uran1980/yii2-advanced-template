var appAjaxButtons = appAjaxButtons || {};

// @see http://stackoverflow.com/questions/10896749/what-does-function-function-window-jquery-do
!(function ($) {
    // @see http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/
    "use strict";

    /**
     * @see http://api.jquery.com/ready/
     */
    $(document).ready(function () {
        /**
         * @param el (obj)
         */
        appAjaxButtons.ajaxButtonSubmit = function ( el ) {
            var url         = el.attr('href'),
                icon        = el.find('i'),
                iconClass   = icon.attr('class')
            ;

            if ( el.data('locked') === true ) {
                return false;
            }
            if ( iconClass ) {
                icon.attr('class', 'fa fa-spinner fa-pulse');
            }

            if ( url ) {
                el.data('locked', true);
                $.ajax({
                    type: 'POST',
                    url: url,
                    beforeSend: function ( xhr, settings ) {
                        if ( el.attr('before-send-igrowl-message') ) {
                            // show iGrowl popup message
                            // @see http://catc.github.io/iGrowl/
                            $.iGrowl.prototype.dismissAll('all');
                            $.iGrowl({
                                placement:  {
                                    x: el.attr('placement-x') || 'center',
                                    y: el.attr('placement-y') || 'top'
                                },
                                type:       'notice',
                                delay:      el.attr('delay') || 10000,
                                animation:  false,
                                animShow:   'fadeInDown',
                                animHide:   'fadeOutUp',
                                title:      ':: ' + (el.attr('before-send-igrowl-title').toUpperCase() || 'REQUEST SENT') + ' .:',
                                message:    el.attr('before-send-igrowl-message') || 'Please wait...'
                            });
                        }
                    },
                    success: function ( data ) {
                        $.iGrowl.prototype.dismissAll('all');
                        $.iGrowl({
                            placement:  {
                                x: el.attr('placement-x') || 'center',
                                y: el.attr('placement-y') || 'top'
                            },
                            type:       data.status || 'success',
                            delay:      el.attr('delay') || 2500,
                            animation:  false,
                            animShow:   'fadeInDown',
                            animHide:   'fadeOutUp',
                            title:      ':: ' + (el.attr('success-igrowl-title').toUpperCase() || 'SERVER RESPONSE') + ' .:',
                            message:    el.attr('success-igrowl-message') || 'Success'
                        });
                    },
                }).then(function () {                                           // doneCallbacks (@see http://api.jquery.com/deferred.then/)
                    // dummy
                }, function ( xhr, errorType, exception ) {                     // failCallacks
                    $.iGrowl.prototype.dismissAll('all')
                    $.iGrowl({
                        placement:  {
                            x: el.attr('placement-x') || 'center',
                            y: el.attr('placement-y') || 'top'
                        },
                        type:       'error',
                        delay:      2500,
//                        delay:      60000,                                      // test
                        animation:  false,
                        animShow:   'fadeInDown',
                        animHide:   'fadeOutUp',
                        title:      ':: SERVER ERROR .:',
                        message:    el.attr('error-igrowl-message') || 'Error'
                    });
                }).always(function () {
                    el.data('locked', false);
                    icon.attr('class', iconClass);
                });
            } else if ( iconClass ) {
                icon.attr('class', iconClass);
            }
        };

        /***********************************************************************
         *                          ACTIONS HANDLER
         **********************************************************************/
        appAjaxButtons.actionsHandler = function () {
            $('body').delegate('.btn-ajax', 'click', function () {
                appAjaxButtons.ajaxButtonSubmit($(this));
                return false;
            });
        };

        /***********************************************************************
         *                               INIT
         **********************************************************************/
        appAjaxButtons.init = function () {
            appAjaxButtons.actionsHandler();
        };
        appAjaxButtons.init();
    });
})(window.jQuery);