<?php
defined('_JEXEC') or die;
?>
<script type="text/javascript">

    getCartData();

</script>


<div class="w1000 clear">

    <div id="cartContent">
        <div class="cart-header">Shopping Cart</div>
        <div class="cart-titles">
            <div class="items-title">Items</div>
            <div class="price-title">Price</div>
            <div class="quantity-title">Quantity</div>
            <div class="total-title">Total</div>
        </div>
        <div id="cartInner">
            <div class="loader-msg">... Loading cart content</div>
        </div>

        <div id="btn-container" class="clear">
            <!--<a href="#" id="update-cart" class="update-cart">Update Cart</a><div class="btn-separator clear"></div>-->
            <a href="#" class="checkout-cart" id="cart-checkout">Checkout</a>
        </div>
    </div>

</div>





