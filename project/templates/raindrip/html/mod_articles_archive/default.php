<?php
defined('_JEXEC') or die;
?>

<div class="home-kits-container clear">
    <div class="titleKits clear">
        New to drip? Choose the kit that’s right for your plants. <a href="/drip-kits" class="seebtn">SEE ALL KITS</a>
    </div>

    <?php
    // BEGIN LOAD KITS CATEGORY
    $db = JFactory::getDbo();
    $id = 82; // KITS CATEGORY (ID = 82)
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__content');
    $query->where('catid="' . $id . '" AND state="1"');
    $db->setQuery((string) $query);
    $res = $db->loadObjectList();
    $procuctsCount = count($res);

    if ($procuctsCount > 0) {

        foreach ($res as $r) {

            // ONLY FOR KITS
            if ($r->id == '91' || $r->id == '90' || $r->id == '88' || $r->id == '89' || $r->id == '307') {

                // GET MAIN IMAGE FROM STDCLASS OBJECT
                //print_r($r->images);
                $JSONimages = json_decode($r->images);
                $imageURL = $JSONimages->image_fulltext;
                if ($imageURL == '' or is_null($imageURL)) {
                    $imageURL = $JSONimages->image_intro;
                }

                if ($imageURL == '' or is_null($imageURL)) {
                    $imageURL = 'images/empty-raindrip.jpg';
                }

                // GET OBJECT PARAMS FROM JREGISTRY OBJECT CLASS
                $productParams = json_decode($r->attribs);

                // CHECK IF ITEM HAS SPECIAL PRICE
                $product_price = $productParams->special_price;

                if ($product_price == '' || is_null($product_price) || $product_price == 0) {
                    $product_price = $productParams->item_price;
                }

                // GET KIT LINK
                $link = JRoute::_(ContentHelperRoute::getArticleRoute($r->id, $id));


                $shopaProdID = $productParams->item_cart_text;
                if ($shopaProdID == '' || is_null($shopaProdID)) {
                    $shopaProdID = 0;
                }


                // SHOW KITS '.$link.'
                echo '<div class="kit-item">
                <div class="kit-img-container">
                    <a href="' . $link . '"> <img src="/' . $imageURL . '" alt="Raindrip Kit" ></a>
                </div>
                <div class="kit-title">
                    ' . $r->title . '
                </div>
                <div class="btn">
                    <a href="' . $link . '" class="goto-kit-btn " data-shopatronprodid="' . $shopaProdID . '" data-productLink="' . $link . '" >GO TO KIT PAGE</a>
                </div>
            </div>';
            }
        }
    }
    ?>

</div>