<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// FIND URL PRODUCT LINK
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->id, $this->item->catid));
?>

<?php
// GET MAIN IMAGE FROM STDCLASS OBJECT
$JSONimages = json_decode($this->item->images);
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


$shopaProdID = $productParams->item_cart_text;
if ($shopaProdID == '' || is_null($shopaProdID)) {
    $shopaProdID = 0;
}
?>

<div class="product-list-wrapper">

    <div class="half-top">
        <a href="<?php echo $link; ?>"  title="<?php echo htmlentities($this->item->title); ?>">
            <img class="product-image" src="/<?php echo $imageURL; ?>" alt="Product title" width="160" />
            <?php // echo JLayoutHelper::render('joomla.content.intro_image', $this->item);   ?>
        </a>
    </div>
    <div class="half-bottom">
        <a href="<?php echo $link; ?>"  title="<?php echo htmlentities($this->item->title); ?>">
            <h2><?php echo $this->item->title; ?></h2>
        </a>    
        <!--<div class="price">
            $<?php echo $product_price; ?>
        </div>-->
    </div>
    <!--<a class="green-button shopatron-add-to-cart" data-productLink="<?php echo $link; ?>" href="#" data-shopatronprodid="<?php echo $shopaProdID; ?>"> ADD TO CART</a>-->
</div>