<div class="quick-access">
    <div class="header1">
        <ul class="links">
            <li class="first"><a href="customer/account/"
                                 title="My Account">My Account</a></li>
            <li><a href="wishlist/" title="My Wishlist">My
                    Wishlist</a></li>
            <li><a href="checkout/cart/" title="My Cart"
                   class="top-link-cart">My Cart</a></li>
            <li class=" last"><a
                    href="customer/account/login/"
                    title="Log In">Log In</a></li>
        </ul>


        <div class="header_currency">
            <label>Currency :</label>

            <div class="currency_box">

                <div class="currency_pan">
                    <span>USD</span>
                </div>

                <div class="currency_detail" name="currency" title="Select Your Currency"
                     onchange="setLocation(this.value)">
                    <a href="" class="currency_icon"><span>EUR</span> </a>
                    <a href="" class="currency_icon selected"><span>USD</span> </a>
                </div>

            </div>
        </div>

        <div class="header_language">
            <label for="select-language">Language :</label>

            <div class="language_box">

                <div class="language_pan">
                    <span>Default</span>
                </div>
                <div class="language_detail" onchange="window.location.href=this.value">
                    <a href="?___store=default&amp;___from_store=default"
                       class="currency_icon selected ">Default</a>
                    <a href="?___store=kidsstore&amp;___from_store=default"
                       class="currency_icon">Kids Store</a>
                    <a href="?___store=cake&amp;___from_store=default"
                       class="currency_icon">Cake Store</a>
                    <a href="?___store=flowers&amp;___from_store=default"
                       class="currency_icon">Flowers Store</a>
                    <a href="?___store=furniture&amp;___from_store=default"
                       class="currency_icon">Furniture Store</a>
                </div>
            </div>
        </div>

        <!--<p class="welcome-msg">Default welcome msg! </p>-->
    </div>
</div>