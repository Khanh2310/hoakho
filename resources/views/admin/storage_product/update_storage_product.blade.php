@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage') }}">Danh sách kho hàng</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage_product/' . $storage_id) }}">Danh sách kho sản phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sửa kho sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 col-sm-12 text-right">
                </div>
            </div>
        </div>

        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Sửa Kho Sản Phẩm</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_update_storage_product/' . $storage_product->storage_product_id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Sản Phẩm</label>
                                <input class="form-control upper_val" type="text" @foreach ($all_product as $product)
                                @if ($storage_product->product_id == $product->product_id)
                                    value="{{ $product->product_name }}"
                                @endif
                                @endforeach
                                readonly>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Số lượng</label>
                                <input class="form-control" type="number" name="total_quantity_product" value="{{ $storage_product->total_quantity_product }}">
                            </div>
                            @if (session('error_check_storage_product_quantity'))
                                <div class="alert alert-danger alert-dismissible mt-1" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('error_check_storage_product_quantity') }}
                                </div>
                            @endif
                            @if (session('error_check_storage_product_null'))
                                <div class="alert alert-danger alert-dismissible mt-1" role="alert">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('error_check_storage_product_null') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3" id="">
                            @foreach ($all_product as $product)
                                @if ($storage_product->product_id == $product->product_id)
                                    <div class="da-card box-shadow" style="height: 350x; width: 475px">
                                        <div class="da-card-photo">
                                            <img src="{{ asset('public/upload/' . $product->product_image) }}" class="" alt="hình ảnh" id="image_upload">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="center mr-t mt-5">
                        <button type="submit" class="btn color-btn-them" value="Chỉnh Sửa Số Lượng Sản Phẩm"><i class="icon-copy fi-page-edit"></i> Chỉnh Sửa Số Lượng Sản Phẩm</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                            <i class="icon-copy fi-x"></i> Hủy Thay Đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title center">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn Muốn Hủy Thay Đổi
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger confirm" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
