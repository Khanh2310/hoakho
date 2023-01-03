@if (count($result_search) > 0)
    @foreach ($result_search as $product)
    @php
        $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
    @endphp
        <form>
            @csrf
            <input type="hidden" value="{{ $product->product_name }}" id="recently_viewed_product_name_{{ $product->product_id }}">
            <input type="hidden" value="{{ number_format($price_discount->price_now, 0, ',', '.') }}₫" id="recently_viewed_product_price_{{ $product->product_id }}">
        </form>
        <a href="{{ URL::to('product_detail_slug/' . $product->slug) }}" class="btn_recently_viewed" data-id="{{ $product->product_id }}" id="recently_viewed_product_detail_{{ $product->product_id }}">
            <div class="items" id="items">
                <div class="content_image_product_search">
                    <img src="{{ URL::to('public/upload/' . $product->product_image) }}" alt=""
                        style="width: 65px; height: 65px;" id="recently_viewed_product_img_{{ $product->product_id }}">
                </div>
                <div class="content_info_product" style="padding-left: 15px">
                    <div class="name">{{ $product->product_name }}</div>
                    <div class="content_price">
                        @if ($price_discount->percent_discount == 0)
                            <div class="price" style="font-size: 15px">{{ number_format($price_discount->price_now, 0, ',', '.') }}đ</div>
                        @else
                            <div class="price" style="font-size: 15px">{{ number_format($price_discount->price_now, 0, ',', '.') }}đ</div>
                            <del class="price_old">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</del>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ln"></div>
        </a>
    @endforeach
@else
    <div class="search_none" style="font-size: 15px">Không tìm thấy sản phẩm nào </div>
@endif
<script src="{{ asset('public/font_end/custom_ui/js/recently_viewed.js') }}"></script>
