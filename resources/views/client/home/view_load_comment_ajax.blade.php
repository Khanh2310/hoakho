@if (count($all_comment) > 0)
    @foreach ($all_comment as $comment)
        @if ($comment->status == 0 && $comment->customer_id == Session::get('customer_id'))
            <li class="review" style="margin-right: 16px; margin-left: -16px; opacity: .8;background-color:#f5f5f5;">
                <div class="comment-container" style="padding-left: 20px">
                    <div class="row">
                        <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                            <div class="content_info_customer">
                                @foreach ($customers as $customer)
                                    @if ($comment->customer_id == $customer->customer_id)
                                        <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" style="width: 60px; height: 60px; border-radius: 50%" alt="">
                                        <div class="content-name-rating">
                                            <p class="comment-in"><span class="post-name" style="font-size: 17px">{{ $customer->username }}</span></p>
                                            <div class="rating">
                                                <p class="star-rating">
                                                    @php
                                                        $convert_persen = 0;
                                                    @endphp
                                                    @foreach ($all_rating as $rating)
                                                        @if ($rating->customer_id == $customer->customer_id)
                                                            @php
                                                                $rating_level = $rating->rating_level;
                                                            @endphp
                                                        @break
                                                    @else
                                                        @php
                                                            $rating_level = 0;
                                                        @endphp
                                                    @endif
                                    @endforeach
                                    @if ($rating_level == 1)
                                        @php
                                            $convert_persen = 20;
                                        @endphp
                                    @elseif($rating_level == 2)
                                        @php
                                            $convert_persen = 40;
                                        @endphp
                                    @elseif($rating_level == 3)
                                        @php
                                            $convert_persen = 60;
                                        @endphp
                                    @elseif($rating_level == 4)
                                        @php
                                            $convert_persen = 80;
                                        @endphp
                                    @elseif($rating_level == 5)
                                        @php
                                            $convert_persen = 100;
                                        @endphp
                                    @endif
                                    <span class="width-{{ $convert_persen }}percent"></span>
                                    </p>
                            </div>
                        </div>
        @endif
    @endforeach
    <span class="post-date date-comment">{{ date('d/m/Y H:i a', strtotime($comment->created_at)) }}</span>
    @if (Session::get('customer_id') == $comment->customer_id)
        <div class="option_comment">
            <div class="dropdown_option_comment">
                <i class="fa fa-ellipsis-h dot" style="cursor: pointer;"></i>
                <div class="dropdown_content_option_comment">
                    <a class="btn_open_modal_delete_comment btn_delete_comment" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                        <i class="fa fa-trash-o" aria-hidden="true"></i> xóa
                    </a>
                    @if (Session::get('customer_id') == $comment->customer_id && $comment->status == 0)
                        <a style="cursor: pointer;" class="btn_update_comment" data-id="{{ $comment->comment_id }}">
                            <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    {{-- </p> --}}
    </div>

    <p class="author place_order" style="margin-left: 70px"><i class="fa fa-check-circle" style="color: var(--radius-color);"></i> đã mua tại <b class="brand_mku">RADIUS Hoa Khô</b></p>
    <p class="comment-text comment_message comment_message_{{ $comment->comment_id }}" style="font-size: 15px">{{ $comment->comment_message }}</p>
    <div class="content_area_update_comment content_area_update_comment_{{ $comment->comment_id }}">
        <textarea class="area_update_comment area_update_comment_{{ $comment->comment_id }}" style="padding: 2px 5px ">{{ $comment->comment_message }}</textarea>
        <div class="content_btn_update_comment">
            <button class="btn btn-secondary btn_huy_update_comment" data-id="{{ $comment->comment_id }}">Hủy</button>
            <button class="btn btn-success btn_confirm_update_comment" data-id="{{ $comment->comment_id }}">Sửa</button>
        </div>
    </div>
    </div>
    <div class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
        <span class="title">Đánh giá này có hữu ích?</span>
        <ul class="actions">
            @php
                $session = Session::get('user_like_comment_' . $comment->comment_id);
            @endphp
            @if (isset($session))
                <li>
                    <a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="color: var(--radius-color); cursor: pointer;" data-id="{{ $comment->comment_id }}">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích ({{ $comment->comment_useful }})</span>
                    </a>
                </li>
                <h4 class="announce_waiting_comment">
                    Bình luận của bạn đang chờ xét duyệt
                </h4>
                <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
            @else
                <li>
                    <a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                        <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích ({{ $comment->comment_useful }})</span>
                    </a>
                </li>
                <h4 class="announce_waiting_comment">
                    Bình luận của bạn đang chờ xét duyệt
                </h4>
                <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
            @endif

        </ul>
    </div>

    </div>
    </div>
    </li>
@elseif($comment->status == 1)
    <li class="review" style="margin-right: 16px; margin-left: -16px">
        <div class="comment-container" style="padding-left: 20px">
            <div class="row">
                <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                    <div class="content_info_customer">
                        @foreach ($customers as $customer)
                            @if ($comment->customer_id == $customer->customer_id)
                                <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" style="width: 60px; height: 60px; border-radius: 50%" alt="">
                                <div class="content-name-rating">
                                    <p class="comment-in"><span class="post-name" style="font-size: 17px">{{ $customer->username }}</span></p>
                                    <div class="rating">
                                        <p class="star-rating">
                                            @php
                                                $convert_persen = 0;
                                            @endphp
                                            @foreach ($all_rating as $rating)
                                                @if ($rating->customer_id == $customer->customer_id)
                                                    @php
                                                        $rating_level = $rating->rating_level;
                                                    @endphp
                                                @break
                                            @else
                                                @php
                                                    $rating_level = 0;
                                                @endphp
                                            @endif
                            @endforeach
                            @if ($rating_level == 1)
                                @php
                                    $convert_persen = 20;
                                @endphp
                            @elseif($rating_level == 2)
                                @php
                                    $convert_persen = 40;
                                @endphp
                            @elseif($rating_level == 3)
                                @php
                                    $convert_persen = 60;
                                @endphp
                            @elseif($rating_level == 4)
                                @php
                                    $convert_persen = 80;
                                @endphp
                            @elseif($rating_level == 5)
                                @php
                                    $convert_persen = 100;
                                @endphp
                            @endif
                            <span class="width-{{ $convert_persen }}percent"></span>
                            </p>
                    </div>
                </div>
@endif
@endforeach
<span class="post-date date-comment">{{ date('d/m/Y H:i a', strtotime($comment->created_at)) }}</span>
@if (Session::get('customer_id') == $comment->customer_id)
    <div class="option_comment">
        <div class="dropdown_option_comment">
            <i class="fa fa-ellipsis-h dot" style="cursor: pointer;"></i>
            <div class="dropdown_content_option_comment">
                <a class="btn_open_modal_delete_comment btn_delete_comment" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                    <i class="fa fa-trash-o" aria-hidden="true"></i> xóa
                </a>
                @if (Session::get('customer_id') == $comment->customer_id && $comment->status == 0)
                    <a style="cursor: pointer;" class="btn_update_comment" data-id="{{ $comment->comment_id }}">
                        <i class="fa fa-pencil" aria-hidden="true"></i> sửa
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
{{-- </p> --}}
</div>

<p class="author place_order" style="margin-left: 70px"><i class="fa fa-check-circle" style="color: var(--radius-color);"></i> đã mua tại <b class="brand_mku">RADIUS Hoa Khô</b></p>
<p class="comment-text comment_message comment_message_{{ $comment->comment_id }}" style="font-size: 15px">{{ $comment->comment_message }}</p>
<div class="content_area_update_comment content_area_update_comment_{{ $comment->comment_id }}">
    <textarea class="area_update_comment area_update_comment_{{ $comment->comment_id }}" style="padding: 2px 5px ">{{ $comment->comment_message }}</textarea>
    <div class="content_btn_update_comment">
        <button class="btn btn-secondary btn_huy_update_comment" data-id="{{ $comment->comment_id }}">Hủy</button>
        <button class="btn btn-success btn_confirm_update_comment" data-id="{{ $comment->comment_id }}">Sửa</button>
    </div>
</div>
</div>
<div class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
    <span class="title">Đánh giá này có hữu ích?</span>
    <ul class="actions">
        @php
            $session = Session::get('user_like_comment_' . $comment->comment_id);
        @endphp
        @if (isset($session))
            <li><a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="color: var(--radius-color); cursor: pointer;" data-id="{{ $comment->comment_id }}">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích ({{ $comment->comment_useful }})</span>
                </a></li>
            <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
        @else
            <li><a class="btn-act like btn_useful_comment btn_useful_comment_{{ $comment->comment_id }}" style="cursor: pointer;" data-id="{{ $comment->comment_id }}">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <span class="txt_count_comment_useful_{{ $comment->comment_id }}">Hữu ích ({{ $comment->comment_useful }})</span>
                </a></li>
            <input type="hidden" class="hidden_check_comment_like_{{ $comment->comment_id }}" name="" id="" value="{{ $session }}">
        @endif

    </ul>
</div>

</div>
</div>
</li>
@endif
@endforeach
@else
<div class="center pd-20" style="font-size: 18px;padding-top: 30px; opacity: .5;">Sản phẩm chưa có đánh giá nào</div>
@endif
<script src="{{ asset('public/font_end/custom/rating_comment_single_page_ajax.js') }}"></script>
