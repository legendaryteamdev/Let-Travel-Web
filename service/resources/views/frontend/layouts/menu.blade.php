<!--Menus Start-->
<div class="cy_menu_wrapper">
        <div class="cy_logo_box">
            <a href="index.html"><img src="public/theme/images/logo.png" alt="logo" class="img-fluid"/></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <button class="cy_menu_btn">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</button>
                    <div class="cy_menu">
                        <nav>
                            <ul>
                                <li><a href="{{ route('home')}}" class="active">home</a></li>
                                <li><a href="{{ route('about-us')}}">about</a></li>
                                <li><a href="{{ route('resort')}}">resort</a>
                                    {{-- <ul class="sub-menu">
                                        <li><a href="event.html">event</a></li>
                                        <li><a href="event_single.html">event single</a></li>
                                    </ul> --}}
                                </li>
                                <li><a href="{{ route('province')}}">province</a></li>
                                {{-- <li class="dropdown"><a href="javascript:;">pages</a>
                                    <ul class="sub-menu">
                                        <li><a href="shop.html">shop</a></li>
                                        <li><a href="shop_single.html">shop single</a></li>
                                        <li><a href="cart.html">cart</a></li>
                                        <li><a href="checkout.html">checkout</a></li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </li> --}}
                                {{-- <li><a href="gallery.html">gallery</a></li> --}}
                                <li><a href="{{ route('contact-us')}}">contact us</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="cy_search">
                        <a href="#" class="search_open"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
</div>
    <!-- search section -->
    <div class="cy_search_form">
        <button class="search_close"><i class="fa fa-times"></i></button>
        <div class="cy_search_input">
        <input type="search" placeholder="search">
        <i class="fa fa-search"></i>
        </div>
    </div>