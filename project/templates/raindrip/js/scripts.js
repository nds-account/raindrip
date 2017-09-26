//var siteURL = 'http://raindripv2.dev';
var siteURL = 'http://raindrip.thesmackpack.com/';
var shopatronKey = 'g8rpsyr2';

var dropped = false;
$(document).ready(function() {



    $('.tabs').on('click', function(e){
        e.preventDefault();
        var idTab = $(this).attr('id');

        $('.inthekit-wrapper').addClass('hidden');
        $('.tabs').addClass('inactive-tab');


        if (idTab== 'container-tab-clicker')
        {
            $('#container-tab-detail').removeClass('hidden');
            $(this).removeClass('inactive-tab');
        }

        if (idTab== 'flower-tab-clicker')
        {
            $('#flower-tab-detail').removeClass('hidden');
            $(this).removeClass('inactive-tab');
        }


        if (idTab== 'ground-tab-clicker')
        {
            $('#ground-tab-detail').removeClass('hidden');
            $(this).removeClass('inactive-tab');
        }

        if (idTab== 'vegetable-tab-clicker')
        {
            $('#vegetable-tab-detail').removeClass('hidden');
            $(this).removeClass('inactive-tab');
        }

    });


    $('.datepicker-input').datepicker();


    $(".datepicker-input").click(function() {

        // FIND IMAGES FOR THIS PREVIEW (CURRENT PRODUCT)
        $('.datepicker').css('position','absolute');

    });



    // GET ACTUAL CART ITEMS Q
    var actualQ = getCookie('cartQuantity');

    if (actualQ==''){
        actualQ = 0;
    }
    $('#cartQQ').html(actualQ);

    // BEGIN - FANCYBOX SCRIPTS
    //$(".fancybox").fancybox();


    $("#fancybox-manual-c").click(function() {

        // FIND IMAGES FOR THIS PREVIEW (CURRENT PRODUCT)

        var src = $('#main-image-for-product-detail').attr('src');
        var title = $('#main-image-for-product-detail').attr('data-name');

        $.fancybox.open([
        {
            href : src,
            title : title
        }/*, {
            href : '2_b.jpg',
            title : '2nd title'
        }, {
            href : '3_b.jpg'
        }*/
        ], {

        });
    });


    $("#main-image-for-product-detail").click(function() {

        // FIND IMAGES FOR THIS PREVIEW (CURRENT PRODUCT)

        var src = $(this).attr('src');
        var title = $(this).attr('data-name');

        $.fancybox.open([
        {
            href : src,
            title : title
        }/*, {
            href : '2_b.jpg',
            title : '2nd title'
        }, {
            href : '3_b.jpg'
        }*/
        ], {

        });
    });
    // END - FANCYBOX SCRIPTS

    /* BEGIN - EXPAND & REPAIR / CALCULATOR SCRIPTS */

    //I want to expand from the Point Source (2)
    $('#calculate-2').on('click', function(e){

	    //checking values if all 0 showing warning message and doesn't expand
	    cnt = 0;
	    $('#hide-system .numericInput').each(function (i) {
		    if ($(this).val() > 0)
			    cnt++;
	    });
	    if (!cnt) {
	      $('#hide-system .numericInput').effect("highlight", {color: '#ffff99'}, 2000);
		    return false;
	    }

        e.preventDefault();

        $('.will-need-wrapper').show();

        // TREES
        threeTubbingQ = Math.ceil( ($('#trees-distance').val()/50));
        $('#tree-tubing-q').val(threeTubbingQ);
        $('#tree-tubing-link').attr('data-quantity',threeTubbingQ);


        threeEmittersQ = parseInt((  parseInt($('#trees-shorter').val()*3 )) + (  parseInt($('#trees-taller').val()*5 ) )) ;
        $('#tree-emitters-q').val(threeEmittersQ);
        $('#tree-emitter-link').attr('data-quantity',threeEmittersQ);

        threeStakesQ = Math.ceil( (threeEmittersQ/10));
        $('#tree-stakes-q').val(threeStakesQ);
        $('#tree-stake-link').attr('data-quantity',threeStakesQ);


        // SHRUBS
        shrubTubbingQ = Math.ceil( ($('#shrub-distance').val()/50));
        $('#shrub-tubbing-q').val(shrubTubbingQ);
        $('#shrub-tubing-link').attr('data-quantity',shrubTubbingQ);

        shrubEmittersQ = parseInt((  parseInt($('#shrub-shorter').val()*1 )) + (  parseInt($('#shrub-taller').val()*2 ) )) ;
        $('#shrub-emitters-q').val(shrubEmittersQ);
        $('#shrub-emitter-link').attr('data-quantity',shrubEmittersQ);

        shrubStakesQ = Math.ceil( (shrubEmittersQ/10));
        $('#shrub-stakes-q').val(shrubStakesQ);
        $('#shrub-stake-link').attr('data-quantity',shrubStakesQ);


        // CONTAINER
        containerTubbingQ = Math.ceil( ($('#container-distance').val()/50));
        $('#container-tubbing-q').val(containerTubbingQ);
        $('#container-tubing-link').attr('data-quantity',containerTubbingQ);

        containerEmittersQ = parseInt((  parseInt($('#container-smaller').val()*1 )) + (  parseInt($('#container-larger').val()*2 ) )) ;
        $('#container-emitters-q').val(containerEmittersQ);
        $('#container-emitter-link').attr('data-quantity',containerEmittersQ);

        containerStakesQ = Math.ceil( (containerEmittersQ/10));
        $('#container-stakes-q').val(containerStakesQ);
        $('#container-stake-link').attr('data-quantity',containerStakesQ);


        // PLANTER
        planterTubbingQ = Math.ceil( ($('#planter-additional').val()/50));
        $('#planter-tubing-q').val(planterTubbingQ);
        $('#planter-tubing-link').attr('data-quantity',planterTubbingQ);

        planterEmittersQ = ($('#planter-additional').val());
        $('#planter-emitters-q').val(planterEmittersQ);
        $('#planter-emitter-link').attr('data-quantity',planterEmittersQ);

        planterStakesQ = Math.ceil( (planterEmittersQ/10));
        $('#planter-stakes-q').val(planterStakesQ);
        $('#planter-stake-link').attr('data-quantity',planterStakesQ);


        // GROUND
        groundTubbingQ = Math.ceil( ($('#ground-additional').val()/50));
        $('#ground-tubing-q').val(groundTubbingQ);
        $('#ground-tubing-link').attr('data-quantity',groundTubbingQ);

        groundEmittersQ = Math.ceil( ($('#ground-additional').val()/6.5));
        $('#ground-emitters-q').val(groundEmittersQ);
        $('#ground-emitter-link').attr('data-quantity',groundEmittersQ);


        // SCROLL TO youwillneed;
        $('html,body').animate({
            scrollTop: $('#youwillneed').offset().top
        }, 'fast');

    });


    $('.shopatron-add-to-cart-calculator').on('click', function(e){
        e.preventDefault();

        var thisProductId = $(this).attr('data-shopatronprodid');
        var productLink = $(this).attr('data-productLink');
        var quantity = $(this).attr('data-quantity');

        var addedQ = quantity;

        if ( isNaN( quantity ) || quantity=='0' || quantity==''  ){
            shopatronMessage('Please enter a valid quantity', 'An error has occurred');
            return false;
        }

        url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
        params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": '+quantity+' ,"productLink": "'+siteURL+productLink+'"}';

        func_response = $.ajax({
            type: "post",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){

                shopatronMessage('Failed to add item to cart', 'An error has occurred');
                return false;
            },

            success: function(data){
                // success info
                shopatronMessage('successfully added item to cart', 'Item added to Cart', 'cart');
                //console.log(data);

                // UPDATE CART QUANTITY COOCKIE
                var actualQ = getCookie('cartQuantity');
                if (actualQ== ''){
                    actualQ = 0;
                }

                actualQ = parseInt(actualQ)+parseInt(addedQ);
                createCookie('cartQuantity',actualQ);
                $('#cartQQ').html(actualQ);

            }
        });
    });


    $(".numericInput").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    /* end - EXPAND & REPAIR / CALCULATOR SCRIPTS */


    // BEGIN - PRODUCT DETAIL TABS BEHAVIOUR
    $('.show-tab').on('click', function(e){
        e.preventDefault();
        var tab = $(this).attr('data-id');
        $('.specs-body').hide();
        $('#'+tab).show();
        $('.tabs').children('li').removeClass('selected-tab');
        $(this).parent('li').addClass('selected-tab');
    });
    // END - PRODUCT DETAIL TABS BEHAVIOUR

    // BEGIN - FAQ-ELEMENT BEHAVIOUR */
    $('.faqlist-item').on('click', function(e){

        e.preventDefault();
        var thisElementId = $(this).attr('data-id');

        if ($(this).hasClass('collapsed')){
            $(this).removeClass('collapsed');
            $(this).addClass('opened');

            $('#separator-'+thisElementId).slideDown('fast');
            $('#paragraph-'+thisElementId).slideDown('fast');

        }
        else{
            $('#separator-'+thisElementId).hide();
            $('#paragraph-'+thisElementId).hide();
            $(this).removeClass('opened');
            $(this).addClass('collapsed');
        }
    });

    // END - FAQ-ELEMENT BEHAVIOUR */


    // BEGIN - CONTACT FOR FUNCTIONS
    $("#submit-btn").on("click",function(e){

        e.preventDefault();
        e.stopPropagation();
        $('#overlay').show();

        var name = $('#name').val().trim();
        var lastname = $('#lastname').val().trim();
        var email = $('#email').val().trim();
        var state = $('#state').val().trim();
        var gender = $('#gender').val().trim();
        var help = $('#help').val().trim();
        var product = $('#product').val().trim();

        if(state=='' || email=='' || name==''  || lastname == '' || gender == '' || help == '' || product == ''  || validateEmail(email)==false){

            $('#spinner-loader').hide();
            new Messi('<span class="messi-msg">Please complete all fields.</span>', {
                modal: true,
                title: 'Missing Information',
                titleClass: 'error',
                buttons: [{
                    id: 0,
                    label: 'CLOSE',
                    val: 'X'
                }]
            });
            return false;
        }
        else
        {
            // SEND EMAIL
            url = '/templates/raindrip/sendMail.php';
            params = 'Name='+name+'&Email='+email+'&State='+state+'&Lastname='+lastname+'&Gender='+gender+'&Help='+help+'&Product='+product;

            func_response = $.ajax({
                type: "post",
                data: params,
                url: url,
                beforeSend: function(){

                    $('#overlay').show();
                    $('#spinner-loader').show();
                },

                error: function(){

                    new Messi('<span class="messi-msg">An error has occurred while trying to send your message. Please try again in a few minutes.</span>', {
                        modal: true,
                        title: 'Message not sent',
                        titleClass: 'error',
                        buttons: [{
                            id: 1,
                            label: 'CLOSE',
                            val: 'X'
                        }]
                    });
                    return false;
                },

                success: function(data){
                    $('#overlay').show();
                    $('#spinner-loader').hide();

                    msg = 'An error has occurred while trying to send your message. Please try again in a few minutes.';
                    tit = 'Message not sent';

                    if (data== '1'){
                        msg = 'Thank you! We will contact you soon!';
                        tit = 'Your message has been sent';

                        $('#name').val('');
                        $('#lastname').val('');
                        $('#email').val('');
                        $('#state').val('');
                        $('#gender').val('');
                        $('#help').val('');
                        $('#product').val('');
                    }

                    new Messi('<span class="messi-msg">'+msg+'</span>', {
                        modal: true,
                        title: tit,
                        titleClass: 'error',
                        buttons: [{
                            id: 1,
                            label: 'CLOSE',
                            val: 'X'
                        }]
                    });
                    return false;
                }
            });
        }

    });

    $( "body" ).on( "click", ".btn", function( e ) {
        $('#overlay').hide();
    });



    $('.toggle-mulch-ctc').on( "click", function( e ) {

        var activeImage = $('.house-container').children('img').attr('src');
        if (activeImage == '/templates/raindrip/images/home-house-full.png'){
            $('.house-container').children('img').attr('src','/templates/raindrip/images/home-house-mulch.png');
            $('.radio-inner').css('background-color','#0597D3');

        }
        else{
            $('.house-container').children('img').attr('src','/templates/raindrip/images/home-house-full.png');
            $('.radio-inner').css('background-color','#0597D3');
            $('.radio-inner').css('background-color','#fff');
        }

    });



    $(".toggle-mulch-ctc").on("mouseenter",function(e){
        $('#mulch-link').css('text-decoration','underline');
    });

    $(".toggle-mulch-ctc").on("mouseleave",function(e){
        $('#mulch-link').css('text-decoration','none');
    });



    $('.toggle-mulch-ctc').on( "click", "a", function( e ) {
        e.preventDefault();
        var activeImage = $('.house-container').children('img').attr('src');

        if (activeImage == '/templates/raindrip/images/home-house-full.png'){

            $('.house-container').closest('img').attr('src','/templates/raindrip/images/home-house-mulch.png');
            $('.radio-inner').css('background-color','#0597D3');
        }
        else{
            /*alert('no');*/
            $('.house-container').closest('img').attr('src','/templates/raindrip/images/home-house-full.png');
            $('.radio-inner').css('background-color','#0597D3');
            $('.radio-inner').css('background-color','#fff');
        }

    });

    /* FLOATING MENU */

    jQuery(window).scroll(function(){

        if ($(document).height() > 1500){
            topvalue = jQuery(window).scrollTop();
            offset=150;
            if (topvalue>offset ){
                $('aside .nav').addClass('floating-menu');
            }
            else{
                $('aside .nav').removeClass('floating-menu');
            }
        }
    });

    $('#configurator-video-wrapper').html('<iframe width="317" height="192" src="http://www.youtube.com/embed/Op_kKfOh4JY"  allowfullscreen style="padding-left:7px"></iframe>');

    $('#configurator-video-wrapper-2').html('<iframe width="317" height="192" src="http://www.youtube.com/embed/A4AOoYQ65Z4"  allowfullscreen style="padding-left:7px"></iframe>');

    $('#wheretobuy-frame').html('<iframe src="http://hosted.where2getit.com/nds/raindrip.html" width="1000" height="1050" scrolling="no" frameborder="0"> </iframe>');

    /* BEGIN - PRODUCT DETAIL IMAGE CHANGES */
    $('.product-image-detail').on('click', function(e){

        e.preventDefault();

        // GET ACTUALMIMAGE SRC
        var newSrc = $(this).attr('src');
        $('#main-image-for-product-detail').fadeOut(500, function() {
            $('#main-image-for-product-detail').attr("src",newSrc);
            $('#main-image-for-product-detail').fadeIn(500);
        });
    });
    /* END - PRODUCT DETAIL IMAGE CHANGES */


    /* BEGIN - RESOURCES MENU NAVIGATION */
    $('.static-menu').on('click', function(e){
        e.preventDefault();
        var toDiv = $(this).attr('title');
        window.location.href = "#/"+toDiv;
        $('html,body').animate({
            scrollTop: $('#'+toDiv).offset().top
        }, 'fast');

        // SELECT THIS SECTION
        $('.menu').children('li').removeClass(' current active ');
        $('.submenu').children('li').children('a').removeClass(' current active ');
        $('.submenu').children('li').removeClass(' current active ');

        $('.submenu').children('li').children('a').removeClass(' active-submenu ');

        $(this).closest('li').addClass(' current active ');


        var title = $(this).closest('a').attr('title');

        if ( title == 'kits'){
            $(this).closest('a').addClass('active-submenu');
        }

        if ( title == 'wheretobuy'){
            $(this).closest('a').addClass('active-submenu');
        }
        if ( title == 'tubing'){
            $(this).closest('a').addClass('active-submenu');
        }
        if ( title == 'emitters'){
            $(this).closest('a').addClass('active-submenu');
        }

        if ( title == 'fittings'){
            $(this).closest('a').addClass('active-submenu');
        }


    });

    var currentHash = window.location.hash;

    if (currentHash == '#/catalogs'){
        $('html,body').animate({
            scrollTop: $('#catalogs').offset().top
        }, 'fast');
    }

    if (currentHash == '#/faq'){
        $('html,body').animate({
            scrollTop: $('#faq').offset().top
        }, 'fast');
    }

    if (currentHash == '#/videos'){
        $('html,body').animate({
            scrollTop: $('#videos').offset().top
        }, 'fast');
    }
    /* END - RESOURCES MENU NAVIGATION */




    $('.expand-item').on('click', function(e){

        e.preventDefault();
        var thisElementId = $(this).attr('data-id');

        if ($(this).hasClass('collapsed')){
            $(this).removeClass('collapsed');
            $(this).addClass('opened');

            $('#separator-'+thisElementId).slideDown('fast');
            $('#paragraph-'+thisElementId).slideDown('fast');

            // show title
            $('#closed-'+thisElementId).hide();

        }
        else{
            $('#separator-'+thisElementId).hide();
            $('#paragraph-'+thisElementId).hide();
            $(this).removeClass('opened');
            $(this).addClass('collapsed');
            $('#closed-'+thisElementId).show();
        }
    });

    $('#expandable-2').on('click', function(e){

        e.preventDefault();
        $('#separator-2').hide();
        $('#paragraph-2').hide();
        $(this).closest('li').removeClass('opened');
        $(this).closest('li').addClass('collapsed');
        $('#closed-2').show();
        $('#closed-2').css('display','block');
    });



    $('#closed-2').on('click', function(e){
        e.preventDefault();
        $(this).closest('li').removeClass('collapsed');
        $(this).closest('li').addClass('opened');
        $('#separator-2').slideDown('fast');
        $('#paragraph-2').slideDown('fast');
        $('#closed-2').hide();
    });

    /* BEGIN - SHOPATRON FUNCTIONS  */
    /* BEGIN - SHOPATRON FUNCTIONS  */
    /* BEGIN - SHOPATRON FUNCTIONS */


    /* BEGIN -  ADDING TO CART FUNCTION */

    /*
    $('.shopatron-add-to-cart').on('click', function(e){
        e.preventDefault();

        var thisProductId = $(this).attr('data-shopatronprodid');
        var productLink = $(this).attr('data-productLink');

        url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
        params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": 1,"productLink": "'+siteURL+productLink+'"}';

        func_response = $.ajax({
            type: "post",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){

                shopatronMessage('Failed to add item to cart', 'An error has occurred');
                return false;
            },

            success: function(data){
                // success info
                shopatronMessage('successfully added item to cart', 'Item added to Cart');
                // UPDATE CART QUANTITY COOCKIE
                var actualQ = getCookie('cartQuantity');

                if (actualQ== ''){
                    actualQ = 0;
                }

                actualQ = parseInt(actualQ)+parseInt(1);
                createCookie('cartQuantity',actualQ);
                $('#cartQQ').html(actualQ);

            }
        });
    });
*/

    $( "body" ).on( "click", ".shopatron-add-to-cart", function( e ) {
        e.preventDefault();

        var thisProductId = $(this).attr('data-shopatronprodid');
        var productLink = $(this).attr('data-productLink');

        url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
        params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": 1,"productLink": "'+siteURL+productLink+'"}';

        func_response = $.ajax({
            type: "post",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){

                shopatronMessage('Failed to add item to cart', 'An error has occurred');
                return false;
            },

            success: function(data){
                // success info
                shopatronMessage('successfully added item to cart', 'Item added to Cart', 'cart');
                // UPDATE CART QUANTITY COOCKIE
                var actualQ = getCookie('cartQuantity');

                if (actualQ== ''){
                    actualQ = 0;
                }

                actualQ = parseInt(actualQ)+parseInt(1);
                createCookie('cartQuantity',actualQ);
                $('#cartQQ').html(actualQ);

            }
        });

    });



    /* END -  ADDING TO CART FUNCTION */



    /* BEGIN - ADD ALL PRODUCTS TO CART */
    $('#all-all-to-cart').on('click', function(e){
        e.preventDefault();

        var error = false;
        var errorMessage = '';

        var itemQuantified =  false;
        $('#overlay').show();
        $('#wait-msg').show();
        $('#spinner-loader').show();

        setTimeout(function(){

            $(".shopatron-add-to-cart-calculator").each(function( ) {

                var q = $(this).attr('data-quantity');
                if (q>0){
                    itemQuantified = true;
                    // add to cart this product
                    var thisProductId = $(this).attr('data-shopatronprodid');
                    var productLink = $(this).attr('data-productLink');
                    var quantity = $(this).attr('data-quantity');

                    var addedQ = quantity;
                    url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
                    params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": '+quantity+' ,"productLink": "'+siteURL+productLink+'"}';

                    func_response = $.ajax({
                        type: "post",
                        data: params,
                        async: false,
                        url: url,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        beforeSend: function(){

                        },

                        error: function(){

                            error = true;
                            errorMessage+='<br/>Failed to add item '+thisProductId+' to cart</br>';

                        },

                        success: function(data){
                            // UPDATE CART QUANTITY COOCKIE
                            var actualQ = getCookie('cartQuantity');

                            if (actualQ== ''){
                                actualQ = 0;
                            }
                            actualQ = parseInt(actualQ)+parseInt(addedQ);
                            createCookie('cartQuantity',actualQ);
                            $('#cartQQ').html(actualQ);
                        }
                    });

                }

            });

            if ( itemQuantified == false ){
                $('#wait-msg').hide();
                shopatronMessage('Please select at least one product for adding to the cart', 'Please select at least one product');
            }
            else{

                if (error == false){
                    $('#wait-msg').hide();
                    shopatronMessage('Successfully added items to cart', 'Shopping List items added to Cart');
                }
                else{
                    $('#wait-msg').hide();
                    shopatronMessage('Some items have not been added to Cart due to a unknown error <br/>'+errorMessage, 'Shopping List items added to Cart');
                }
            }
        }, 500);
    });

    $('#lower-addtocart').on('click', function(e){
        e.preventDefault();

        var error = false;
        var errorMessage = '';

        var itemQuantified =  false;
        $('#overlay').show();
        $('#wait-msg').show();
        $('#spinner-loader').show();

        setTimeout(function(){

            $(".shopatron-add-to-cart-calculator").each(function( ) {

                var q = $(this).attr('data-quantity');
                if (q>0){
                    itemQuantified = true;
                    // add to cart this product
                    var thisProductId = $(this).attr('data-shopatronprodid');
                    var productLink = $(this).attr('data-productLink');
                    var quantity = $(this).attr('data-quantity');

                    var addedQ = quantity;
                    url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
                    params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": '+quantity+' ,"productLink": "'+siteURL+productLink+'"}';

                    func_response = $.ajax({
                        type: "post",
                        data: params,
                        async: false,
                        url: url,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        beforeSend: function(){

                        },

                        error: function(){

                            error = true;
                            errorMessage+='<br/>Failed to add item '+thisProductId+' to cart</br>';

                        },

                        success: function(data){
                            // UPDATE CART QUANTITY COOCKIE
                            var actualQ = getCookie('cartQuantity');

                            if (actualQ== ''){
                                actualQ = 0;
                            }
                            actualQ = parseInt(actualQ)+parseInt(addedQ);
                            createCookie('cartQuantity',actualQ);
                            $('#cartQQ').html(actualQ);
                        }
                    });

                }

            });

            if ( itemQuantified == false ){
                $('#wait-msg').hide();
                shopatronMessage('Please select at least one product for adding to the cart', 'Please select at least one product');
            }
            else{

                if (error == false){
                    $('#wait-msg').hide();
                    shopatronMessage('Successfully added items to cart', 'Shopping List items added to Cart', 'cart');
                }
                else{
                    $('#wait-msg').hide();
                    shopatronMessage('Some items have not been added to Cart due to a unknown error <br/>'+errorMessage, 'Shopping List items added to Cart', 'cart');
                }
            }
        }, 500);
    });

    //

    /* END - ADD ALL PRODUCTS TO CART */




    /* BEGIN -  ADDING TO CART FUNCTION (QUANTITY SELECTED) */
    $('.shopatron-add-to-cart-quantity').on('click', function(e){
        e.preventDefault();

        var thisProductId = $(this).attr('data-shopatronprodid');
        var productLink = $(this).attr('data-productLink');
        var quantity = $('#quantity').val();

        var addedQ = quantity;

        if ( isNaN( quantity ) || quantity=='0' ){
            shopatronMessage('Please enter a valid quantity', 'An error has occurred');
            return false;
        }

        url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/?api_key='+shopatronKey;
        params = '{"product":"http://product.shopatron.com/product/'+thisProductId+'?api_key='+shopatronKey+'","catalogID": 1,"quantity": '+quantity+' ,"productLink": "'+siteURL+productLink+'"}';

        func_response = $.ajax({
            type: "post",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){

                shopatronMessage('Failed to add item to cart', 'An error has occurred');
                return false;
            },

            success: function(data){
                // success info
                shopatronMessage('successfully added item to cart', 'Item added to Cart');
                //console.log(data);

                // UPDATE CART QUANTITY COOCKIE
                var actualQ = getCookie('cartQuantity');

                if (actualQ== ''){
                    actualQ = 0;
                }
                actualQ = parseInt(actualQ)+parseInt(addedQ);
                createCookie('cartQuantity',actualQ);
                $('#cartQQ').html(actualQ);

            }
        });
    });
    /* END -  ADDING TO CART FUNCTION (QUANTITY SELECTED) */


    /* BEGIN - UPDATE QUANTITY OF PRODUCT IN CART */
    $( "#cartContent" ).on( "click", ".update-itme-btn", function( e ) {
        e.preventDefault();

        var productId = $(this).attr('data-productId');
        var newQuantity = $('#q_'+productId).val();

        if ( isNaN( newQuantity ) || newQuantity=='0' ){
            shopatronMessage('Please enter a valid quantity, to remove a product from the cart, please click the REMOVE link below the product name.', 'An error has occurred');
            return false;
        }
        // API CALL TO UPDATE CART QUANTITY AND PRODUCTS
        url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/'+productId+'/quantity?api_key='+shopatronKey;
        params = newQuantity;
        //alert(newQuantity);

        func_response = $.ajax({
            type: "put",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){
                shopatronMessage('Failed to update item in cart. Please try again.', 'An error has occurred');
                return false;
            },

            success: function(data){
                //shopatronMessage('successfully updated item in cart', 'Item successfuly updated in Cart');
                window.location.href = "/cart";
            }
        });
    /* END - UPDATE QUANTITY OF PRODUCT IN CART */

    });


    $( "#cartContent" ).on( "click", ".remove-fromcart", function( e ) {
        e.preventDefault();

        var productId = $(this).attr('data-productId');
        removeFromCart(productId);
    });


    /* BEGIN - PERFORM CHECKOUT API CALL */
    $( "#cartContent" ).on( "click", "#cart-checkout", function( e ) {
        e.preventDefault();
        url = 'http://product.shopatron.com/cart/'+cartId+'/checkout?api_key='+shopatronKey;
        params = '{"catalogID": 1}';

        func_response = $.ajax({
            type: "post",
            data: params,
            url: url,
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            beforeSend: function(){

                $('#overlay').show();
                $('#spinner-loader').show();
            },

            error: function(){
                shopatronMessage('Failed to Checkout. Please try again later', 'An error has occurred');
                return false;
            },

            success: function(data){
                // success info
                //shopatronMessage('successfully Checkout', 'Item successfuly Checkout');
                window.location.href = data.checkoutLink;
            }
        });

    });
    /* END - PERFORM CHECKOUT API CALL */

    /* END - SHOPATRON FUNCTIONS  */
    /* END - SHOPATRON FUNCTIONS  */
    /* END - SHOPATRON FUNCTIONS */





    // BEGIN - NEW KITS PAGE SCRIPTS
    jQuery(window).scroll(function(){

        topvalue = jQuery(window).scrollTop();
        offsetAbout=151;

        if (topvalue<10){
            // reset drip drop animation
            dropped = false;

            $('.drip').removeClass('fallen-drip');
            $('.benefit-img-icon').removeClass('lightblue-border');

        }

        if (parseInt(topvalue)>parseInt(offsetAbout) ){
            $('#subNav').addClass('sticky-navbar');
        /*$('.pipe-repeat-bkg').css('top','579px');
                        $('.water-repeat').css('top','579px');*/

        }
        else{
            $('#subNav').removeClass('sticky-navbar');
        /*$('.pipe-repeat-bkg').css('top','626px');
                        $('.water-repeat').css('top','626px');*/
        }

        waterOffset = 495;
        if( topvalue > waterOffset){
            waterHeight = parseInt(topvalue) - parseInt(waterOffset)+140;
            $('.water-repeat').css('height',waterHeight+'px');
        }
        else{
            $('.water-repeat').css('height','0px');
        }


        fallDrip = 883;

        if( parseInt(topvalue) >= parseInt(fallDrip) ){
            $('.drip').addClass('fallen-drip');

            $('.benefit-img-icon').addClass('lightblue-border');

            if (dropped==false){
                // ANIMATE BORDER
                setTimeout(function(){
                    $('#highlight1').css('opacity','1');
                },1000);

                setTimeout(function(){
                    $('#highlight1').css('opacity','0');
                },1600);

                setTimeout(function(){
                    $('#highlight2').css('opacity','1');
                },1700);


                setTimeout(function(){
                    $('#highlight2').css('opacity','0');
                },2300);


                setTimeout(function(){
                    $('#highlight3').css('opacity','1');
                },2400);


                setTimeout(function(){
                    $('#highlight3').css('opacity','0');
                },3000);


                setTimeout(function(){
                    $('#highlight4').css('opacity','1');
                },3100);


                setTimeout(function(){
                    $('#highlight4').css('opacity','0');
                },3700);


                setTimeout(function(){
                    $('#highlight5').css('opacity','1');
                },3800);


                setTimeout(function(){
                    $('#highlight5').css('opacity','0');
                },4400);

            }

            dropped=true;

        }

        // check selected Element

        hasClass = $('#subNav').hasClass('sticky-navbar');
        if (hasClass == true){
            offset = 30;
        }
        else{
            offset = 65;
        }

        if (topvalue>570 && topvalue<1610){
            $('.navig').removeClass('selected-kit-menu');
            $('#link-our').addClass('selected-kit-menu');
        }

        if (topvalue>=1610 && topvalue<2748){
            $('.navig').removeClass('selected-kit-menu');
            $('#link-how').addClass('selected-kit-menu');
        }

        if (topvalue>=2748 && topvalue<3643){
            $('.navig').removeClass('selected-kit-menu');
            $('#link-in').addClass('selected-kit-menu');
        }

        if (topvalue>=3643 ){
            $('.navig').removeClass('selected-kit-menu');
            $('#link-expand').addClass('selected-kit-menu');
        }
    });

    /*

    $(".button-circle").mouseover(function(e) {

        setTimeout(function(){
            $('.detail').css('z-index','5000');
            $('.detail').fadeIn('slow');
        },400);
    });


    $(".detail").mouseleave(function(e) {
        $('.detail').hide();
        $('.detail').css('z-index','2');
    });


    $(".button-circle").mouseleave(function(e) {
        $('.detail').hide();
        $('.detail').css('z-index','2');
    });

*/

    $(".navig").click(function(e) {

        e.preventDefault();
        selectedMenu = true;
        var url = $(this).attr('data-url');
        if (url == 'expandCustomize' || url == 'inTheKits')
            offset = 10;
        else
            offset = 50;


        $('html,body').animate({
            scrollTop: $('#'+url).offset().top-offset
        }, 'slow', function(){
            selectedMenu = false;
        });

        $(this).addClass('selected-kit-menu');
    });

    // END - NEW KITS PAGE SCRIPTS

    // BEGIN  - NEW EXPAND AND REPAIR SCRIPTS

    $("#arrow-1").click(function(e) {

        e.preventDefault();
        $('.will-need-wrapper').hide();
        $('#inner-system').slideUp('fast');
        $('#dripsystem').addClass('gray-bkg');
        $('#title-on-hide').show();

    });
    $("#openarrow-1").click(function(e) {

        e.preventDefault();
        $('#inner-system').slideDown('fast');
        $('#dripsystem').removeClass('gray-bkg');
        $('#title-on-hide').hide();
    /* $('.will-need-wrapper').show();*/
    });


    $("#arrow-2").click(function(e) {

        e.preventDefault();
        $('#inner-spinkler').slideUp('fast');
        $('#sprinkler').addClass('gray-bkg');
        $('#title-on-hide-sprinkler').show();

    });
    $("#openarrow-2").click(function(e) {

        e.preventDefault();
        $('#inner-spinkler').slideDown('fast');
        $('#sprinkler').removeClass('gray-bkg');
        $('#title-on-hide-sprinkler').hide();
    });

    // END  - NEW EXPAND AND REPAIR SCRIPTS


    /* PRODUCT TABS */
    $("#flower-tab").click(function(e) {
        e.preventDefault();
        $('.tabs-small').addClass('inactive-tab-small');
        $(this).removeClass('inactive-tab-small');

        var innerHTML = $('#flower-content').html();
        $('#main-tabinfo').html(innerHTML);
    });


    $("#ground-tab").click(function(e) {
        e.preventDefault();
        $('.tabs-small').addClass('inactive-tab-small');
        $(this).removeClass('inactive-tab-small');

        var innerHTML = $('#ground-content').html();
        $('#main-tabinfo').html(innerHTML);
    });



    $("#container-tab").click(function(e) {
        e.preventDefault();
        $('.tabs-small').addClass('inactive-tab-small');
        $(this).removeClass('inactive-tab-small');

        var innerHTML = $('#container-content').html();
        $('#main-tabinfo').html(innerHTML);
    });


    $("#vegetable-tab").click(function(e) {
        e.preventDefault();
        $('.tabs-small').addClass('inactive-tab-small');
        $(this).removeClass('inactive-tab-small');

        var innerHTML = $('#vegetable-content').html();
        $('#main-tabinfo').html(innerHTML);
    });


    $(".circle").mouseover(function(e) {
        e.preventDefault();
        /*
        $('.detail').removeClass('active-step');
        $(this).children('.detail').addClass('active-step');*/

        setTimeout(function(){

            },800);


    });


    $(".circle").mouseleave(function(e) {
        e.preventDefault();
        $(this).children('.detail').removeClass('active-step');
    });

	jQuery("#emailTrigger").leanModal({ top : 200, overlay : 0.4, closeButton: ".modal_close" });

	jQuery(document).on('click', '.show-cart', function () {
		window.location.href = "/cart";
	});

});

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function shopatronMessage ( message, title, cart ) {

    $('#spinner-loader').hide();
    $('#overlay').show();

		buttons_arr = [{
			id: 1,
			label: 'CLOSE',
			val: 'X'
		}];

		if (typeof cart !== 'undefined') {
			if (cart == 'cart') {
				buttons_arr = [{
					id: 1,
					label: 'CLOSE',
					val: 'X'
				},
					{
					id: 2,
					label: 'CART',
					class: 'show-cart'
				}];
			}
		}

    new Messi('<span class="messi-msg">'+message+'</span>', {
        modal: true,
        title: title,
        titleClass: 'error',
        buttons: buttons_arr
    });

}


/* THIS FUNTION RETRIEVES THE EXISTING CART INFORMATION (PRODUCTS AND QUANTITIES) PERFORMAING AN API CALL */
function getCartData(){

    url = 'http://product.shopatron.com/cart/'+cartId+'?api_key='+shopatronKey;

    func_response = $.ajax({
        type: "get",
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function(){

            $('#overlay').show();
            $('#spinner-loader').show();
        },

        error: function(){
            // error msg
            shopatronMessage('There was an error while trying to load your cart information. Please try again.', 'Cart Info');
            return false;
        },

        success: function(data){
            // success info
            var cartHTML = ' ';
            var subtotal = 0;
            var emptyCart = 0;

            var toatlItemsInCart = 0;

            $.each(data.cartItems, function(key, value) {
                emptyCart++;

                productId = key;
                quantity = value.quantity;
                product = value.product;

                // LOAD PRODUCT EXTRA DATA
                loadProductDetails(product, productId);

                image = '/images/spinnerLarge.gif';
                link = value.productLink;
                price = value.price;
                total = price*quantity;
                toatlItemsInCart = toatlItemsInCart+quantity;

                subtotal = subtotal + total;
                cartHTML+= '<div class="cart-row clear">';
                cartHTML+= '<div class="items-details"><div class="img-ctc"><img id="prod-image-'+productId+'" src="'+image+'" height="56"/></div><div class="detail-ctc croptext"><span id="prod-name-'+productId+'">retrieving product information...</span><div class="detail-spacer"> </div><a class="remove-product remove-fromcart" href="#" data-productId="'+productId+'">REMOVE</a></div></div><div class="price-details">$'+price+'</div><div class="quantity-details"><input type="text" class="quantity-input" value="'+quantity+'" id="q_'+productId+'" /> <a data-quantity="'+quantity+'" data-productId="'+productId+'" class="update-itme-btn" href="#">Update</a></div><div class="total-details">$'+(total.toFixed(2))+'</div>';
                cartHTML+= '</div>';
            });

            if (emptyCart==0){
                cartHTML+= '<div class="loader-msg">Your shopping cart is empty.</div>';
            }

            cartHTML+= '</div>';
            cartHTML+= '<div class="subtotal"><b>Subtotal: </b>$'+(subtotal.toFixed(2))+'</div>';

            $('#cartInner').html(cartHTML);
            $('#overlay').hide();
            $('#spinner-loader').hide();
            //return false;

            // UPDATE CART QUANTITY COOCKIE
            createCookie('cartQuantity',toatlItemsInCart);
            $('#cartQQ').html(toatlItemsInCart);

        }
    });
}


function roundToTwo(num) {
    return +(Math.round(num + "e+2")  + "e-2");
}

/* THIS FUNTION RETRIEVES A PRODUCT INFORMATION GIVEN A SHOPATRON PRODUCT ID, PERFORMAING AN API CALL */
function loadProductDetails(url, productId){

    //alert(url);

    func_response = $.ajax({
        type: "get",
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function(){
            $('#prod-name').html('retrieving product information...');
        },

        error: function(){

            // error msg
            $('#prod-name').html('Product info not found');

            return false;
        },

        success: function(data){
            // success info
            $('#prod-name-'+productId).html(data.name);

            if (data.image!=null){
                $('#prod-image-'+productId).attr('src',data.image);
            }
            else{
                $('#prod-image-'+productId).attr('src','/images/empty-raindrip.jpg');
            }
        }
    });

}


/* THIS FUNTION REMOVES A PRODUCT FROM THE CART GIVEN A SHOPATRON PRODUCT ID (IT WILL REMOVE ALL QUANTITY OF THE EXISTING PRODUCT), PERFORMAING AN API CALL */
function removeFromCart(productId){
    url = 'http://product.shopatron.com/cart/'+cartId+'/cartItems/'+productId+'?api_key='+shopatronKey;
    func_response = $.ajax({
        type: "delete",
        url: url,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        beforeSend: function(){

        },

        error: function(){
            // error msg
            return false;
        },

        success: function(data){
            // success info / update cart
            window.location.href = "/cart";
        }
    });

}

/* THIS FUNCTION CREATES A COOKIE. (USED FOR SAVING THE VALUE OF ITEMS IN CART) */
var createCookie = function(name, value, days) {
    var expires;
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

/* THIS FUNCTION RETRIEVES THE VALUE OF A GIVEN COOKIE. (USED FOR GETTING THE VALUE OF ITEMS IN CART) */
function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}

(function($){$.fn.extend({leanModal:function(options){var defaults={top:100,overlay:0.5,closeButton:null};var overlay=$("<div id='lean_overlay'></div>");$("body").append(overlay);options=$.extend(defaults,options);return this.each(function(){var o=options;$(this).click(function(e){var modal_id=$(this).attr("href");$("#lean_overlay").click(function(){close_modal(modal_id)});$(o.closeButton).click(function(){close_modal(modal_id)});var modal_height=$(modal_id).outerHeight();var modal_width=$(modal_id).outerWidth();
	$("#lean_overlay").css({"display":"block",opacity:0});$("#lean_overlay").fadeTo(200,o.overlay);$(modal_id).css({"display":"block","position":"fixed","opacity":0,"z-index":11000,"left":50+"%","margin-left":-(modal_width/2)+"px","top":o.top+"px"});$(modal_id).fadeTo(200,1);e.preventDefault()})});function close_modal(modal_id){$("#lean_overlay").fadeOut(200);$(modal_id).css({"display":"none"})}}})})(jQuery);

//shows Marketo form and binds interception for its submit button click
function showMform() {
	MktoForms2.loadForm("//app-sjf.marketo.com", "987-TET-873", 197, function (form){MktoForms2.lightbox(form).show();});

	$("#mktoForm_197").submit(function(event) {
		if (emailPopup() === false) {
			event.preventDefault();
			event.stopImmediatePropagation();
		}
	});
}

//shows modal window for email sending
function emailPopup() {
	emailAddress = $('#mktoForm_197 #Email').val();
	f_name = $("#mktoForm_197 #FirstName").val();
	l_name = $("#mktoForm_197 #LastName").val();

	if(f_name.length == 0) {
		$("#mktoForm_197 #FirstName").effect("highlight", {color: '#ffff99'}, 2000);
		return false;
	}
	if(l_name.length == 0) {
		$("#mktoForm_197 #LastName").effect("highlight", {color: '#ffff99'}, 2000);
		return false;
	}
	if(!validateEmail(emailAddress)) {
		$("#mktoForm_197 #Email").effect("highlight", {color: '#ffff99'}, 2000);
		return false;
	}

	//seems all is good
	name = f_name + ' ' + l_name;
	//$(".emailStatus").html("Sending email...");
	console.log("Sending email...");
	return sendEmail(emailAddress, name);
}

//sends the current solution to emailAddress and sends the name and email address to marketo
function sendEmail(emailAddress, name) {
	var ret = false;
	dt = {
		"rp-task"     : 'send-email',
		"rp-email"    : emailAddress,
		"rp-name"     : name,
		"rp-t-t"      : jQuery('#tree-tubing-q').val(),
		"rp-t-s"      : jQuery('#shrub-tubbing-q').val(),
		"rp-t-c"      : jQuery('#container-tubbing-q').val(),
		"rp-t-p"      : jQuery('#planter-tubing-q').val(),
		"rp-t-g"      : jQuery('#ground-tubing-q').val(),
		"rp-e-t"      : jQuery('#tree-emitters-q').val(),
		"rp-e-s"      : jQuery('#shrub-emitters-q').val(),
		"rp-e-c"      : jQuery('#container-emitters-q').val(),
		"rp-e-p"      : jQuery('#planter-emitters-q').val(),
		"rp-e-g"      : jQuery('#ground-emitters-q').val(),
		"rp-s-t"      : jQuery('#tree-stakes-q').val(),
		"rp-s-s"      : jQuery('#shrub-stakes-q').val(),
		"rp-s-c"      : jQuery('#container-stakes-q').val(),
		"rp-s-p"      : jQuery('#planter-stakes-q').val()
	};
	//console.log(dt);
	jQuery.ajax({
		url: '/templates/raindrip/sendMail2.php',
		type: 'POST',
		data: dt,
		dataType: 'html',
		success: function(data) {
			if(data.trim() == "SUCCESS") {
				console.log("...done");
				//jQuery(".emailStatus").html("The instructions and shopping list have been sent<br>to your email.<br><br><span style='font-weight:normal !important'>If you do not receive our email, please contact us at <a href='mailto:contact@raindrip.com'>contact@raindrip.com</a> and we’ll help you right away!</span>");
				ret = true;
			}
			else {
				console.log("...error" + data);
				//jQuery(".emailStatus").html("There was a problem while sending your email. Please try again later." + data);
				ret = false;
			}
		},
		error: function() {
			console.log("...AJAX error");
			//jQuery(".emailStatus").html("There was a problem while sending your email. Please try again later.");
		  ret = false;
		}
	});

	//jQuery("#emailPopUpButton").css("display", "none");
	return ret;
}