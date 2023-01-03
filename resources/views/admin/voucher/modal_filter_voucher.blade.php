<input type="hidden" class="product_id" name="product_id" value="{{ $product_id }}">
{{-- modal filter order customer follow date --}}
<div class="modal fade" id="Modal_filter_voucher_follow_date_create">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Ngày Tạo Voucher</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_voucher_date_single">
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <div class="row">
                            <input type="date" class="form-control choose_date_single">
                        </div>
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_voucher_many_date" id="btn_filter_voucher_many_date">
                            <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_dismiss_modal_filter_price" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_voucher_fol_date">Lọc</button>
                </div>
            </div>
            <div class="content_filter_voucher_date_many dis-none">
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
                    <button type="button" class="btn btn-success" id="btn_filter_voucher_fol_date_many">Lọc</button>
                </div>
            </div>

        </div>
    </div>
</div>
