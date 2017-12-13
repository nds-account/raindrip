<?php
defined('_JEXEC') or die;
JHtml::_('formbehavior.chosen', 'select');
?>
<div class="products-container clear search-result-ctc">

    <h1>Search Results</h1>
    <div class="products-container">
        <?php
        $hasItmes = 0;
        $products = $this->results;

        if (!empty($products)) {
            foreach ($products as $product) {

                $productName = $product->title;
                $productDescription = $product->text;
                $productSlug = $product->slug;
                $paramsString = $product->href;

                // FIND PRODUCT ID
                $params1 = explode('&id=', $paramsString);
                $params2 = explode(':', $params1[1]);
                $idProduct = $params2[0];

                // FIND CATEGORY ID
                $params1 = explode('&catid=', $paramsString);

                $idCategory = 0;

                if (count($params1) > 1) {
                    $params2 = explode(':', $params1[1]);
                    $idCategory = $params2[0];
                }


                //exclude static pages and categories from search results
                if($product->section != "Static Pages" && $product->section != "Uncategorised" && $product->section != "Category"){

                    if (is_numeric($idProduct) && $idProduct != 87 && $idProduct != 74 && $idProduct != 75 && $idProduct != 94 && $idProduct != 93 /*&& $idProduct <212*/) { // EXCLUDE STSTIC PAGES
                        $imageURL = '';
                        $article = & JTable::getInstance("content");
                        $article->load($idProduct);
                        $article_title = $productName;
                        $article_images = $article->get("attribs");
                        $article_slug = $productSlug;
                        $JSONimages = json_decode($article->get("images"));

                        if (isset($JSONimages->image_intro)) {
                            $imageURL = $JSONimages->image_intro;
                        }

                        if ($imageURL == '' || is_null($imageURL)) {
                            $imageURL = 'images/empty-raindrip.jpg';
                        }
                        $productParams = json_decode($article->get("attribs"));

                        if (isset($productParams->item_cart_text)) {

                            $hasItmes = 1;

                            // CHECK IF ITEM HAS SPECIAL PRICE
                            if (isset($productParams->special_price)) {
                                $product_price =  number_format($productParams->special_price, 2, '.', '');
                            }

                            if ($product_price == '' || is_null($product_price) || $product_price == 0) {
                                 //$product_price = round($productParams->item_price, 2);
                                 $product_price =  number_format($productParams->item_price, 2, '.', '');
                            }


                            $shopaProdID = $productParams->item_cart_text;
                            if ($shopaProdID == '' || is_null($shopaProdID)) {
                                $shopaProdID = 0;
                            }

                            //$link = '';
                            $link = JRoute::_(ContentHelperRoute::getArticleRoute($idProduct, $idCategory));
                            ?>

                            <div class="product-list-wrapper">
                                <div class="half-top">
                                    <a href="<?php echo $link; ?>"  title="<?php echo $article_title; ?>">
                                        <img class="product-image" src="/<?php echo $imageURL; ?>" alt="Product title" width="160" />
                                    </a>
                                </div>
                                <div class="half-bottom">
                                    <h2><?php echo $article_title ?></h2>
                                    <!--<div class="price">
                                        $<?php echo $product_price; ?>
                                    </div>-->
                                </div>
                                <!--<a class="green-button shopatron-add-to-cart" href="#" data-shopatronprodid="<?php echo $shopaProdID; ?>" data-productLink="<?php echo $link; ?>"> ADD TO CART</a>-->
                            </div>

                            <?php
                        }
                    }
                }
            }
        }

        if ($hasItmes == 0) {
            echo '<div class="infobox">There are no products under this category.</div>';
        }
        ?>

    </div>
</div>