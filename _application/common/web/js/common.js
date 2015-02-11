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

        // TODO


        /***********************************************************************
         *                          ACTIONS HANDLER
         **********************************************************************/
        COMMON.actionsHandler = function () {
            // TODO
        };

        /***********************************************************************
         *                               INIT
         **********************************************************************/
        COMMON.init = function () {
            COMMON.actionsHandler();
            // TODO
        };
        COMMON.init();
    });
})(window.jQuery);