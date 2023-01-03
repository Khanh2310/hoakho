@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm danh mục sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thêm Danh Mục Sản Phẩm</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_add_category') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tên Danh Mục Sản Phẩm</label>
                                <input class="form-control check_format_name_input" type="text" name="cate_name" value="{{ old('cate_name') }}" placeholder="Nhập Danh Mục Sản Phẩm">
                                @if ($errors->has('cate_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('cate_name') }}
                                    </div>
                                @endif
                                @if (session('check_cate_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_cate_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input class="form-control" type="file" name="cate_image" id="file_upload" onchange="return uploadhinh()" placeholder="" value="no_image">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3" id="content_image_upload op-0">
                            <div class="da-card box-shadow" style="height: 350x; width: 475px">
                                <div class="da-card-photo">
                                    <img src="" class="op-0" alt="hình ảnh" style="height: 350x; width: 475px" id="image_upload">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="center mr-t">
                        <button type="submit" class="btn color-btn-them" value="Chỉnh Sửa Quản Trị Viên"><i class="icon-copy fi-page-edit"></i>Thêm Loại
                            Sản Phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
