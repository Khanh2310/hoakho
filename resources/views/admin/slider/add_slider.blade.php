@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm slider</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thêm Slider</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_add_slider') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <input class="form-control" type="file" name="slider_image" id="file_upload" onchange="return uploadhinh()" value="no_image">
                                @if ($errors->has('slider_image'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('slider_image') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            {{-- <div class="form-group">
                                <label>Mô Tả</label>
                                <input class="form-control upper_val" type="text" name="slider_name"
                                    value="{{ old('slider_name') }}" onblur="return upberFirstKey()"
                                    placeholder="Nhập Loại Sản Phẩm">
                                @if ($errors->has('slider_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('slider_name') }}
                                    </div>
                                @endif
                                @if (session('check_slider_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_slider_name') }}
                                    </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="ml-3" id="content_image_upload op-0">
                            <img src="" class="op-0 c" alt="hình ảnh" id="image_upload" style="width: 774px; height: 300px; border-radius: 2px;
                                            border: 1px solid #ecf0f4;">
                        </div>
                    </div>
                    <div class="center mr-t">
                        <button type="submit" class="btn color-btn-them" value="Chỉnh Sửa Quản Trị Viên"><i class="icon-copy fi-page-edit"></i>Thêm Silder</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
