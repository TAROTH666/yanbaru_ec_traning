
<header id="header" class="full-header">
  <div id="header-wrap">
    <div class="container">
      <div class="header-row">
        
      <!-- Logo
      ============================================= -->
        <div id="logo">
          <a href="index.html" class="standard-logo" data-dark-logo="images/logo-dark.png"><img
              src="images/logo.png" alt="Canvas Logo"></a>
          <a href="index.html" class="retina-logo" data-dark-logo="images/logo-dark@2x.png"><img
              src="images/logo@2x.png" alt="Canvas Logo"></a>
        </div><!-- #logo end -->

        <div class="header-misc">
          <!-- Top Search
							============================================= -->
          <div id="top-search" class="header-misc-icon">
            <a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
          </div><!-- #top-search end -->

          <!-- Top Cart
							============================================= -->
          <div id="top-cart" class="header-misc-icon d-none d-sm-block">
            <a href="#" id="top-cart-trigger"><i class="icon-line-bag"></i><span
                class="top-cart-number">5</span></a>
            <div class="top-cart-content">
              <div class="top-cart-title">
                <h4>Shopping Cart</h4>
              </div>
              <div class="top-cart-items">
                <div class="top-cart-item">
                  <div class="top-cart-item-image">
                    <a href="#"><img src="images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
                  </div>
                  <div class="top-cart-item-desc">
                    <div class="top-cart-item-desc-title">
                      <a href="#">Blue Round-Neck Tshirt with a Button</a>
                      <span class="top-cart-item-price d-block">$19.99</span>
                    </div>
                    <div class="top-cart-item-quantity">x 2</div>
                  </div>
                </div>
                <div class="top-cart-item">
                  <div class="top-cart-item-image">
                    <a href="#"><img src="images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
                  </div>
                  <div class="top-cart-item-desc">
                    <div class="top-cart-item-desc-title">
                      <a href="#">Light Blue Denim Dress</a>
                      <span class="top-cart-item-price d-block">$24.99</span>
                    </div>
                    <div class="top-cart-item-quantity">x 3</div>
                  </div>
                </div>
              </div>
              <div class="top-cart-action">
                <span class="top-checkout-price">$114.95</span>
                <a href="#" class="button button-3d button-small m-0">View Cart</a>
              </div>
            </div>
          </div><!-- #top-cart end -->


        </div>


        @if (Auth::check())
        <p>{{ !empty(Auth::user()) ? Auth::user()->last_name . Auth::user()->first_name : 'ユーザー' }} さん</p>
        <nav class="primary-menu">
          <ul class="menu-container">
            <li class="menu-item">
              <a class="menu-link" href=" {{ url('/show') }} ">商品検索</a>
            </li>
            <li class=" menu-item">
                <a class="menu-link" href=" {{ url('/cartlist') }} "">カート</a>
            </li>
            <li class=" menu-item">
                <a class="menu-link" href=" {{ url('/order-history') }} "">注文履歴</a>
            </li>
            <li class=" menu-item">
                <a class="menu-link" href=" {{ url('/user_info') }} "">ユーザ情報</a>
            </li>
            <li class=" menu-item">
                <a class="menu-link" href=" {{ url('/logout') }} "">ログアウト</a>
            </li>
        </ul>
    </nav>
    @else
    <nav class=" pc-nav">
      <ul>
        <li class=" menu-item">
          <a class="menu-link" href=" {{ url('/login') }} "">ログイン</a>
            </li>
            <li class=" menu-item">
              <a class="menu-link" href=" {{ url('/signup') }} "">新規登録</a>
            </li>
        </ul>
    </nav>
    </div>
</div>
</div>
@endif
</header>