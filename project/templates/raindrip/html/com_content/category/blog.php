<h1 class="clear"><?php echo $this->category->title; ?></h1>

<div class="products-container clear">
    <?php
    defined('_JEXEC') or die;
    JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
    JHtml::_('behavior.caption');

    if ($this->category->id == 81) {
        // SHOW ITEMS WITH "MOST POPULAR" TAG
        $hasAnyProduct = false;

        $db2 = JFactory::getDbo();
        $query2 = $db2->getQuery(true);
        $query2->select('*');
        $query2->from('#__content');
        $query2->where('state="1" order by title ASC');
        $db2->setQuery((string) $query2);
        $res2 = $db2->loadObjectList();
        $procuctsCount2 = count($res2);
        foreach ($res2 as $r2) {
            $productID = $r2->id;
            $tags = new JHelperTags;
            $tags->getItemTags('com_content.article', $productID);
            //print_r($tags);
            $showProduct = false;

            if (!empty($tags->itemTags)) {
                foreach ($tags->itemTags as $tagInProduct) {

                    if ($tagInProduct->title == 'Most Popular' || $tagInProduct->title == 'most popular' || $tagInProduct->title == 'MOST POPULAR') {
                        // THIS PRODUCT MUST BE SHOW UNDER MOST POPULAR ATEGORY
                        $showProduct = true;
                        $hasAnyProduct = true;
                    }
                }
            }

            if ($showProduct == true) {
                //  SHOW THE PRODUCT
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

        }

        if ($hasAnyProduct == false) {
            echo '<div class="infobox">There are no products under this category.</div>';
        }
    } else {

        // LOAD PRODUCTS FROM THIS CATEGORY
        $db2 = JFactory::getDbo();
        $query2 = $db2->getQuery(true);
        $query2->select('*');
        $query2->from('#__content');
        $query2->where('catid="' . $this->category->id . '" AND state="1" order by title ASC');
        $db2->setQuery((string) $query2);
        $res2 = $db2->loadObjectList();
        $procuctsCount2 = count($res2);


        // CHECK IF CATEGORY HAS CLILDREN CATEGORIES
        $dbChildren = JFactory::getDbo();
        $idChildren = $this->category->id;
        $queryChildren = $dbChildren->getQuery(true);
        $queryChildren->select('*');
        $queryChildren->from('#__categories');
        $queryChildren->where('parent_id="' . $idChildren . '"');
        $dbChildren->setQuery((string) $queryChildren);
        $resChildren = $dbChildren->loadObjectList();
        $procuctsCountChildren = count($resChildren);

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

		    //added replacement link
		    if ($this->category->id == 89) : ?>
			    <div class="product-list-wrapper">
				    <div class="half-top">
					    <a href="http://raindrip.com/order-your-replacement-timer-collar">
						    <img class="product-image" src="images/collar/timer-collar-v.jpg" alt="Order your replacement timer collar" width="96" height="103" />
						  </a>
				    </div>
				    <div class="half-bottom">
					    <h2><a href="http://raindrip.com/order-your-replacement-timer-collar" style="text-decoration: none; color: #0697d3;">
						    Click here to replace<br/> your broken collar for<br/> the R672CT timer
					    </a></h2>
				    </div>
			    </div>
		    <?php endif;
		    //end of addition

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
                //$linkSub = JRoute::_(ContentHelperRoute::getArticleRoute($rSub->id . '-' . $rSub->alias, $rSub->catid));
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

if ($procuctsCountChildren == 0 && $procuctsCount2 == 0) {
    echo '<div class="infobox">There are no products under this category.</div>';
}
?>

</div>