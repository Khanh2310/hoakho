{{-- modal filter order customer follow price --}}
<div class="modal fade" id="Modal_filter_customer_follow_order_quantity">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Số Lượng Đơn Hàng Đã Mua</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row content_filter_choose_price">
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity" name="choose_quantity" value="1">
                                Từ 0 - 20 đơn hàng
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity" name="choose_quantity" value="2">
                                Từ 21 - 50 đơn hàng
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity" name="choose_quantity" value="3">
                                Từ 51 - 100 đơn hàng
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity" name="choose_quantity" value="4">
                                Từ 101 - 200 đơn hàng
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn_cus_option_quantity" id='btn_cus_option_quantity'>
                            <b>Tùy chọn</b><i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                        <div class="content-filter-price-cus-option pd-20 dis-none">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control quantity_start_cus_option" type="number" name="quantity_start_cus_option" value="" min='1' placeholder="Từ...">
                                </div>
                                <div class="col-6">
                                    <input class="form-control quantity_end_cus_option" type="number" name="quantity_end_cus_option" value="" min='1' placeholder="Đến...">
                                </div>
                            </div>
                            <div class="pd-10 d-flex justify-content-center">
                                <div class="btn btn-light btn_back_choose_price_filter">
                                    <i class="icon-copy fa fa-chevron-left" aria-hidden="true"></i>
                                    Trở lại
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn_dismiss_modal_filter_price" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-success dis-none" id="btn_filter_order_customer_fol_quantity">Lọc</button>
            </div>
        </div>
    </div>
</div>

{{-- modal filter order customer follow price --}}
<div class="modal fade" id="Modal_filter_order_customer_follow_price">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row content_filter_choose_price">
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="total_price" name="total_price" value="1">
                                1.000₫ - 100.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="total_price" name="total_price" value="2">
                                100.000₫ - 500.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="total_price" name="total_price" value="3">
                                500.000₫ - 1.000.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="total_price" name="total_price" value="4">
                                1.000.000₫ - 2.000.000₫
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn_cus_option_price" id='btn_cus_option_price'>
                            <b>Tùy chọn</b><i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                        <div class="content-filter-price-cus-option pd-20 dis-none">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control total_start_price" type="number" name="price_start_cus_option" value="" min='1' placeholder="Giá Từ ...₫">
                                </div>
                                <div class="col-6">
                                    <input class="form-control total_end_price" type="number" name="price_end_cus_option" value="" min='1' placeholder="Đến ...₫">
                                </div>
                            </div>
                            <div class="pd-10 d-flex justify-content-center">
                                <div class="btn btn-light btn_back_choose_price_filter">
                                    <i class="icon-copy fa fa-chevron-left" aria-hidden="true"></i>
                                    Trở lại
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn_dismiss_modal_filter_price" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-success dis-none" id="btn_filter_order_customer_fol_price">Lọc</button>
            </div>
        </div>
    </div>
</div>


{{-- modal filter order customer follow date --}}
<div class="modal fade" id="Modal_filter_order_customer_follow_date">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Ngày Mua Hàng</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_order_customer_date_single">
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <div class="row">
                            <input type="date" class="form-control choose_date_single">
                        </div>
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_order_customer_many_date" id="btn_filter_order_customer_many_date">
                            <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_order_customer_fol_date">Lọc</button>
                </div>
            </div>
            <div class="content_filter_order_customer_date_many dis-none">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_order_customer_fol_date_many">Lọc</button>
                </div>
            </div>
        </div>
    </div>
</div>
