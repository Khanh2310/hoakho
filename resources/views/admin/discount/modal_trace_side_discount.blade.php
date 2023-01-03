<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<input type="hidden" class="discount_id" name="discount_id" value="{{ $discount->discount_id }}" />
{{-- modal trace product --}}
<div class="modal fade" id="Modal_trace_discount_side_discount">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Truy Vết Thông Qua Giảm Giá Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="content_trace_discount_side_discount_date_single">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="form-group">
                                <label>Chọn nhân viên</label>
                                <select name="admin_id" id="admin_id_single" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 30px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
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
                                    <input type="radio" name="type_action_discount_single"
                                        autocomplete="off" checked value="0"> Tất cả
                                </label>
                                <label class="btn btn-outline-info">
                                    <input type="radio" name="type_action_discount_single"
                                        autocomplete="off" value="1"> Thêm giảm giá
                                </label>
                                <label class="btn btn-outline-info">
                                    <input type="radio" name="type_action_discount_single"
                                    autocomplete="off" value="2"> Thiết lập lại giảm giá
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
                                <input type="date" class="form-control choose_date_discount_single">
                            </div>
                            <div class="col-1"></div>

                        </div>
                    </div>
                    <div class="row pd-10">
                        <a href="#" class="btn_trace_discount_many_date" id="btn_trace_discount_many_date">
                            <b>Tùy chọn</b> <i class="icon-copy fa fa-angle-double-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_trace_discount_fol_date">Truy Vết</button>
                </div>
            </div>
            <div class="content_trace_discount_side_discount_date_many dis-none">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="form-group">
                                <label>Chọn nhân viên</label>
                                <select name="admin_id_many" id="admin_id_many" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 30px;" data-select2-id="2" tabindex="-1" aria-hidden="true">
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
                                    <input type="radio" name="type_action_discount_many"
                                        autocomplete="off" checked value="0"> Tất cả
                                </label>
                                <label class="btn btn-outline-info">
                                    <input type="radio" name="type_action_discount_many"
                                        autocomplete="off" value="1"> Thêm giảm giá
                                </label>
                                <label class="btn btn-outline-info">
                                    <input type="radio" name="type_action_discount_many"
                                    autocomplete="off" value="2"> Thiết lập lại giảm giá
                                </label>
                            </div>
                        </div>
                        <div class="col-1"></div>
                    </div>
                    <div class="content-filter-price-cus-option pd-20">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Ngày bắt đầu</label>
                                    <input class="form-control start_date_discount_many" name="start_date_discount_many" type="date">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Ngày kết thúc</label>
                                    <input class="form-control end_date_discount_many" name="end_date_discount_many" type="date">
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <button class="btn btn-light btn_trace_discount_single_date" id="btn_trace_discount_single_date">
                                <i class="icon-copy fa fa-angle-double-left" aria-hidden="true"></i>
                                Trở lại</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_trace_discount_fol_date_many">
                        Truy Vết
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
