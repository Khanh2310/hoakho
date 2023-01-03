<!-- The Modal -->
<div class="modal fade" id="modal_confirm_delivered">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông Báo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="modal_body_delivary">Xác nhận giao đơn hàng thành công?</div>
                <form action="{{ URL::to('shipper/confirm_delivery_order_success') }}" method="post" name="form_submit_confirm">
                    @csrf
                    <input type="hidden" value="" name="order_code" class="val_order_code">
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn_confirm_modal">Xác Nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal_confirm_fail">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Thông Báo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="modal_body_delivary">Xác nhận giao đơn hàng không thành công?</div>
                <form action="{{ URL::to('shipper/confirm_delivery_order_fail') }}" method="post" name="form_submit_confirm_fail">
                    @csrf
                    <input type="hidden" value="" name="order_code" class="val_order_code">
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn_confirm_modal_fail">Xác Nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>

        </div>
    </div>
</div>
