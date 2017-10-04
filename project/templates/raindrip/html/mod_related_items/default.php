<div class="clear similar-products-wrapper">
    <h1>Similar Products</h1>
    <div class="products-container">
        <?php
        defined('_JEXEC') or die;
        ?>

        <?php foreach ($list as $item) : ?>

            <?php
            // RELATED PRODUCT ID
            $relatedProductId = $item->id;

            $article_id = $relatedProductId;
            $article = & JTable::getInstance("content");
            $article->load($relatedProductId);

            $article_title = $article->get("title");
            $article_images = $article->get("attribs");

            $article_slug = $item->slug;

            $JSONimages = json_decode($article->get("images"));
            $imageURL = $JSONimages->image_intro;


            $productParams = json_decode($article->get("attribs"));

            // CHECK IF ITEM HAS SPECIAL PRICE
            $product_price = round($productParams->special_price, 2);

            if ($product_price == '' || is_null($product_price) || $product_price == 0) {
                $product_price = round($productParams->item_price, 2);
            }

            $shopaProdID = $productParams->item_cart_text;
            if ($shopaProdID == '' || is_null($shopaProdID)) {
                $shopaProdID = 0;
            }
            //$link = '';
            $link = JRoute::_(ContentHelperRoute::getArticleRoute($article_id, $item->catid));
            ?>

            <div class="product-list-wrapper">
                <div class="half-top">
                    <a href="<?php echo $link; ?>"  title="<?php echo htmlentities($article_title); ?>">
                        <img class="product-image" src="/<?php echo $imageURL; ?>" alt="Product title" width="160" />
                    </a>
                </div>
                <div class="half-bottom">
                    <h2><?php echo $article_title ?></h2>
                    <!--<div class="price">
                        $<?php //echo $product_price; ?>
                    </div>-->
                </div>
                <!--<a class="green-button shopatron-add-to-cart" href="#" data-productLink="<?php echo $link; ?>" data-shopatronprodid="<?php echo $shopaProdID; ?>"> ADD TO CART</a>-->
            </div>

        <?php endforeach; ?>
    </div>
</div>