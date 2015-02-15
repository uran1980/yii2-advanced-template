var appCommon = appCommon || {};

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
        appCommon.xhr = [];

        /***********************************************************************
         *                      APPLICATION METHODS
         **********************************************************************/
        appCommon.xhrAbort = function () {
            // clear prev AJAX requests...
            $.each(appCommon.xhr, function () {
                try{ this.abort(); }catch(ex){}
            });
            appCommon.xhr = [];
        };

        // TODO


        /***********************************************************************
         *                          ACTIONS HANDLER
         **********************************************************************/
        appCommon.actionsHandler = function () {
            // TODO
        };

        /***********************************************************************
         *                               INIT
         **********************************************************************/
        appCommon.init = function () {
            appCommon.actionsHandler();
            // TODO
        };
        appCommon.init();
    });
})(window.jQuery);