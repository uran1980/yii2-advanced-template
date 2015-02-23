var appTranslate = appTranslate || {};

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
         * @param data (object)
         */
        appTranslate.save = function (data) {
            var element = data.element,
                row     = element.closest('tr')
            ;
            row.addClass('success');
        };

        /**
         * @param data (object)
         */
        appTranslate.delete = function (data) {
            var element = data.element,
                row     = element.closest('tr')
            ;
            row.addClass('danger').fadeOut('slow');
        };

        /**
         * set lang direaction
         *
         * @var element (obj)
         */
        appTranslate.setElementLangDirection = function ( element ) {
            var elements = element || $('.tab-pane.active textarea');

            $(elements).each(function () {
                var lang = $(this).attr('rel') || 'en';

                if ( $.isEmptyObject(this) )
                    return;

                // set lang dir
                if ( 'ar' === lang ) {
                    $(this).attr('dir', 'rtl');
                } else {
                    $(this).attr('dir', 'ltr');
                }
            });
        };

        /**
         * @param element (object)
         */
        appTranslate.fullScreen = function (element) {
            // TODO

            // debug info ------------------------------------------------------
            try{console.debug({
                 TODO: 'translations fullScreen...',
                 element: element
            });}catch(ex){}
            // -----------------------------------------------------------------
        };

        /**
         * @param element (object)
         */
        appTranslate.copy = function (element) {
            // TODO

            // debug info ------------------------------------------------------
            try{console.debug({
                 TODO: 'copy translation from source message...',
                 element: element
            });}catch(ex){}
            // -----------------------------------------------------------------
        };

        /***********************************************************************
         *                          ACTIONS HANDLER
         **********************************************************************/
        appTranslate.actionsHandler = function () {
            $(document).on('ajaxButtonSubmit', function (event, data) {
                if ( data.action === 'translation-save' ) {
                    appTranslate.save(data);
                }
            });
            $(document).on('ajaxButtonSubmit', function (event, data) {
                if ( data.action === 'translation-delete' ) {
                    appTranslate.delete(data);
                }
            });
            $('body').delegate('.translation-fullscreen', 'click', function () {
                appTranslate.fullScreen($(this));
                return false;
            });
            $('body').delegate('.translation-copy-from-source', 'click', function () {
                appTranslate.copy($(this));
                return false;
            });
        };

        /***********************************************************************
         *                               INIT
         **********************************************************************/
        appTranslate.init = function () {
            appTranslate.actionsHandler();
            appTranslate.setElementLangDirection();
        };
        appTranslate.init();
    });
})(window.jQuery);