/*
 Template Name: Admiria - Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Nestable Init
 */

!function($) {
    "use strict";

    var Nestable = function() {};

    //init
    Nestable.prototype.init = function() {

        // activate Nestable for list 2
        $('#nestable_list_2').nestable({
            maxDepth: 0,
            noDragClass:'dd-nodrag'
        });

        $('#nestable_list_menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('#nestable_list_3').nestable();
    },
    //init
    $.Nestable = new Nestable, $.Nestable.Constructor = Nestable
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.Nestable.init()
}(window.jQuery);
