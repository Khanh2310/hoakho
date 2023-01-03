@extends('client.layout_client_check_out')
@section('header_content')
    <div class="content-header">
        <div class="container">
            <div class="content-both">
                <div class="content-logo">
                    <a href="{{ URL::to('/') }}" class="biolife-logo"><img src="{{ asset('public/upload/logo-icon.svg') }}" alt="biolife logo" style="height: 55px;"></a>
                </div>
                <div class="col-spacing"></div>
                <div class="content-title-page">
                    Thanh Toán
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content_body')
    {{-- checkout custom --}}
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/checkout_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom/voucher_checkout_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/change_css.css') }}">
    <div class="content-checkout" style="background: rgb(245, 245, 245);">
        <div class="container">
            <form action="{{ URL::to('process_checkout') }}" method="post" name="form_content_check_out_pay">
                @csrf
                <div class="_1G9Cv7"></div>
                <div class="row">
                    <div class="cus_view place_trans">
                        <div class="content-title-address-trans">
                            <h4 class="title_place_trans"><i class="biolife-icon icon-location"></i> Địa Chỉ Nhận Hàng</h4>
                            <div class="content-tow-btn-trans">
                                <button type="button" id="btn_add_address_trans" class="btn-add-new-add-trans btn-address-trans op-0 btn_add_address_trans btn_open_modal_adress"><span class="icon-copy ti-plus"></span> Thêm Địa Chỉ Mới</button>
                                <a href="{{ URL::to('user/address') }}" class="btn-address-trans btn-thietlap op-0">Thiết Lập Địa Chỉ</a>
                            </div>
                        </div>
                        <div class="address_static_show">
                            @if ($static_trans)
                                <div class="static-address hidden_address">
                                    <strong class="info-trans info_trans_js_change">
                                        {{ $static_trans->trans_fullname }}
                                        {{ $static_trans->trans_phone }}
                                    </strong>
                                    <label class="detail-address address_detail_change">
                                        {{ $static_trans->trans_address }}
                                    </label>
                                    <i class="static static_change">Mặc Định</i>
                                    <button type="button" class="btn-green btn_change_address_trans" data-toggle="collapse" data-target="#change_address_trans">THAY ĐỔI</button>
                                </div>
                            @else
                                <div class="static-address hidden_address" style="display:flex; justify-content: center">
                                    <label style="opacity: .6;">Bạn chưa có địa chỉ nhận hàng nào</label>
                                    <button type="button" id="btn_add_address_trans" style="margin-left: 10px; margin-top: -8px;" class="btn-add-new-add-trans btn-address-trans btn_add_address_trans btn_open_modal_adress">
                                        <span class="icon-copy ti-plus"></span> Thêm Địa Chỉ Mới</button>
                                </div>
                            @endif
                            @if (count($cus_trans) > 0)
                                <div id="change_address_trans" class="collapse">
                                    @foreach ($cus_trans as $trans)
                                        <p>
                                            @if ($trans->trans_status == 1)
                                                <input type="radio" value="{{ $trans->trans_id }}" class="trans_id_radio" id="{{ $trans->trans_id }}" name="trans_id" checked>
                                            @else
                                                <input type="radio" value="{{ $trans->trans_id }}" class="trans_id_radio" id="{{ $trans->trans_id }}" name="trans_id">
                                            @endif

                                            <label for="{{ $trans->trans_id }}" class="static-address">
                                                <strong class="info-trans">{{ $trans->trans_fullname }} {{ $trans->trans_phone }}</strong>
                                                <label class="detail-address">
                                                    {{ $trans->trans_address }}
                                                </label>
                                                <input type="hidden" class="detail_address_trans_{{ $trans->trans_id }}" value="{{ $trans->trans_address }}">
                                                <input type="hidden" class="name_phone_{{ $trans->trans_id }}" value="{{ $trans->trans_fullname }} {{ $trans->trans_phone }}">
                                                @if ($trans->trans_status == 1)
                                                    <i class="static static_choose_{{ $trans->trans_id }}">Mặc Định</i>
                                                @else
                                                    <i class="static static_choose_{{ $trans->trans_id }}"></i>
                                                @endif

                                            </label>
                                        </p>
                                    @endforeach

                                    <div class="content-btn">
                                        <button type="button" class="btn-green btn_change_address_radio_button" data-toggle="collapse" data-target="#change_address_trans">Hoàn Thành</button>
                                        <button type="button" class="btn-back btn_show_hidden" data-toggle="collapse" data-target="#change_address_trans">Trở Lại</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="cus_view">
                        <div class="laptop">
                            <div class="content-show-product">
                                <table class="tbl-content-product-checkout" cellspacing="0" cellpadding="0">
                                    <thead>
                                        <td class="td-product">Sản phẩm</td>
                                        <td class="td-price">Đơn giá</td>
                                        <td class="td-qty">Số lượng</td>
                                        <td class="td-total_price">Thành tiền</td>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5"></td>
                                        </tr>
                                        @php
                                            $total_temporary_price = 0;
                                            $total_qty = 0;
                                        @endphp
                                        @foreach ($arrCart_id as $cart_id)
                                            @foreach ($all_cart as $cart)
                                                @if ($cart_id == $cart->cart_id)
                                                    @php
                                                        $price_prod;
                                                        $qty_prod;
                                                        $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($cart->product_id);
                                                    @endphp
                                                    <tr>
                                                        @foreach ($all_product as $product)
                                                            @if ($product->product_id == $cart->product_id)

                                                                <td class="info-product">
                                                                    <div class="content-info-product" style="display: flex;">
                                                                        <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="" style="width:45px; height:45px">
                                                                        <label class="name-product">{{ $product->product_name }}</label>
                                                                        <input type="checkbox" name="cart_id[]" value="{{ $cart->cart_id }}" style="opacity: 0" checked>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                                    @php
                                                                        $price_prod = $price_discount->price_now;
                                                                    @endphp
                                                                </td>
                                                                <td>
                                                                    {{ $cart->quantity }}
                                                                    <input type="hidden" value="{{ $cart->quantity }}" class="qty_prod_voucher_{{ $product->product_id }}">
                                                                    @php
                                                                        $qty_prod = $cart->quantity;
                                                                        $total_qty += $cart->quantity;
                                                                    @endphp

                                                                </td>
                                                                <td>
                                                                    {{ number_format($price_prod * $qty_prod, 0, ',', '.') }}₫

                                                                    @php
                                                                        $total_temporary_price += $price_prod * $qty_prod;
                                                                    @endphp
                                                                </td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mobile">
                            @include('client.layout.responsive_mobile.check_out_mobile')
                        </div>
                        <div class="total-price-pay">
                            Tổng số tiền ({{ $total_qty }} sản phẩm):
                            <div class="temporary-price">{{ number_format($total_temporary_price, 0, ',', '.') }}đ
                            </div>
                        </div>
                    </div>
                    <div class="cus_view">
                        <div class="content-voucher">
                            <img src="{{ asset('public/upload/voucher.png') }}" alt="" style="width: 30px">
                            <h4 class="titel-voucher">RADIUS Voucher</h4>
                            <div class="discount_voucher"></div>
                            <input type="hidden" value="" class="val_hidden_discount_voucher">
                            <button type="button" id="btn-open-model-voucher" class="choose-voucher btn-green" data-toggle="modal" data-target="#modal-choose-voucher">Chọn Voucher</button>
                            {{-- <button id="myBtn" type="button">Open Modal</button> --}}
                        </div>
                    </div>
                    <div class="view-payment">
                        <div class="content-payment-method row">
                            <h4 class="title-payment-method">Phương Thức Thanh Toán</h4>
                            <div class="btn-group btn-group-toggle group-checkbox-btn group-checkbox_btn op-0" data-toggle="buttons">
                                <label class="btn btn-outline-secondary active btn-outline-payment btn_cash">
                                    <input type="radio" name="payment_method" value="0" id="cash_pay" autocomplete="off" checked=""> Thanh toán khi nhận hàng
                                    <img src="{{ asset('public/upload/payment-method.svg') }}" style="height: 30px; padding-left: 5px" alt="">
                                </label>
                                <label for=""></label>
                                <label class="btn btn-outline-secondary btn-outline-payment btn_paypal">
                                    <input type="radio" name="payment_method" value="1" id="paypal" autocomplete="off">
                                    Paypal
                                    <img src="{{ asset('public/upload/paypal.svg') }}" style="height: 30px; padding-left: 5px" alt="">
                                </label>
                            </div>
                            <div class="content-text-payment_method text_payment_method">
                                Thanh toán khi nhận hàng
                            </div>
                            <button type="button" class="btn-green btn-change-method btn_change_method_pay">Thay
                                Đổi</button>
                        </div>
                    </div>
                    <div class="view-summary">
                        <div class="content-total-summary">
                            {{-- total_start --}}
                            <div class="title-total-price">Tổng tiền hàng</div>
                            <div class="val-total-price">{{ number_format($total_temporary_price, 0, ',', '.') }}đ</div>
                            <input type="hidden" class="total_start" value="{{ $total_temporary_price }}">
                            {{-- fee ship --}}
                            <div class="format-free-trans">Phí vận chuyển</div>
                            <div class="val-free-trans fee_ship_tran_text">{{ number_format($fee_ship, 0, ',', '.') }}đ</div>
                            <input type="hidden" class="fee_ship" name="fee_ship" value="{{ $fee_ship }}">
                            {{-- total voucher --}}
                            <div class="format-total-voucher">Tổng cộng Voucher giảm giá:</div>
                            <div class="val-total-voucher">0đ</div>
                            <input type="hidden" name="voucher_code" class="val_hidden_voucher_code" value="">
                            <input type="hidden" value="0" class="val_discount_voucher">
                            {{-- sumary total price check out --}}
                            <div class="format-total-summary">Tổng thanh toán:</div>
                            @php
                                $summary_total_order = $total_temporary_price + $fee_ship;
                            @endphp
                            <div class="val-total-summary">{{ number_format($summary_total_order, 0, ',', '.') }}đ</div>
                            <input type="hidden" class="summary_total_order" name="summary_total_order" value="{{ $summary_total_order }}">
                            <input type="hidden" class="old_summary_total_order" value="{{ $summary_total_order }}">


                        </div>
                        <div class="view-btn-buy">
                            <div class="title-rule">Nhấn "Đặt hàng" đồng nghĩa với việc bạn đồng ý tuân theo
                                <a href="{{ URL::to('/terms_conditions') }}" target="_blank" rel="noopener noreferrer">Điều khoản RADIUS Hoa Khô
                                </a>
                            </div>
                            <button type="button" class="btn-dathang btn_dathang">Đặt Hàng</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <!-- The Modal Choose Voucher -->
    <div id="modal_voucher" class="modal">
        <!-- Modal content -->
        <div class="modal-content container">
            <div class="modal-header-cus">
                <span class="close">&times;</span>
                <h4>Chọn Voucher</h4>
            </div>
            <div class="modal-body-cus">
                <div class="content-enter-voucher">
                    <label class="title-code-voucher col-2">Mã Voucher: </label>
                    <div class="content-input-voucher">
                        <input type="text" id="voucher_code_apply" class="input-voucher col-8" placeholder="Mã RADIUS Voucher">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    </div>
                    <button type="button" class="btn-green btn-voucher col-2 btn_apply_voucher" disabled>ÁP DỤNG</button>
                </div>
                <div class="container__voucher-list">
                    @foreach ($arrCart_id as $cart_id)
                        @foreach ($all_cart as $cart)
                            @if ($cart_id == $cart->cart_id)
                                @foreach ($storage_customer_voucher as $product_voucher)
                                    @if ($product_voucher->product_id == $cart->product_id)
                                        <div class="container__voucher-item" style="background-color: #f8f8f8; height: 88px;">
                                            <div class="container__voucher-item--left">
                                                <div class="voucher-item--left-img">
                                                    <img src="{{ asset('public/upload/voucher_image.png') }}" alt="">
                                                </div>
                                                <div class="voucher__item--left-name" style="font-size: 10px;">
                                                    RADIUS Hoa Khô
                                                </div>
                                                <div class="_2t7jNq _3LWUvt"></div>
                                            </div>
                                            <div class="container__voucher-item--right">
                                                <div class="voucher-item--right-info">
                                                    <div class="voucher-item--right-info-name">
                                                        {{ $product_voucher->voucher_name }}
                                                    </div>
                                                    <div class="voucher-item--right-info-end-date">
                                                        HSD: {{ date('d/m/Y', strtotime($product_voucher->end_date)) }}
                                                    </div>
                                                </div>
                                                <div class="voucher-item--right-btn">
                                                    <a href="#" class="choose_voucher choose_voucher_{{ $product_voucher->voucher_code }}" data-id="{{ $product_voucher->voucher_code }}">Dùng Ngay</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- ----------------------------------------------- --}}
    <!-- The Modal Add Address Trans -->
    <div class="modal_address modal">
        <!-- Modal content -->
        <div class="modal-content_address container">
            <div class="modal-header-cus modal-header-address">
                <span class="close close_modal_address">&times;</span>
                <h4>Địa Chỉ Mới</h4>
            </div>
            <div class="modal-body-cus">
                <div class="content-add-address">
                    <form name="form_add_address">
                        @csrf
                        <div class="line">
                            <input type="text" name="fullname" class="form-control input trans_fullname upper_val check_format_name_input" placeholder="Họ và tên" onblur="return upberFirstKey()">
                            <div class="" style="width: 50px"></div>
                            <input type="text" name="phone" class="form-control input trans_phone" placeholder="Số điện thoại">
                        </div>
                        <div class="line">
                            <select name="city" id="city_add_trans" class="select form-control">
                                <option value="">Chọn Tỉnh/TP</option>
                                @foreach ($citys as $city)
                                    <option value="{{ $city->matp }}" max="5">{{ $city->name_tp }}</option>
                                @endforeach

                            </select>
                            <select name="district" id="district_add_trans" class="select form-control">
                                <option value="">Chọn Quận/Huyện</option>
                            </select>
                            <select name="ward" id="ward_add_trans" class="select form-control">
                                <option value="">Chọn Phường/Xã</option>

                            </select>
                        </div>
                        <div class="line">
                            <textarea class="upper_val" name="detail_address" id="detail_address" cols="80" rows="3" placeholder="Địa chỉ cụ thể" onblur="return upberFirstKey()"></textarea>
                        </div>
                    </form>
                </div>
            </div>
            <div class="content-modal-footer-address">
                <button class="btn btn-secondary btn_back_modal_address" style="margin-right: 10px">TRỞ LẠI</button>
                <button class="btn btn-radius-color btn_submit_form_add_address">HOÀN THÀNH</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/font_end/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- check out custom --}}
    <script src="{{ asset('public/font_end/custom/checkout_custom.js') }}"></script>

@endsection
