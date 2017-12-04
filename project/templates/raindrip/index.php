<?php
defined('_JEXEC') or die('Restricted access');

if (JRequest::getVar('option') == 'com_content' && JRequest::getVar('view') == 'article' && JRequest::getInt('id') == 92)
	file_put_contents('404.html', date(DATE_RFC822)." \t".$_SERVER['REMOTE_ADDR']." \t".$_SERVER['HTTP_REFERER']." <br/>\n", FILE_APPEND);
?>
<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
    <head>
        <!-- ENABLE HTML5 in IE<8-->
        <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <?php
        $search = array('jquery.min.js', 'jquery-noconflict.js', 'jquery-migrate.min.js', 'mootools-core.js', 'core.js', 'mootools-more.js', 'modal.js', 'tabs-state.js', 'caption.js', 'bootstrap.min.js', 'j2store.namespace.js', 'j2storejqui.js', 'j2store.js', 'jquery-ui.min.js');
        // remove the unnecessary js files
        foreach ($this->_scripts as $key => $script) {
            foreach ($search as $findme) {

                if (stristr($key, $findme) !== false) {
                    unset($this->_scripts[$key]);
                }
            }
        }
        ?>
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/main.css" type="text/css" />
	  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/expand.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/stage_2.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/joomla.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/messi.css" type="text/css" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/datepicker.css" type="text/css" />
    <link rel='shortcut icon' type='image/x-icon' href='/images/favicon.ico' />

    <!--[if IE 7]>
<link rel="stylesheet" type="text/css"
href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7.css">
<![endif]-->

    <script type="text/javascript"> var cartId=<?php echo json_encode(session_id()); ?>;</script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/messi.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.22/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/scripts.js"></script>


    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/fancybox/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!--BEGIN - SHOPATRON SCRIPTS -->
    <script id="shopatronCart" src="http://mediacdn.shopatron.com/media/js/product/shopatronAPI-2.4.min.js" type="text/javascript">{"apiKey":"g8rpsyr2"}</script>
    <script src="http://mediacdn.shopatron.com/media/js/product/shopatronJST-2.4.min.js" type="text/javascript"></script>
    <!--END - SHOPATRON SCRIPTS -->
<script type="text/javascript" src="//use.typekit.net/xrg0yif.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-16321891-2', 'auto');
  ga('send', 'pageview');

</script>
    <!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
	window.__insp = window.__insp || [];
	__insp.push(['wid', 1049728439]);
	(function() {
		function __ldinsp(){var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); }
		if (window.attachEvent){
			window.attachEvent('onload', __ldinsp);
		}else{
			window.addEventListener('load', __ldinsp, false);
		}
	})();
</script>
<!-- End Inspectlet Embed Code -->
<link rel='canonical' href='http://raindrip.com' /> 
</head>
<body>
<!-- Qualaroo -->
<script type="text/javascript">
var _kiq = _kiq || [];
(function(){
setTimeout(function(){
var d = document, f = d.getElementsByTagName('script')[0], s = d.createElement('script'); s.type = 'text/javascript';
s.async = true; s.src = '//s3.amazonaws.com/ki.js/43453/eXq.js'; f.parentNode.insertBefore(s, f);
}, 1);
})();
</script>
<!-- End Qualaroo -->
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-52MWG3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-52MWG3');</script>
<!-- End Google Tag Manager -->
    <header class="clear">
        <div id="main-top">
            <a href="/"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/raindrip-logo.png" alt="Raindrip" /></a>
            <!--<img id="slogan-img" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/slogan.jpg" alt="Raindrip" />-->
            <div id="secondary-links">

                <span id="position-7"><jdoc:include type="modules" name="position-7" /></span> <!--<a href="/cart" class="cart-link"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/cart-logo.png" alt="cart" /> &nbsp;Cart (<span id="cartQQ">0</span>)</a>-->
            </div>
            <!--<div id="promo-call-out"><img src="<?php echo $this->baseurl ?>/images/shipping-promo.png" alt="Shipping Promo" /></div>-->
        </div>
        <nav>
            <div id="position-9"><jdoc:include type="modules" name="position-9" /></div>
            <!-- BEGIN - include joomla search box overrided template -->
            <jdoc:include type="modules" name="position-0" />
            <!-- END - include joomla search box overrided template -->
        </nav>

    </header>
    <?php
    // SHOW PRODUCTS AND CATEGORIES CONTENT
    if ($_SERVER['REQUEST_URI'] == '/') {
        ?>
        <div class="home-bkg">
            <div class="home-bkg-left"></div>
        <?php } ?>
        <section class="clear <?php if ($_SERVER['REQUEST_URI'] == '/drip-kits') {
            echo ' extrasection';
        } ?> "  >
            <?php if ($_GET['id'] != '92') { ?>
                <div id="position-4"><jdoc:include type="modules" name="position-4" /></div>
            <?php } ?>
            <article <?php
            if ($_SERVER['REQUEST_URI'] == '/') {
                echo ' class="left-article"';
            }

            if ($_SERVER['REQUEST_URI'] == '/drip-kits') {
                echo ' class="extraarticle" ';
            }
            ?>
                >
                <jdoc:include type="component" />
                <!-- BEGIN - INCLUDE RELATED PRODUCTS MODULE -->
                <div id="position-2"><jdoc:include type="modules" name="position-2" /></div>
                <!-- END - INCLUDE RELATED PRODUCTS MODULE -->
            </article>
        </section>
    <?php
    if ($_SERVER['REQUEST_URI'] == '/') {
        ?>
            <div class="home-bkg-right"></div>
        </div>
<?php } ?>

<?php if ($_GET['id'] != '92') { ?>
    <jdoc:include type="modules" name="position-13" />
<?php } ?>


<footer class="clear">
    <div id="center-footer">
        <div class="quad-width">
            <a href="/"><img id="footer-logo" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/logo-footer.png" alt="raindrip" /></a>
            <div class="copyright">Copyright 2017</div>
        </div>
        <div class="quad-width">
            <ul class="title-footer-category">
                <li class="footer-category-title">Products</li>
            </ul>
            <!-- JOOMLA INCLUDE MENU -->
            <div id="position-8"><jdoc:include type="modules" name="position-8" /></div>
            <!-- JOOMLA INCLUDE MENU -->
            <br/>
            <ul class="title-footer-category">
                <li class="footer-category-title">Kits</li>
            </ul>
            <!-- JOOMLA INCLUDE MENU -->
            <div id="position-6"><jdoc:include type="modules" name="position-6" /></div>
            <!-- JOOMLA INCLUDE MENU -->
            <br/>
            <ul class="title-footer-category">
                <li class="footer-category-link left-li"><span class="no-link"  >Website by</span></li>
                <li class="footer-category-title left-li">&nbsp; <a href="http://thesmackpack.com/" target="_blank">The Smack Pack</a></li>
            </ul>

        </div>
        <div class="quad-width">
            <!-- <ul class="title-footer-category">
                <li class="footer-category-title">Expand & Repair</li>
                <li class="footer-category-link"><a href="/expand-and-repair">How much material will I need?</a></li>
            </ul> 
            <br/> -->
            <ul class="title-footer-category">
                <li class="footer-category-title">Resources</li>
                <li class="footer-category-link"><a href="/resources#resources-3">FAQs</a></li>
                <li class="footer-category-link"><a href="/resources#resources-0">Catalogues</a></li>
                <li class="footer-category-link"><a href="/resources#resources-2">Videos</a></li>
                <li class="footer-category-link">&nbsp;</li>
            </ul>
            <ul class="title-footer-category">
                <li class="footer-category-title"><a href="/about-us">About Us</a></li>
                <li class="footer-category-title"><a href="/contact-us">Contact Us</a></li>
                <!--<li class="footer-category-title"><a href="/rebate-center">Rebate Center</a></li>-->
                <li class="footer-category-title"><a href="/where-to-buy">Where to Buy</a></li>
            </ul>
        </div>
        <!--<div class="quad-width-right">
            <a target="_blank" href="https://www.youtube.com/user/RaindripInc" class="social-circle youtube"></a> <a target="_blank"  href="http://www.pinterest.com/ndsmarketing/" class="social-circle pinterest"></a> <a target="_blank"  href="https://www.facebook.com/RaindripInc" class="social-circle facebook"></a> <a target="_blank"  href="https://plus.google.com/+Ndspro/about" class="social-circle googleplus"></a>
        </div>-->
    </div>

    <div id="overlay">
        <img id="spinner-loader" alt="" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/ajax-loader.gif" />
        <div class="" id="wait-msg" style="color:white; height:50px; display: none;"> Please wait, this operation could take several minutes...</div>
    </div>
  
  
  
</footer>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

  </script>

</body>
</html>