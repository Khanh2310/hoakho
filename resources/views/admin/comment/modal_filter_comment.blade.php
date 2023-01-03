<input type="hidden" name="_token" value="{{ csrf_token() }}" />
{{-- modal filter comment fol product --}}
<div class="modal fade" id="Modal_filter_comment_follow_product">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h4">Lọc Theo Bình Luận Theo Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group pd-20">
                            <label>Chọn Sản Phẩm</label>
                            <select name="product_id" id="product_id" class="custom-select2 form-control select2-hidden-accessible"
                                style="width: 100%; height: 38px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="">---Chọn sản phẩm cần lọc-----</option>
                                @foreach ($all_product as $product)
                                    <option value="{{ $product->product_id }}">
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                <button type="button" class="btn btn-success" id="btn_filter_comment_fol_product">Lọc</button>
            </div>
        </div>
    </div>
</div>

{{-- modal filter comment follow rating  --}}
<div class="modal fade" id="Modal_filter_comment_follow_rating">
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
                                <input type="radio" class="rating" name="rating" value="5">
                                5 <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="rating" name="rating" value="4">
                                4
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="rating" name="rating" value="3">
                                3
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="rating" name="rating" value="2">
                                2
                                <i class="icon-copy fa fa-star" style="color:#fddf0a" aria-hidden="true"></i>
                                Trở lên
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="checkbox">
                            <label>
                                <input type="radio" class="rating" name="rating" value="1">
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
                <button type="button" class="btn btn-success" id="btn_filter_comment_fol_rating_many">Lọc</button>
            </div>
        </div>
    </div>
</div>
