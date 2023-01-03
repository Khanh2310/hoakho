<input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{-- modal trace product --}}
<div class="modal fade" id="Modal_trace_product_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_product_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id" id="product_id_single_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_product_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_date_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_product_many_date" id="btn_trace_product_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_product_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_product_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id" id="product_id_many_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_product_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_product_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date" name="start_date" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date" name="end_date" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_product_single_date" id="btn_trace_product_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_product_fol_date_many">
                            Truy Vết
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- trace cate profile --}}
<div class="modal fade" id="Modal_trace_cate_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Danh Mục Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_cate_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn danh mục sản phẩm</label>
                                    <select name="cate_id" id="cate_id_single_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả danh mục</option>
                                        @foreach ($all_cate as $cate)
                                            <option value="{{ $cate->cate_id }}">{{ $cate->cate_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_cate_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_cate_date_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_cate_many_date" id="btn_trace_cate_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_cate_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_cate_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn danh mục sản phẩm</label>
                                    <select name="cate_id" id="cate_id_many_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả danh mục</option>
                                        @foreach ($all_cate as $cate)
                                            <option value="{{ $cate->cate_id }}">{{ $cate->cate_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_cate_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_cate_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_cate" name="start_date_cate" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_cate" name="end_date_cate" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_cate_single_date" id="btn_trace_cate_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_cate_fol_date_many">Truy Vết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal trace price product --}}
<div class="modal fade" id="Modal_trace_product_price_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Giá Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_price_product_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id_price" id="price_product_id_single_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="5" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_price_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_price_product_date_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_price_product_many_date" id="btn_trace_price_product_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_price_product_fol_date">
                            Truy Vết
                        </button>
                    </div>
                </div>
                <div class="content_trace_price_product_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id_price_many" id="price_product_id_many_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="6" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_price_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_price_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_price_product" name="start_date_price_product" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_price_product" name="end_date_price_product" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_price_product_single_date" id="btn_trace_price_product_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_price_product_fol_date_many">
                            Truy Vết
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal trace admin --}}
<div class="modal fade" id="Modal_trace_admin_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Nhân Viên</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_admin_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn nhân viên</label>
                                    <select name="admin_id" id="admin_id_single_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="7" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả nhân viên</option>
                                        @foreach ($all_admin as $admin)
                                            <option value="{{ $admin->admin_id }}">{{ $admin->admin_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_admin_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_date_admin_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_admin_many_date" id="btn_trace_admin_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_admin_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_admin_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn nhân viên</label>
                                    <select name="admin_id_many" id="admin_id_many_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="8" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả nhân viên</option>
                                        @foreach ($all_admin as $admin)
                                            <option value="{{ $admin->admin_id }}">{{ $admin->admin_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_admin_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_admin_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_admin" name="start_date_admin" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_admin" name="end_date_admin" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_admin_single_date" id="btn_trace_admin_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_admin_fol_date_many">Truy Vết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal trace image --}}
<div class="modal fade" id="Modal_trace_product_image_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Hình Ảnh Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_product_image_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id_image" id="image_product_id_single_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="9" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_date_product_image_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_product_image_many_date" id="btn_trace_product_image_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_product_image_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_product_image_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="product_id_many_image" id="image_product_id_many_date" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="10" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_product_image" name="start_date_product_image" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_product_image" name="end_date_product_image" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_product_image_single_date" id="btn_trace_product_image_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_product_price_fol_date_many">Truy Vết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal trace storage --}}
<div class="modal fade" id="Modal_trace_storage_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Kho</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_storage_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn kho sản phẩm</label>
                                    <select name="storage_id" id="storage_id_single" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="11" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả kho</option>
                                        @foreach ($all_storage as $storage)
                                            <option value="{{ $storage->storage_id }}">{{ $storage->storage_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_storage_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_date_storage_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_storage_many_date" id="btn_trace_storage_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_storage_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_storage_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn nhân viên</label>
                                    <select name="storage_id_many" id="storage_id_many" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="12" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả kho</option>
                                        @foreach ($all_storage as $storage)
                                            <option value="{{ $storage->storage_id }}">{{ $storage->storage_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_storage_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_storage_many" name="start_date_storage_many" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_storage_many" name="end_date_storage_many" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_storage_single_date" id="btn_trace_storage_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_storage_fol_date_many">Truy Vết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal trace storage product --}}
<div class="modal fade" id="Modal_trace_storage_product_side_profile">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Kho Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="content_trace_storage_product_side_profile_date_single">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="storage_product_id" id="storage_product_id_single" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="13" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_storage_product_single"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_single"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_single"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_single"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_single"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option">
                            <div class="row pt-10">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <label>Chọn ngày</label>
                                    <input type="date" class="form-control choose_date_storage_product_single">
                                </div>
                                <div class="col-1"></div>

                            </div>
                        </div>
                        <div class="row pd-10">
                            <a href="#" class="btn_trace_storage_product_many_date" id="btn_trace_storage_product_many_date">
                                <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_storage_product_fol_date">Truy Vết</button>
                    </div>
                </div>
                <div class="content_trace_storage_product_side_profile_date_many dis-none">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <div class="form-group">
                                    <label>Chọn sản phẩm</label>
                                    <select name="storage_product_id_many" id="storage_product_id_many" class="custom-select2 form-control select2-hidden-accessible"
                                        style="width: 100%; height: 30px;" data-select2-id="14" tabindex="-1" aria-hidden="true">
                                        <option value="0">Tất cả sản phẩm</option>
                                        @foreach ($all_product as $product)
                                            <option value="{{ $product->product_id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <label>Chọn thao tác</label>
                                <div class="btn-group btn-group-toggle ml-10" data-toggle="buttons">
                                    <label class="btn btn-outline-info active">
                                        <input type="radio" name="type_action_storage_product_many"
                                            autocomplete="off" checked value="0"> Tất cả
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_many"
                                            autocomplete="off" value="1"> Thêm
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_many"
                                        autocomplete="off" value="2"> Sửa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_many"
                                        autocomplete="off" value="3"> Xóa
                                    </label>
                                    <label class="btn btn-outline-info">
                                        <input type="radio" name="type_action_storage_product_many"
                                        autocomplete="off" value="4"> Khôi phục xóa
                                    </label>
                                </div>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="content-filter-price-cus-option pd-20">
                            <form>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày bắt đầu</label>
                                            <input class="form-control start_date_storage_product_many" name="start_date_storage_product_many" type="date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ngày kết thúc</label>
                                            <input class="form-control end_date_storage_product_many" name="end_date_storage_product_many" type="date">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row d-flex justify-content-center">
                                <button class="btn btn-light btn_trace_storage_product_single_date" id="btn_trace_storage_product_single_date">
                                    <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                    Trở lại</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                        <button type="button" class="btn btn-success" id="btn_trace_storage_product_fol_date_many">Truy Vết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
