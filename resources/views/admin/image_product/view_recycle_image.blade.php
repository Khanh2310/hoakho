@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Thùng Rác</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_gallery_product/' . $prod_id) }}">Danh sách hình ảnh</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thùng rác</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        @if (session('restore_image_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('restore_image_success') }}
            </div>
        @endif
        @if (session('delete_image_forever'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_image_forever') }}
            </div>
        @endif
        @if (count($recycle_image) > 0)
            <div class="gallery-wrap">
                <ul class="row">
                    @foreach ($recycle_image as $image)
                        <li class="col-lg-4 col-md-6 col-sm-12">
                            <div class="da-card box-shadow" style="width: 320px; height: 269px">
                                <div class="da-card-photo">
                                    <img src="{{ asset('public/upload/' . $image->image) }}" alt="" style="width: 320px; height: 269px">
                                    <div class="da-overlay">
                                        <div class="da-social">
                                            <h5 class="mb-10 color-white pd-20">{{ date('d-m-Y H:i', strtotime($image->deleted_at)) }}</h5>
                                            <ul class="clearfix">
                                                <li><a href="{{ URL::to('admin/restore_image_product/' . $image->image_id) }}" data-toggle="tooltip" data-placement="top" title="Khôi phục hình ảnh"><i class="icon-copy fa fa-superpowers"
                                                            aria-hidden="true"></i></a></li>
                                                <li><a class="forever_delete_image_product_class" data-id="{{ $image->image_id }}" data-toggle="modal" data-target="#modal_delete_forever_image"><i class="dw dw-delete-3"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="center">Thùng rác rổng</div>
        @endif

    </div>
    <!-- The Modal Delete Image -->
    <div class="modal fade" id="modal_delete_forever_image">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn muốn xóa vĩnh viễn hình ảnh này ?
                    <form action="{{ URL::to('admin/delete_forever_image_product') }}" method="post" name="form_delete_forever_product">
                        @csrf
                        <input type="hidden" name="image_id" class="id_delete_forever_image_product">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-danger btn_confirm_delete_forever_product">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>

            </div>
        </div>
    </div>
@endsection
