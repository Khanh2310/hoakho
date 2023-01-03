<input type="hidden" class="storage_id" name="storage_id" value="{{ $storage_id }}">
{{-- modal filter order customer follow price --}}
<div class="modal fade" id="Modal_filter_storage_product_follow_quantity">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Số Lượng Sản Phẩm Trong Kho</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row content_filter_choose_price">
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity_storage" name="choose_quantity_storage" value="1">
                                Số lượng từ 0 - 50
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity_storage" name="choose_quantity_storage" value="2">
                                Số lượng từ 51 - 100
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity_storage" name="choose_quantity_storage" value="3">
                                Số lượng từ 101 - 150
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_quantity_storage" name="choose_quantity_storage" value="4">
                                Số lượng từ 151 - 200
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
                <button type="button" class="btn btn-success dis-none" id="btn_filter_storage_product_fol_quantity">Lọc</button>
            </div>
        </div>
    </div>
</div>
