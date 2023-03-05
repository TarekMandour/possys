/*
 Template Name: Admiria - Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Main js
 */

!function ($) {
    "use strict";

    $('#store_id').change(function() {	
        $('#product_id').empty();
        var currenturl = window.location.hostname;
        var oldThis=$(this);
        var $select = $('#store_id');
        var store_id = $('option:selected', $select).attr('store_id');
        var p = {
            store_id:store_id
        
        };
    
        $.post("http://localhost/igold2/admins/product/get_sub_product/", p, function(data){
        
        $('#product_id').append(data);
        });
    });

    $("#page_title").keyup(function(){
		var Text = decodeURIComponent($(this).val());
		Text = Text.toLowerCase();
		Text = Text.replace(/\s/g,'_');
		Text = Text.replace(/[^\u0100-\uFFFF\w\-]/g,'_');
		Text = Text.replace(/^-+/, '');
		Text = Text.replace(/-+$/, '');
		$("#page_slug").val(Text);    
    });
    
    $("#page_title2").keyup(function(){
		var Text = decodeURIComponent($(this).val());
		Text = Text.toLowerCase();
		Text = Text.replace(/\s/g,'_');
		Text = Text.replace(/[^\u0100-\uFFFF\w\-]/g,'_');
		Text = Text.replace(/^-+/, '');
		Text = Text.replace(/-+$/, '');
		$("#page_slug2").val(Text);    
    });
    
    $('#cat_id').change(function(){

        var $select = $('#cat_id');
        var cat_id = $('option:selected', $select).attr('cat_id');

        var p = { cat_id:cat_id };
        $.post("http://localhost/igold2/admins/category/cat_item", p, function(data){

            var result = '<option price_type="" value="">---</option>'

            if (JSON.parse(data).is_fix == 1) {
                result += '<option price_type="1" value="1">سعر ثابت</option>';
            } 
            if (JSON.parse(data).is_var == 1) {
                result += '<option price_type="2" value="2">سعر متغير</option>';
            } 
            if (JSON.parse(data).is_sale == 1) {
                result += '<option price_type="3" value="3">سعر عرض</option>';
            }
            
            document.getElementById("price_type").innerHTML = result;

            if (JSON.parse(data).is_caliber == 1) {
                document.getElementById("caliber").style.display = 'block';
            } else {
                document.getElementById("caliber").style.display = 'none';
            }

            if (JSON.parse(data).is_carat == 1) {
                document.getElementById("carat").style.display = 'block';
            } else {
                document.getElementById("carat").style.display = 'none';
            }

            if (JSON.parse(data).is_size == 1) {
                document.getElementById("size").style.display = 'block';
            } else {
                document.getElementById("size").style.display = 'none';
            }

        });

    });

    $('#price_type').change(function(){

        var $select = $('#price_type');
        var price_type = $('option:selected', $select).attr('price_type');

        if (price_type == 1 ) {
            document.getElementById('price').style.display = 'block';
            document.getElementById('sale_price').style.display = 'none';
            document.getElementById('sale').style.display = 'none';
            document.getElementById('wp_price').style.display = 'none';
            document.getElementById('profit_gm').style.display = 'none';
        } else if (price_type == 2) {
            document.getElementById('price').style.display = 'none';
            document.getElementById('sale_price').style.display = 'none';
            document.getElementById('sale').style.display = 'none';
            document.getElementById('wp_price').style.display = 'block';
            document.getElementById('profit_gm').style.display = 'block';
        } else if (price_type == 3) {
            document.getElementById('price').style.display = 'none';
            document.getElementById('sale_price').style.display = 'block';
            document.getElementById('sale').style.display = 'block';
            document.getElementById('wp_price').style.display = 'none';
            document.getElementById('profit_gm').style.display = 'none';;
        } else {
            document.getElementById('price').style.display = 'none';
            document.getElementById('sale_price').style.display = 'none';
            document.getElementById('sale').style.display = 'none';
            document.getElementById('wp_price').style.display = 'none';
            document.getElementById('profit_gm').style.display = 'none';
        }
    });

    var MainApp = function () {
        this.$body = $("body"),
            this.$wrapper = $("#wrapper"),
            this.$btnFullScreen = $("#btn-fullscreen"),
            this.$leftMenuButton = $('.button-menu-mobile'),
            this.$menuItem = $('.has_sub > a')
    };
    //scroll
    MainApp.prototype.initSlimscroll = function () {
        $('.slimscrollleft').slimscroll({
            height: 'auto',
            position: 'right',
            size: "10px",
            color: '#9ea5ab'
        });
    },
        //left menu
        MainApp.prototype.initLeftMenuCollapse = function () {
            var $this = this;
            this.$leftMenuButton.on('click', function (event) {
                event.preventDefault();
                $this.$body.toggleClass("fixed-left-void");
                $this.$wrapper.toggleClass("enlarged");
            });
        },
        //left menu
        MainApp.prototype.initComponents = function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        },
        //full screen
        MainApp.prototype.initFullScreen = function () {
            var $this = this;
            $this.$btnFullScreen.on("click", function (e) {
                e.preventDefault();

                if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                    }
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            });
        },
        //full screen
        MainApp.prototype.initMenu = function () {
            var $this = this;
            $this.$menuItem.on('click', function () {
                var parent = $(this).parent();
                var sub = parent.find('> ul');

                if (!$this.$body.hasClass('sidebar-collapsed')) {
                    if (sub.is(':visible')) {
                        sub.slideUp(300, function () {
                            parent.removeClass('nav-active');
                            $('.body-content').css({height: ''});
                            adjustMainContentHeight();
                        });
                    } else {
                        visibleSubMenuClose();
                        parent.addClass('nav-active');
                        sub.slideDown(300, function () {
                            adjustMainContentHeight();
                        });
                    }
                }
                return false;
            });

            //inner functions
            function visibleSubMenuClose() {
                $('.has_sub').each(function () {
                    var t = $(this);
                    if (t.hasClass('nav-active')) {
                        t.find('> ul').slideUp(300, function () {
                            t.removeClass('nav-active');
                        });
                    }
                });
            }

            function adjustMainContentHeight() {
                // Adjust main content height
                var docHeight = $(document).height();
                if (docHeight > $('.body-content').height())
                    $('.body-content').height(docHeight);
            }
        },
        MainApp.prototype.activateMenuItem = function () {
            // === following js will activate the menu in left side bar based on url ====
            $("#sidebar-menu a").each(function () {
                var pageUrl = window.location.href.split(/[?#]/)[0];
                if (this.href == pageUrl) {
                    $(this).addClass("active");
                    $(this).parent().addClass("active"); // add active to li of the current link
                    $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                    $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
                    $(this).parent().parent().prev().click(); // click the item to make it drop
                }
            });
        },
        MainApp.prototype.Preloader = function () {
            $(window).on('load', function() {
                $('#status').fadeOut();
                $('#preloader').delay(200).fadeOut('slow');
                $('body').delay(200).css({
                    'overflow': 'visible'
                });
            });
        },
        MainApp.prototype.ToggleSearch = function () {
            $('.toggle-search').on('click', function () {
                var targetId = $(this).data('target');
                var $searchBar;
                if (targetId) {
                    $searchBar = $(targetId);
                    $searchBar.toggleClass('open');
                }
            });
        },
        MainApp.prototype.init = function () {
            this.initSlimscroll();
            this.initLeftMenuCollapse();
            this.initComponents();
            this.initFullScreen();
            this.initMenu();
            this.activateMenuItem();
            this.Preloader();
            this.ToggleSearch();
        },
        //init
        $.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.MainApp.init();
    }(window.jQuery);