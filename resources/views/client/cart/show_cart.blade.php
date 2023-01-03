@extends('client.layout_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/cus/css/custom_breadcrumb.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_account/modal_address.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/custom_background.css') }}">
    <div class="container">
        <nav class="biolife-nav cus_breadcrumb">
            <ul>
                <li class="nav-item"><a href="{{ URL::to('/') }}" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><span class="current-page">Giỏ hàng</span></li>
            </ul>
        </nav>
    </div>
    <div class="page-contain shopping-cart">
        <!-- Main content -->
        <div id="main-content" class="main-content">
            <div class="container">
                <!--Cart Table-->
                @if (count($all_cart) > 0 || count($old_date_cart) > 0)
                    <div class="shopping-cart-container">
                        @if (count($all_cart) > 0)
                            <div class="row" style="margin-bottom: 30px">
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="box-title"></h3>
                                    <div class="cus_bg_show_cart">
                                        <form class="shopping-cart-form form_checkbox_cart" action="{{ URL::to('checkout') }}" method="post" name="form_show_cart">
                                            @csrf
                                            <table class="shop_table cart-form">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="container-checkbox">
                                                                <input type="checkbox" class="check_all" checked>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </th>
                                                        <th class="product-name">Sản Phẩm</th>
                                                        <th class="product-price">Giá</th>
                                                        <th class="product-quantity">Số Lượng</th>
                                                        <th class="product-subtotal">Thành Tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($all_cart as $cart)
                                                        <tr class="cart_item">
                                                            <td>
                                                                <label class="container-checkbox" style="margin-left: 10px">
                                                                    <input type="checkbox" class="check_item_{{ $cart->cart_id }} item_check" name="itemCart[]" value="{{ $cart->cart_id }}" checked>
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </td>
                                                            <td class="product-thumbnail" data-title="Product Name">
                                                                @foreach ($all_product as $product)
                                                                    @if ($product->product_id == $cart->product_id)
                                                                        <a class="prd-thumb" href="{{ URL::to('product_detail/' . $product->product_id) }}">
                                                                            <figure><img style="height: 113px; width: 113px" src="{{ asset('public/upload/' . $product->product_image) }}" alt="shipping cart"></figure>
                                                                        </a>
                                                                        <a class="prd-name" href="{{ URL::to('product_detail/' . $product->product_id) }}">{{ $product->product_name }}</a>
                                                                    @endif
                                                                @endforeach

                                                                <div class="action">
                                                                    {{-- href="{{ URL::to('remove_item_cart/'.$cart->cart_id) }} --}}
                                                                    {{-- <a href="#" class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> --}}
                                                                    <a class="remove btn_open_modal_delete_item_cart" data-id="{{ $cart->cart_id }}" style="cursor: pointer;"><i class="fa fa-trash-o" aria-hidden="true"></i> xóa</a>
                                                                </div>
                                                            </td>
                                                            <td class="product-price" data-title="Price">
                                                                <div class="price price-contain">
                                                                    @php
                                                                        $price_product = 0;
                                                                        $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($cart->product_id);
                                                                    @endphp
                                                                    @if ($price_discount->percent_discount == 0)
                                                                        <ins>
                                                                            <span class="price-amount">
                                                                                <span class="currencySymbol">
                                                                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                                                    @php
                                                                                        $price_product = $price_discount->price_now;
                                                                                    @endphp
                                                                                </span></span>
                                                                        </ins>
                                                                    @else
                                                                        <ins>
                                                                            <span class="price-amount">
                                                                                <span class="currencySymbol">
                                                                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                                                    @php
                                                                                        $price_product = $price_discount->price_now;
                                                                                    @endphp
                                                                                </span></span>
                                                                        </ins>
                                                                        <del>
                                                                            <span class="price-amount">
                                                                                <span class="currencySymbol">
                                                                                    {{ number_format($price_discount->price_old, 0, ',', '.') }}đ
                                                                                </span>
                                                                            </span>
                                                                        </del>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity" data-title="Quantity">
                                                                <div class="quantity-box type1">
                                                                    <div class="qty-input">
                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                        <input type="hidden" class="val_price_update_cart_{{ $cart->cart_id }}" value="{{ $price_product }}">
                                                                        <input type="number" class="val_quantity_update_cart_{{ $cart->cart_id }} val_update_cart_change" data-id="{{ $cart->cart_id }}" name="" value="{{ $cart->quantity }}"
                                                                            data-max_value="20" data-min_value="1" data-step="1">{{ $cart->cart_id }}
                                                                        {{-- get max val product --}}
                                                                        @foreach ($product_storage as $sto_prod)
                                                                            @if ($cart->product_id == $sto_prod->product_id)
                                                                                <input type="hidden" class="max_val_{{ $cart->cart_id }}" value="{{ $sto_prod->total_quantity_product }}">
                                                                            @endif
                                                                        @endforeach
                                                                        {{-- end get max val product --}}
                                                                        <a href="#" class="qty-btn btn-up btn_up_update_cart btn_up_update_cart_{{ $cart->cart_id }}" data-id="{{ $cart->cart_id }}"><i class="fa fa-caret-up"
                                                                                aria-hidden="true"></i></a>
                                                                        <a href="#" class="qty-btn btn-down btn_down_update_cart btn_down_update_cart_{{ $cart->cart_id }}" data-id="{{ $cart->cart_id }}"><i class="fa fa-caret-down"
                                                                                aria-hidden="true"></i></a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="product-subtotal" data-title="Total">
                                                                <div class="price price-contain">
                                                                    <ins><span class="price-amount"><span
                                                                                class="currencySymbol totol_price_cart_item_update_{{ $cart->cart_id }} ">{{ number_format($price_product * $cart->quantity, 0, ',', '.') }}đ</span></span></ins>
                                                                    <input type="hidden" class="get_total_price_cart_item_check_{{ $cart->cart_id }} change_get_total_price_cart_item_check" value="{{ $price_product * $cart->quantity }}">
                                                                    {{-- <del><span class="price-amount"><span class="currencySymbol">£</span>95.00</span></del> --}}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                                    <div class="shpcart-subtotal-block" style="background-color: #fff; border-bottom: 1px solid rgba(0, 0, 0, 0.09);">
                                        <div class="subtotal-line">
                                            <b class="stt-name">Tổng sản phẩm <span class="sub total_item_cart">({{ count($all_cart) }} sản phẩm)</span></b>
                                        </div>
                                        <div class="subtotal-line">
                                            <b class="stt-name">Tổng tiền</b>
                                            <span class="stt-price show_total_price_check_item_cart">{{ number_format($total_price_all_cart, 0, ',', '.') }}đ</span>
                                            <input type="hidden" value="{{ $total_price_all_cart }}" class="show_total_price_check_item_cart_hidden">
                                        </div>
                                        <div class="tax-fee">

                                        </div>
                                        <div class="btn-checkout content_btn_check_out">
                                            <a class="btn checkout submit_form_check_out" style="border-radius: 5px">Mua Hàng</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (count($old_date_cart) > 0)
                            @if (count($old_date_cart) > 0 && count($all_cart) > 0)
                                <div class="row">
                                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                        <div class="line_spacing"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                    <div class="cus_bg_show_cart_disalbe">
                                        <h3 class="box-title">Hết hàng</h3>
                                        <form class="shopping-cart-form" action="#" method="post">
                                            <table class="shop_table cart-form">
                                                <thead>
                                                    <tr>
                                                        <th class="product-name">Sản Phẩm</th>
                                                        <th class="product-price">Giá</th>
                                                        <th>Tình Trạng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($old_date_cart as $old_cart)
                                                        <tr class="cart_item">
                                                            <td class="product-thumbnail" data-title="Product Name">
                                                                @foreach ($all_product as $product)
                                                                    @if ($product->product_id == $old_cart->product_id)
                                                                        <a class="prd-thumb" href="#">
                                                                            <figure><img style="height: 113px; width: 113px" src="{{ asset('public/upload/' . $product->product_image) }}" alt="shipping cart"></figure>
                                                                        </a>
                                                                        <a class="prd-name" href="#">{{ $product->product_name }}</a>
                                                                    @endif
                                                                @endforeach

                                                                <div class="action">
                                                                    <a class="remove btn_open_modal_delete_item_cart" data-id="{{ $old_cart->cart_id }}" style="cursor: pointer;"><i class="fa fa-trash-o" aria-hidden="true"></i> xóa</a>
                                                                </div>
                                                            </td>
                                                            <td class="product-price" data-title="Price">
                                                                <div class="price price-contain">
                                                                    <ins>
                                                                        <span class="price-amount"><span class="currencySymbol">

                                                                                @foreach ($product_price as $price)
                                                                                    @if ($old_cart->product_id == $price->product_id)
                                                                                        {{ number_format($price->price, 0, ',', '.') }}
                                                                                    @endif
                                                                                @endforeach
                                                                            </span>vnđ</span>
                                                                    </ins>
                                                                    {{-- <del><span class="price-amount"><span class="currencySymbol">£</span>95.00</span></del> --}}
                                                                </div>
                                                            </td>
                                                            <td class="product-quantity" data-title="Quantity">
                                                                <h3><span class="badge badge-secondary">Hết hàng</span></h3>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                                    <div class="line_spacing"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="center" style="text-align: center">
                        <img src="{{ asset('public/upload/noitemcart.png') }}" alt="" width="400px" height="355px">
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- MODAL delete cart item --}}
    <div class="modal_delete_address modal modal_delete_item_cart">
        <!-- Modal content -->
        <div class="modal-content_delete_address container" style="height: auto;">
            <div class="modal-header-cus modal-header-address">
                <span class="close_delete_address close close_modal">&times;</span>
                <h4>Thông báo</h4>
            </div>
            <div class="modal-body-cus">
                <div class="content-delete-address">
                    Bạn có thực sự muốn xóa sản phẩm này ra khỏi giỏ hàng ?
                    <form name="form_delete_item_cart" action="{{ URL::to('remove_item_cart') }}" method="post">
                        @csrf
                        <input type="hidden" name="cart_id" class="delete_item_cart" id="">
                    </form>
                </div>
            </div>
            <div class="content-modal-footer-address">
                <button class="btn btn-secondary btn-back-modal-address close_modal" id="close_delete_address" style="margin-right: 10px">TRỞ LẠI</button>
                <button class="btn btn-radius-color btn_confirm_delete_item_cart">XÓA</button>
            </div>
        </div>
    </div>
@endsection
