@if (count($wish_lish) > 0)
    <ul class="products">
            @foreach ($wish_lish as $wish)
                <li>
                    <div class="minicart-item">
                        @foreach ($all_product as $product)
                            @if ($wish->product_id == $product->product_id)
                                @php
                                    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
                                @endphp
                                <div class="thumb">
                                    <a href="{{ URL::to('product_detail/'.$product->product_id) }}"><img src="{{ asset('public/upload/'.$product->product_image) }}" style="width: 90px; height: 90px;" alt="National Fresh"></a>
                                </div>
                                <div class="left-info">
                                    <div class="product-title"><a href="{{ URL::to('product_detail/'.$product->product_id) }}" class="product-name">{{ $product->product_name }}</a></div>
                                    <div class="price">
                                        @if ($price_discount->percent_discount == 0)
                                            <ins><span class="price-amount">
                                                <span class="currencySymbol">
                                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                </span></span>
                                            </ins>
                                        @else
                                            <ins><span class="price-amount">
                                                <span class="currencySymbol">
                                                    {{ number_format($price_discount->price_now, 0, ',', '.') }}đ
                                                </span></span>
                                            </ins>
                                            <del><span class="price-amount">
                                                <span class="currencySymbol">
                                                    {{ number_format($price_discount->price_old, 0, ',', '.') }}đ
                                                </span></span>
                                            </del>
                                        @endif
                                    </div>
                                </div>
                                <div class="action">
                                    <a href="#" data-id="{{ $wish->wish_list_id }}" class="btn_open_modal_delete_wishlist"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </li>
            @endforeach
    </ul>
@else
    <p class="minicart-empty">không có sản phẩm nào</p>
@endif
{{-- MODAL delete cart item --}}
<div class="modal_delete_item_wishlist" style="display: none">
    <!-- Modal content -->
    <div class="modal_content_delete_item_wishlist">
        <div class="modal-header-cus">
            <span class="close_delete_address close close_modal">&times;</span>
            <h4>Thông báo</h4>
        </div>
        <div class="modal-body-cus">
            <div class="content_form_delete_item_wishlist">
                <form name="form_delete_item_wishlist" action="{{ URL::to('remove_item_wish_list') }}" method="post">
                    @csrf
                    <h5>Bạn có thực sự muốn xóa sản phẩm này ra danh sách yêu thích ?</h5>
                    <input type="hidden" name="wish_list_id" class="val_delete_item_wishlist" id="">
                </form>
            </div>
        </div>
        <div class="content_footer_modal_delete_item_wishlist">
            <button class="btn btn-secondary btn_cancel_modal_delete_item_cart" style="margin-right: 10px">TRỞ LẠI</button>
            <button class="btn btn-success btn_confirm_delete_item_wish_list">XÓA</button>
        </div>
    </div>
</div>
<script src="{{ asset('public/font_end/custom_ui/js/ajax_wish_list.js') }}"></script>
