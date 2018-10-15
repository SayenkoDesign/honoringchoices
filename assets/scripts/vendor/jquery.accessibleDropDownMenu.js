/**
 * accessibleDropDownMenu.js
 *
 * jquery.accessibleDropDownMenu.js
 * @version   2.0 | 14th January 2014
 * @author    Beau Charman | @beaucharman | http://www.beaucharman.github.io
 * @link      https://gist.github.com/beaucharman/7348970 | 
 *            http://jsfiddle.net/beaucharman/X2ArC/
 * @license   MIT license
 */
 
;(function ($) {

    "use strict";

    $.fn.accessibleDropDownMenu = function (options) {

         var settings = $.extend({
            'item': 'li',
            'anchor': 'a'
        }, options);

        /* Grab the element instance */
        var menu = $(this);

        /* Drop down menu support for IE 6 */
        $(settings.item, menu).mouseover(function () {

            $(this).addClass('focus');

        }).mouseout(function () {

            $(this).removeClass('focus');
        });

        /* Drop Down menu keyboard accessible via :focus */
        $(settings.anchor, menu).focus(function () {

            $(this).parents(settings.item).addClass('focus');

        }).blur(function () {

            $(this).parents(settings.item).removeClass('focus');
        });

    };

})(jQuery);
