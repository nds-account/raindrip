<?php

defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');


// Create shortcuts to some parameters.
$params = $this->item->params;
$attribs = $this->item->attribs;
$images = json_decode($this->item->images);

$urls = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user = JFactory::getUser();
$info = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
        || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author'));


// GET EXTRA IMAGES FROM EXTRA FIELDS
$extraFields = $this->item->text;
preg_match_all('/<img[^>]+>/i', $extraFields, $imageArray);
$videoUrlYoutube = '';

// GET VIDEO URL
$dataArray = split('Video URL', $extraFields);
if (count($dataArray) > 0) {
    preg_match_all('/<span class=\"value\">(.*?)<\/span>/s', $dataArray[1], $urlLink);
}

if (count($urlLink[0]) > 0) {
    $videoUrlYoutube = strip_tags($urlLink[0][0]);
    $videoUrlYoutube = str_replace(' ', '', $videoUrlYoutube);
    $videoUrlYoutube = str_replace('"', '', $videoUrlYoutube);
}
$warrantyText = ' Raindrip stands by their product and gives a 1 year 100% satisfaction guarantee. If your product breaks, Raindrip will send you a new one for free. Just pay shipping and handling. ';

// GET MAIN IMAGE FROM STDCLASS OBJECT
$JSONimages = json_decode($this->item->images);
$imageURL = $JSONimages->image_fulltext;
if ($imageURL == '' or is_null($imageURL)) {
    $imageURL = $JSONimages->image_intro;
}
$imageURL = $JSONimages->image_intro;
if ($imageURL == '' or is_null($imageURL)) {
    $imageURL = 'images/empty-raindrip.jpg';
}

// GET OBJECT PARAMS FROM JREGISTRY OBJECT CLASS
$productParams = json_decode($this->item->attribs);

// CHECK IF ITEM HAS SPECIAL PRICE
$product_price = $productParams->special_price;

if ($product_price == '' || is_null($product_price) || $product_price == 0) {
    $product_price = $productParams->item_price;
}

// GET WEIGHT MEASURES
$measureWeight = '';
$measureDimensions = '';
$productWeight = 'not specified.';
$itemL = 'n/s';
$itemW = 'n/s';
$itemH = 'n/s';

if (isset($productParams->item_metrics)) {
    $wMeasureId = $productParams->item_metrics->item_weight_class_id;

    if ($wMeasureId == '1') {
        $measureWeight = 'kg.';
    }
    if ($wMeasureId == '2') {
        $measureWeight = 'g.';
    }
    if ($wMeasureId == '3') {
        $measureWeight = 'oz.';
    }

    if ($wMeasureId == '4') {
        $measureWeight = 'lbs.';
    }

    $dMeasureId = $productParams->item_metrics->item_length_class_id;


    if ($dMeasureId == '1') {
        $measureDimensions = 'cm.';
    }
    if ($dMeasureId == '2') {
        $measureDimensions = 'in.';
    }
    if ($dMeasureId == '3') {
        $measureDimensions = 'mm.';
    }

    $productWeight = $productParams->item_metrics->item_weight;

    if ($productWeight == 0) {
        $productWeight = 'not specified.';
    } else {
        $productWeight = round($productParams->item_metrics->item_weight, 2);
    }


    $itemL = $productParams->item_metrics->item_length;
    if ($itemL == 0) {
        $itemL = 'n/s.';
    } else {
        $itemL = round($productParams->item_metrics->item_length, 2);
    }


    $itemW = $productParams->item_metrics->item_width;
    if ($itemW == 0) {
        $itemW = 'n/s.';
    } else {
        $itemW = round($productParams->item_metrics->item_width, 2);
    }


    $itemH = $productParams->item_metrics->item_height;
    if ($itemH == 0) {
        $itemH = 'n/s.';
    } else {
        $itemH = round($productParams->item_metrics->item_height, 2);
    }
}


$shopaProdID = $productParams->item_cart_text;
if ($shopaProdID == '' || is_null($shopaProdID)) {
    $shopaProdID = 0;
}


// FIND RELATED PRODUCTS
$product_keys = $this->item->metakey;

$productStatus = $this->item->state;

if ($productStatus == 1) {
    ?>

                <h3><?php echo strtoupper($this->item->category_title); ?> <!--<span class="active">&rarr; FIX-IT-KIT</span>--></h3>
    <br/>
<style>
.clear.container-image-detail img {
    width: 100%;
    padding: 0;
}
.thumb-container.selected-thumb img {
    width: 90%;
    max-height: 90%;
}
</style>
    <div class="products-container ">


        <div class="detail-right">
            <h4><?php echo $this->item->title; ?></h4>
            <br/>
            <div class="item-sku">Item Number: <?php echo $productParams->item_sku; ?></div>
            <br/><br/>

                <?php if ($this->item->title == "Set n' Flow Battery Operated Timer") : //added a link to replacement part ?>
                  <div style="float: right; text-align: center; border: 1px solid #e9e9e9; border-radius: 5px; padding: 10px;">
                    <a href="http://raindrip.com/order-your-replacement-timer-collar" style="text-decoration: none; color: #0697d3;">
                        <img src="images/collar/timer-collar-v.jpg" alt="Order your replacement timer collar" width="96" height="103" /><br/>
                        Click here to replace<br/> your broken collar for<br/> the R672CT timer
                    </a>
                </div>
                <?php endif; //end of addition ?>
                
            <!-- START: SHOW LIST PRICE -->
            <!--<?php if($shopaProdID=="R560DP"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$90.08</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>
            <?php if($shopaProdID=="170CPUB"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$6.29</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>
            <?php if($shopaProdID=="SDFGCT"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$13.23</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>-->

            <!-- START --->

            <!--<?php if($shopaProdID=="SDFSTH1P"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$102.96</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>

            <?php if($shopaProdID=="SDGCBHP"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$135.24</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>

            <?php if($shopaProdID=="R558DT"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$19.27</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>

            <?php if($shopaProdID=="R567DT"): ?>
                    <h5 style="text-decoration: line-through;color:#000;margin-bottom:0;padding-bottom:0;">$27.93</h5>
                    <h5 style="color:red;">$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php endif; ?>-->

            <!-- END -->
            
            <!--<?php if($shopaProdID=="R560DP" || $shopaProdID=="170CPUB" || $shopaProdID=="SDFGCT" || $shopaProdID=="SDFSTH1P" || $shopaProdID=="SDGCBHP" || $shopaProdID=="R558DT" || $shopaProdID=="R567DT" ){
            }else{ ?>
                <h5>$<?php echo number_format($product_price, 2, '.', ''); ?></h5>
            <?php } ?>-->
            <!-- END: SHOW LIST PRICE -->
            
            
            <!--<input type="text" id="quantity" name="quantity" class="shptrn_quantity_selector" value="1">
            <a class="add-to-cart shopatron-add-to-cart-quantity" data-shopatronprodid="<?php echo $shopaProdID; ?>" data-productLink="<?php echo $_SERVER['PHP_SELF']; ?>" href="#"> ADD TO CART</a>-->
            <!--<div id="atc_button_div_id" data-shopatronprodid="<?php echo $shopaProdID; ?>"></div>-->

            <div class="detail-separator clear"> </div>
            <div class="detail-social-share">


                <div class="fb-like" data-href="<?php echo 'http://raindrip.com' . $_SERVER['REQUEST_URI']; ?>" data-width="48" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false" data-send="true" ></div>

                <a href="//www.pinterest.com/pin/create/button/?url=<?php echo urlencode('http://raindrip.com' . $_SERVER['REQUEST_URI']); ?>&amp;media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg&amp;description=Next%20stop%3A%20Pinterest" data-pin-do="buttonPin" data-pin-config="beside"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" alt="pinterest" /></a>
                <!-- Please call pinit.js only once per page -->
                <script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>


                <a href="<?php echo urlencode('http://raindrip.com' . $_SERVER['REQUEST_URI']); ?>" class="twitter-share-button" data-lang="en" data-size="small">Tweet</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>



            </div>

















        <div class="detail-left detail-wp">
            <div class="clear container-image-detail">
                <a href="#"><img id="main-image-for-product-detail" data-name="<?php echo $this->item->title; ?>" class="product-image-detailpage" src="/<?php echo $imageURL; ?>" alt="Product title" width="230" /></a><!--  width="235" -->
            </div>
            <div class="clear view-more">
                <span class="bullet"> </span><span class="view-featured">&nbsp; <a id="fancybox-manual-c" href="javascript:;">VIEW LARGER IMAGE</a></span>
            </div>

            <div class="thumb-wrapper">

                <div class="thumb-container selected-thumb">
                    <a class="fancybox-no" href="#" ><img class="product-image-detail" alt="" title="" src="/<?php echo $imageURL; ?>" ></a>
                </div>

                <?php
                foreach ($imageArray[0] as $image) {
                    $showImage = str_replace('img', 'img class="product-image-detail"  height="230" ', $image);
                    ?>

                    <div class="thumb-container selected-thumb">
                        <a  class="fancybox-no"  href="#" ><?php echo $showImage; ?></a>
                    </div>

                    <?php
                }
                ?>

            </div>
             <div class="thumb-wrapper">
                <?php

                    if(isset($this->item->related_products)){

                       if(is_array($this->item->related_products) && !empty($this->item->related_products)) {
                      
                          echo "<div class='recommended-title'>Recommended Products</div> <div class='related-products'>";

                          foreach( $this->item->related_products as $recommendedProd) { 
// GET MAIN IMAGE FROM STDCLASS OBJECT
$JSONimages = json_decode($recommendedProd->images); 
$imageURL = $JSONimages->image_fulltext;
if ($imageURL == '' or is_null($imageURL)) {
    $imageURL = $JSONimages->image_intro;
}
$imageURL = $JSONimages->image_intro;
if ($imageURL == '' or is_null($imageURL)) {
    $imageURL = 'images/empty-raindrip.jpg';
}    


?>
<div>
<div class="left-img"><img class="product-image-detail" height="35" width="35" alt="" title="" src="/<?php echo $imageURL; ?>"></div>
<div class="img-content"><span></span><?php echo $recommendedProd->title; ?></div>
</div>
<div class="line"></div>
<?php
                            }
                          echo "</div>";

                          }
                      }
                    
                ?>


                  
             </div>

        </div>


        <p class="product-description" >
                <?php
                $separated_intro = explode('<div class="facts">FACTS</div>', $this->item->introtext);

                $showDescription = '';
                if (count($separated_intro) != 0) {
                    $showDescription = $separated_intro[0];
                }

                echo strip_tags($showDescription);
                ?>
            </p>

            <?php
            if (count($separated_intro) >= 1) {

                echo '<div class="compatibility-facts-title">
                        Quick Compatibility Facts:
                    </div>';

                echo $separated_intro[1];
            }
            ?>
            <!--
            <div class="compatibility-facts-title">
                Use with:
            </div>

            <ul class="use-with">
                <li class="use"><a href="#"><img src="<?php echo $this->baseurl ?>/templates/raindrip/images/blue-icn-1.png" alt="image" /></a></li>
                <li class="use"><a href="#"> <img src="<?php echo $this->baseurl ?>/templates/raindrip/images/blue-icn-2.png" alt="image" /></a></li>
            </ul>
            -->

        </div>



















        <?php if ($videoUrlYoutube != '' && !is_null($videoUrlYoutube)) { ?>

        <div class="extra-data detail-wp clear">
            <ul class="tabs">
<!--                 <li class="single-tab selected-tab"><a href="#" class="show-tab" data-id="main-description" >Product Specs</a></li>
 -->                <li class="single-tab"><a href="#" class="show-tab" data-id="main-videos">Videos</a></li>
            </ul>
            <!-- <div class="specs-body" id="main-description">
                <span class="spec-title">Product Dimensions:</span> <?php echo $itemL; ?> <?php echo $measureDimensions; ?> L x <?php echo $itemW; ?> <?php echo $measureDimensions; ?> W x <?php echo $itemH; ?> <?php echo $measureDimensions; ?> H<br/>
                <span class="spec-title">Shipping Weight:</span> <?php echo $productWeight; ?> <?php echo $measureWeight; ?><br/>
                <span class="spec-title">Item Number:</span> <?php echo $productParams->item_sku; ?><br/>
                <span class="spec-title">Warranty:</span> <?php echo $warrantyText; ?><br/>
            </div> -->

            <div class="specs-body clear" id="main-videos">
                <div class="video-container clear">
                    <div class="clear">
                        <?php if ($videoUrlYoutube != '' && !is_null($videoUrlYoutube)) { ?>
                            <iframe class="video-iframe" width="400" height="275" src="<?php echo strip_tags($videoUrlYoutube); ?>"  allowfullscreen></iframe>

                            <?php
                        } else {
                            ?>
                            There are no videos for this product.
                            <?php
                        }
                        ?>

                    </div>
                </div>

            </div>


        </div>

        <?php }?>

        <p class="products-extra-info"><br/><b>If you need more information visit our <a href="/resources">Resources</a> tab to view our <a href="/resources/faq">FAQs</a>, <a href="/resources#resources-0">Catalogues</a> or <a href="/resources/videos">Installation Videos</a>.</b></p>
        <div class="big-separator"></div>

    </div>


    <?php
} else {
    // PRODUCT IS NOT PUBLISHED
    echo 'Not published';
}
?>