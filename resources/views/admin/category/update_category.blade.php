@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_category') }}">Danh mục sản phẩm</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Sửa danh mục sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>

        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Sửa Danh Mục Sản Phẩm</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_update_category/' . $update_category->cate_id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Loại Sản Phẩm</label>
                                <input class="form-control upper_val" type="text" name="cate_name" value="{{ $update_category->cate_name }}" onblur="return upberFirstKey()"
                                    placeholder="Nhập Loại Sản Phẩm">
                                @if ($errors->has('cate_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('cate_name') }}
                                    </div>
                                @endif
                                @if (session('check_cate_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_cate_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input class="form-control" type="file" name="cate_image" id="file_upload" onchange="return uploadhinh()" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3" id="">
                            <div class="da-card box-shadow" style="height: 350x; width: 475px">
                                <div class="da-card-photo">
                                    <img src="{{ asset('public/upload/' . $update_category->cate_image) }}" class="" alt="hình ảnh" id="image_upload">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="center mr-t mt-5">
                        <button type="submit" class="btn color-btn-them"><i class="icon-copy fi-page-edit"></i>Chỉnh Sửa
                            Loại Sản Phẩm</button>
                        <a href="" class="btn btn-danger">
                            <i class="icon-copy fi-x"></i> Hủy Thay Đổi
                        </a>
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
