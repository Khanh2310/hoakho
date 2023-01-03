<input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{-- modal filter order follow price  --}}
<div class="modal fade" id="Modal_filter_order_follow_price">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-6">
                            <input class="form-control price_start_order" type="number" name="price_start_order"
                            value="" min='1' placeholder="Giá Từ ...₫">
                        </div>
                        <div class="col-6">
                            <input class="form-control price_end_order" type="number" name="price_end_order"
                                value="" min='1' placeholder="Đến ...₫">
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-success" id="btn_filter_order_fol_price">Lọc</button>
            </div>
        </div>
    </div>
</div>
{{-- modal filter order fol payment status --}}
<div class="modal fade" id="Modal_filter_order_follow_payment_status">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Trạng Thái Thanh Toán</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-6">
                            <button class="btn btn-warning btn-block btn_payment"
                                data-payment="0" data-dismiss="modal">
                                Chưa thanh toán
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success btn-block btn_payment"
                                data-payment="1" data-dismiss="modal">
                                Đã thanh toán
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal filter order fol method payment --}}
<div class="modal fade" id="Modal_filter_order_follow_method_pay">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Hình Thức Thanh Toán</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-6">
                            <button class="btn btn-warning btn-block btn_payment_method"
                                data-method-pay="1" data-dismiss="modal">
                                <img src="{{ asset('public/upload/paypal.svg') }}" style="height: 50px;"
                                    alt="">
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success btn-block btn_payment_method"
                                data-method-pay="0" data-dismiss="modal">
                                <img src="{{ asset('public/upload/payment-method.svg') }}" style="height: 50px;"
                                 alt="">
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal filter order follow date  --}}
<div class="modal fade" id="Modal_filter_order_follow_date">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Ngày </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_order_date_create_single">
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <div class="row">
                            <input type="date" class="form-control choose_date_single">
                        </div>
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_order_many_date" id="btn_filter_order_many_date">
                            <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_order_fol_date">Lọc</button>
                </div>
            </div>
            <div class="content_filter_order_date_create_many dis-none">
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <form id="formFilterProductDateMany">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <input class="form-control time_start" name="time_start" type="date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Ngày kết thúc</label>
                                        <input class="form-control time_end" name="time_end" type="date">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-light btn_back_filter_single_date">
                                <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                Trở lại</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_dismiss_modal_filter_price" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_order_fol_date_many">Lọc</button>
                </div>
            </div>

        </div>
    </div>
</div>
