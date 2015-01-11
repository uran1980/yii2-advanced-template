var COMMON = COMMON || {};

// @see http://stackoverflow.com/questions/10896749/what-does-function-function-window-jquery-do
!(function ($) {
    // @see http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/
    "use strict";

    $.fn.hasScrollBar = function () {
        var el = this.get(0);

        return (el && el.scrollHeight > this.height()) ? true : false;
    };

    /**
     * @see http://api.jquery.com/ready/
     */
    $(document).ready(function () {
        COMMON.xhr = [];

        /***********************************************************************
         *                      APPLICATION METHODS
         **********************************************************************/
        COMMON.xhrAbort = function () {
            // clear prev AJAX requests...
            $.each(COMMON.xhr, function () {
                try{ this.abort(); }catch(ex){}
            });
            COMMON.xhr = [];
        };

        COMMON.spoiler = {
            init: function () {
                $(".spoiler-title.closed:not(.initialized)").closest('.spoiler').find('.spoiler-content:first').hide();
                $(".spoiler-title.opened:not(.initialized)").closest('.spoiler').find('.spoiler-content:first').show();

                $(".spoiler-title:not(.initialized)").each(function() {
                    $(this).addClass('initialized');
                    COMMON.spoiler.indication($(this));
                });
            },
            toggle: function (obj) {
                obj.closest('.spoiler').find('.spoiler-content:first').toggle();
            },
            indication: function (obj) {
                if (obj.closest('.spoiler').find('.spoiler-content:first').is(":hidden") ) {
                    obj.removeClass('opened').addClass('closed');
                    obj.find('.spoiler-indicator:first').addClass('icon-plus').removeClass('icon-minus');
                } else {
                    obj.removeClass('closed').addClass('opened');
                    obj.find('.spoiler-indicator:first').addClass('icon-minus').removeClass('icon-plus');
                }
            }
        };

        // TODO


        /***********************************************************************
         *                          ACTIONS HANDLER
         **********************************************************************/
        COMMON.actionsHandler = function () {
            // -------------------- SCROLL TO TOP BUTTON -----------------------
            $(window).scroll(function() {
                if ( $(this).scrollTop() > 500 ) {
                    $('.scroll-to-top-link').attr('href', '').fadeIn();
                }
                else {
                    $('.scroll-to-top-link').fadeOut();
                }
            });
            $('.scroll-to-top-link').click(function () {
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                return false;
            });

            // -------------------------- SPOILER ------------------------------
            $('body').delegate('.spoiler-title', 'click', function() {
                COMMON.spoiler.toggle($(this));
                COMMON.spoiler.indication($(this));
            });

            // TODO
        };

        /***********************************************************************
         *                               INIT
         **********************************************************************/
        COMMON.init = function () {
            COMMON.actionsHandler();
            COMMON.spoiler.init();
            // TODO
        };

        /***********************************************************************
         *                              START
         **********************************************************************/
        COMMON.init();
    });
})(window.jQuery);