<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
?>
<div class="products-container clear">

    <?php
    // LOAD ALL MAIN CATEGORY
    $db = JFactory::getDbo();
    $id = 0; //example

    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__categories');
    $query->where('level="1" AND published="1" AND note<>"0" AND id<"100"');

    $db->setQuery((string) $query);
    $res = $db->loadObjectList();

    $procuctsCount = count($res);

    if ($procuctsCount > 0) {
        foreach ($res as $r) {
            // CYCLE THROUGH PRODUCTS AND SHOW
            $categoryId = $r->id;
            $categoryTitle = $r->title;

            // LOAD PRODUCTS FROM THIS CATEGORY
            $db2 = JFactory::getDbo();
            $id2 = $categoryId;

            $query2 = $db->getQuery(true);
            $query2->select('*');
            $query2->from('#__content');
            $query2->where('catid="' . $id2 . '" AND state="1" order by title ASC');

            $db2->setQuery((string) $query2);
            $res2 = $db2->loadObjectList();
            $procuctsCount2 = count($res2);


            // CHECK IF CATEGORY HAS CLILDREN CATEGORIES
            $dbChildren = JFactory::getDbo();
            $idChildren = $categoryId;

            $queryChildren = $dbChildren->getQuery(true);
            $queryChildren->select('*');
            $queryChildren->from('#__categories');
            $queryChildren->where('parent_id="' . $idChildren . '"');
            $dbChildren->setQuery((string) $queryChildren);
            $resChildren = $dbChildren->loadObjectList();
            $procuctsCountChildren = count($resChildren);

            if ($procuctsCount2 > 0 || $procuctsCountChildren > 0) {

                // DO NOT INCLUDE STSTIC PAGES ARTICLES
                if ($categoryId != 97) {
                    echo '<h1 class="clear"> ' . $categoryTitle . '</h1>';

                    foreach ($res2 as $r2) {

                        // CYCLE THROUGH PRODUCTS AND SHOW DATA
                        $productParams = json_decode($r2->attribs);

                        // CHECK IF ITEM HAS SPECIAL PRICE
                        $product_price = $productParams->special_price;

                        if ($product_price == '' || is_null($product_price) || $product_price == 0) {
                            $product_price = $productParams->item_price;
                        }


                        $shopaProdID = $productParams->item_cart_text;
                        if ($shopaProdID == '' || is_null($shopaProdID)) {
                            $shopaProdID = 0;
                        }

                        // FIND URL PRODUCT LINK
                        $link = JRoute::_(ContentHelperRoute::getArticleRoute($r2->id, $r2->catid));
                        // GET MAIN IMAGE FROM STDCLASS OBJECT
                        $JSONimages = json_decode($r2->images);
                        $imageURL = $JSONimages->image_intro;

                        if ($imageURL == '' or is_null($imageURL)) {
                            $imageURL = 'images/empty-raindrip.jpg';
                        }
                        ?>

                        <div class="product-list-wrapper">
                            <div class="half-top">
                                <a href="<?php echo $link; ?>"  title="<?php echo htmlentities($r2->title); ?>">
                                    <img class="product-image" src="/<?php echo $imageURL; ?>" alt="Product title" width="160" />
                                </a>
                            </div>
                            <div class="half-bottom">
                                <h2><?php echo $r2->title; ?></h2>
                                <div class="price">
                                    $<?php echo number_format($product_price, 2, '.', ''); ?>
                                </div>
                            </div>
                            <a class="green-button shopatron-add-to-cart" href="#" data-productLink="<?php echo $link; ?>" data-shopatronprodid="<?php echo $shopaProdID; ?>"> ADD TO CART</a>
                        </div>

                        <?php
                    }

                    // SHOW CHILDREN CATEGORIES IF IT HAS PRODUCTS IN THEM
                    if ($procuctsCountChildren > 0) {

                        foreach ($resChildren as $categoryObjChildren) {
                            $childrenCategoryId = $categoryObjChildren->id;
                            $childrenCategoryName = $categoryObjChildren->title;
                            $childrenCategoryParentId = $categoryObjChildren->parent_id;
                            $childrenCategoryAlias = $categoryObjChildren->alias;

                            $dbSub = JFactory::getDbo();
                            $querySub = $dbSub->getQuery(true);
                            $querySub->select('*');
                            $querySub->from('#__content');
                            $querySub->where('catid="' . $childrenCategoryId . '" AND state="1" order by title ASC');

                            $dbSub->setQuery((string) $querySub);
                            $resSub = $dbSub->loadObjectList();

                            if (count($resSub) > 0) {
                                echo '<h3 class="clear"> ' . $childrenCategoryName . '</h3><br/>';
                            }


                            foreach ($resSub as $rSub) {
                                $productParamsSub = json_decode($rSub->attribs);

                                // CHECK IF ITEM HAS SPECIAL PRICE
                                $product_priceSub = $productParamsSub->special_price;

                                if ($product_priceSub == '' || is_null($product_priceSub) || $product_priceSub == 0) {
                                    $product_priceSub = $productParamsSub->item_price;
                                }

                                $shopaProdIDSub = $productParamsSub->item_cart_text;
                                if ($shopaProdIDSub == '' || is_null($shopaProdIDSub)) {
                                    $shopaProdIDSub = 0;
                                }
                                // FIND URL PRODUCT LINK

                                $linkSub = JRoute::_(ContentHelperRoute::getArticleRoute($rSub->id, $rSub->catid));
                                // GET MAIN IMAGE FROM STDCLASS OBJECT
                                $JSONimagesSub = json_decode($rSub->images);
                                $imageURLSub = $JSONimagesSub->image_intro;

                                if ($imageURLSub == '' or is_null($imageURLSub)) {
                                    $imageURLSub = 'images/empty-raindrip.jpg';
                                }
                                ?>
                                <div class="product-list-wrapper">
                                    <div class="half-top">
                                        <a href="<?php echo $linkSub; ?>"  title="<?php echo htmlentities($rSub->title); ?>">
                                            <img class="product-image" src="/<?php echo $imageURLSub; ?>" alt="Product title" width="160" />
                                        </a>
                                    </div>
                                    <div class="half-bottom">
                                        <h2><?php echo $rSub->title; ?></h2>
                                        <div class="price">
                                            $<?php echo number_format($product_priceSub, 2, '.', ''); ?>
                                        </div>
                                    </div>
                                    <a class="green-button shopatron-add-to-cart" data-productLink="<?php echo $linkSub; ?>" href="#" data-shopatronprodid="<?php echo $shopaProdIDSub; ?>"> ADD TO CART</a>
                                </div>
                                <?php
                            }
                        }
                    }
                }
            }
            // FIND SUBCATEGORIES
        }
    } else {
        echo '<div class="infobox">There are no products under this category.</div>';
    }
    ?>

</div>