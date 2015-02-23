var appAjaxButtons = appAjaxButtons || {};

// @see http://stackoverflow.com/questions/10896749/what-does-function-function-window-jquery-do
!(function ($) {
    // @see http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/
    "use strict";

    /**
     * @see http://api.jquery.com/ready/
     */
    $(document).ready(function () {
        /***********************************************************************
         *                              METHODS
         **********************************************************************/
        /**
         * @param element (obj)
         */
        appAjaxButtons.ajaxButtonSubmit = function ( element ) {
            var url         = element.attr('href'),
                icon        = element.find('i'),
                iconClass   = icon.attr('class')
            ;

            if ( element.data('locked') === true ) {
                return false;
            }
            if ( iconClass ) {
                icon.attr('class', 'fa fa-spinner fa-pulse');
            }

            if ( url ) {
                element.data('locked', true);
                $.ajax({
                    type: 'POST',
                    url: url,
                    beforeSend: function ( xhr, settings ) {
                        if ( element.attr('before-send-igrowl-message') ) {
                            // show iGrowl popup message
                            // @see http://catc.github.io/iGrowl/
                            $.iGrowl.prototype.dismissAll('all');
                            $.iGrowl({
                                placement:  {
                                    x: element.attr('placement-x') || 'center',
                                    y: element.attr('placement-y') || 'top'
                                },
                                type:       'notice',
                                delay:      element.attr('delay') || 10000,
                                animation:  false,
                                animShow:   'fadeInDown',
                                animHide:   'fadeOutUp',
                                title:      ':: ' + (element.attr('before-send-igrowl-title').toUpperCase() || 'REQUEST SENT') + ' .:',
                                message:    element.attr('before-send-igrowl-message') || 'Please wait...'
                            });
                        }
                    },
                    success: function ( data ) {
                        $.iGrowl.prototype.dismissAll('all');
                        $.iGrowl({
                            placement:  {
                                x: element.attr('placement-x') || 'center',
                                y: element.attr('placement-y') || 'top'
                            },
                            type:       data.status || 'success',
                            delay:      element.attr('delay') || 2500,
                            animation:  false,
                            animShow:   'fadeInDown',
                            animHide:   'fadeOutUp',
                            title:      ':: ' + (element.attr('success-igrowl-title').toUpperCase() || 'SERVER RESPONSE') + ' .:',
                            message:    element.attr('success-igrowl-message') || 'Success'
                        });

                        // triger event
                        $(document).trigger('ajaxButtonSubmit', {
                            element: element,
                            url: url,
                            action: element.attr('action'),
                            data: data
                        });
                    },
                }).then(function () {                                           // doneCallbacks (@see http://api.jquery.com/deferred.then/)
                    // dummy
                }, function ( xhr, errorType, exception ) {                     // failCallacks
                    $.iGrowl.prototype.dismissAll('all')
                    $.iGrowl({
                        placement:  {
                            x: element.attr('placement-x') || 'center',
                            y: element.attr('placement-y') || 'top'
                        },
                        type:       'error',
                        delay:      2500,
//                        delay:      60000,                                      // test
                        animation:  false,
                        animShow:   'fadeInDown',
                        animHide:   'fadeOutUp',
                        title:      ':: SERVER ERROR .:',
                        message:    xhr.responseText || 'Error'
                    });
                }).always(function () {
                    element.data('locked', false);
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