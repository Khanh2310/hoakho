<input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{-- modal filter discount fol over time discount --}}
<div class="modal fade" id="Modal_filter_discount_over_time">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Thời Hạn Giảm Giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                        <div class="col-6">
                            <button class="btn btn-warning btn-block btn_time_discount"
                                data-time="0" data-dismiss="modal">
                                <img src="{{ asset('public/upload/out-of-time.svg') }}" style="height: 30px;"
                                    alt="">
                                    Hết thời hạn
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-success btn-block btn_time_discount"
                                data-time="1" data-dismiss="modal">
                                <img src="{{ asset('public/upload/copyright.svg') }}" style="height: 30px;"
                                 alt="">
                                 Còn thời hạn
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
