<input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{-- modal filter admin roles --}}
<div class="modal fade" id="Modal_filter_admin_roles">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Chức Vụ</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-outline-danger btn-block btn_filter_role"
                            data-id="1" data-dismiss="modal">
                            <img src="{{ asset('public/upload/product-management.svg') }}"
                                style="height: 150px;"
                                alt="">
                                Nhân viên quản lý
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-success btn-block btn_filter_role"
                            data-id="2" data-dismiss="modal">
                            <img src="{{ asset('public/upload/male.svg') }}"
                                style="height: 150px;"
                                alt="">
                            nhân viên
                        </button>
                    </div>
                </div>
                <div class="row pd-20">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <button class="btn btn-outline-secondary btn-block btn_filter_role"
                            data-id="3" data-dismiss="modal">
                            <img src="{{ asset('public/upload/delivery-man.svg') }}"
                                style="height: 150px;"
                                alt="">
                            nhân viên giao hàng
                        </button>
                    </div>
                    <div class="col-3"></div>

                </div>
            </div>
        </div>
    </div>
</div>
