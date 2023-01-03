{{-- modal filter product follow cate --}}
<div class="modal fade" id="Modal_filter_product_follow_cate">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Danh Mục Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_product_cate_single">
                <div class="modal-body">
                    <div class="row">
                        @foreach ($all_cate as $cate)
                            <div class="col-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="cate_id" name="cate_id" value="{{ $cate->cate_id }}">
                                        {{ $cate->cate_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_product_many_cate" id="btn_filter_product_many_cate">
                            <b>Chọn nhiều</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success dis-none" id="btn_filter_product_fol_cate">Lọc</button>
                </div>
            </div>
            <div class="content_filter_product_many_cate dis-none">
                <div class="modal-body">

                    <div class="row">
                        @foreach ($all_cate as $cate)
                            <div class="col-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="cate_id_many" name="cate_id[]" value="{{ $cate->cate_id }}">
                                        {{ $cate->cate_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row d-flex justify-content-center">
                        <button class="btn btn-light btn_back_filter_single_cate">
                            <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                            Trở lại</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_product_fol_cate_many">Lọc</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal filter product follow storage --}}
<div class="modal fade" id="Modal_filter_product_follow_storage">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Kho Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_product_storage_single">
                <div class="modal-body">
                    <div class="row">
                        @foreach ($all_storage as $storage)
                            <div class="col-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="storage_id" name="storage_id" value="{{ $storage->storage_id }}">
                                        {{ $storage->storage_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_product_many_storage" id="btn_filter_product_many_storage">
                            <b>Chọn nhiều</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success dis-none" id="btn_filter_product_fol_storage">Lọc</button>
                </div>
            </div>
            <div class="content_filter_product_storage_many dis-none">
                <div class="modal-body">
                    <div class="row">
                        @foreach ($all_storage as $storage)
                            <div class="col-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="storage_id_many" name="storage_id[]" value="{{ $storage->storage_id }}">
                                        {{ $storage->storage_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row d-flex justify-content-center">
                        <button class="btn btn-light btn_back_filter_single_storage">
                            <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                            Trở lại</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_product_fol_storage_many">Lọc</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal filter product follow price --}}
<div class="modal fade" id="Modal_filter_product_follow_price">
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
                                <input type="radio" class="choose_price" name="choose_price" value="1">
                                1.000₫ - 100.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_price" name="choose_price" value="2">
                                100.000₫ - 500.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_price" name="choose_price" value="3">
                                500.000₫ - 1.000.000₫
                            </label>
                        </div>
                    </div>
                    <div class="col-6 pb-10">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="choose_price" name="choose_price" value="4">
                                1.000.000₫ - 2.000.000₫
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="btn_cus_option_price" id='btn_cus_option_price'>
                            <b>Tùy chọn</b>
                        </a>
                        <div class="content-filter-price-cus-option pd-20 dis-none">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control price_start_cus_option" type="number" name="price_start_cus_option" value="" min='1' placeholder="Giá Từ ...₫">
                                </div>
                                <div class="col-6">
                                    <input class="form-control price_end_cus_option" type="number" name="price_end_cus_option" value="" min='1' placeholder="Đến ...₫">
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
                <button type="button" class="btn btn-success dis-none" id="btn_filter_product_fol_price">Lọc</button>
            </div>
        </div>
    </div>
</div>

{{-- modal filter product follow rating --}}
<div class="modal fade" id="Modal_filter_product_follow_rating">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Đánh Giá </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="avg_rating_more" name="avg_rating_more" value="5">
                                5 <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="avg_rating_more" name="avg_rating_more" value="4">
                                4
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="avg_rating_more" name="avg_rating_more" value="3">
                                3
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="avg_rating_more" name="avg_rating_more" value="2">
                                2
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="avg_rating_more" name="avg_rating_more" value="1">
                                1
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-success dis-none" data-dismiss="modal" id="btn_filter_product_fol_rating_many">Lọc</button>
            </div>
        </div>
    </div>
</div>

{{-- modal filter product follow date --}}
<div class="modal fade" id="Modal_filter_product_follow_date_create">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Ngày Thêm Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_filter_product_date_create_single">
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <div class="row">
                            <input type="date" class="form-control choose_date_single">
                        </div>
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_filter_product_many_date" id="btn_filter_product_many_date">
                            <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_dismiss_modal_filter_price" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_product_fol_date">Lọc</button>
                </div>
            </div>
            <div class="content_filter_product_date_create_many dis-none">
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
                    <button type="button" class="btn btn-success" id="btn_filter_product_fol_date_many">Lọc</button>
                </div>
            </div>

        </div>
    </div>
</div>
