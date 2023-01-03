@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm quản trị viên</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Thêm Quản Trị Viên</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_add_admin') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Họ Và Tên</label>
                                <input class="form-control upper_val check_format_name_input" type="text" name="admin_name"
                                    value="{{ old('admin_name') }}"
                                    onblur="return upberFirstKey()"
                                    placeholder="Nhập Họ Và Tên">
                                @if ($errors->has('admin_name'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('admin_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Ngày Sinh</label>
                                <input class="form-control" type="date" name="admin_birthday"
                                    value="{{ old('admin_birthday') }}"
                                    placeholder="Nhập Ngày Sinh">
                                @if ($errors->has('admin_birthday'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('admin_birthday') }}
                                    </div>
                                @endif
                                @if (session('check_age'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_age') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Giới Tính</label>
                                <div class="dropdown bootstrap-select form-control dropup">
                                    <select name="admin_gender" class="selectpicker form-control" data-size="5">
                                        <option value="Nam">Nam</option>
                                        <option value="Nu">Nữ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Số Điện Thoại</label>
                                <input class="form-control" type="number" name="admin_phone" value="{{ old('admin_phone') }}"
                                    placeholder="Nhập Số Điện Thoại">
                                @if ($errors->has('admin_phone'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('admin_phone') }}
                                    </div>
                                @endif
                                @if (session('check_phone'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_phone') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Thư Điện Tử(Email)</label>
                                <input class="form-control" type="email" name="admin_email"
                                    value="{{ old('admin_email') }}" placeholder="Nhập Địa Chỉ Mail(........@.....)">
                                @if ($errors->has('admin_email'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('admin_email') }}
                                    </div>
                                @endif
                                @if (session('check_email'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('check_email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group" data-select2-id="7">
                                <label>Tỉnh/Thành Phố</label>
                                <select name="city" id="city_add_admin" value="{{ old('city') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option value="">---Chọn Tỉnh/TP-----</option>
                                    @foreach ($citys as $city)
                                        <option value="{{ $city->matp }}">{{ $city->name_tp }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('city') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Quận/Huyện</label>
                                <select name="district" id="district_add_admin" value="{{ old('district') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                    <option value="">---Quận/Huyện-----</option>
                                </select>
                                @if ($errors->has('district'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('district') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Xã/Phường/Thị Trấn</label>
                                <select name="ward" id="ward_add_admin" value="{{ old('ward') }}" class="custom-select2 form-control select2-hidden-accessible"
                                    style="width: 100%; height: 38px;" data-select2-id="3" tabindex="-1" aria-hidden="true">
                                    <option value="">---Xã/Phường/Thị Trấn-----</option>
                                </select>
                                @if ($errors->has('ward'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ $errors->first('ward') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Hình Ảnh</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="avt" onchange="return uploadhinh()" id="file_upload">
                                    <label class="custom-file-label">Chọn Ảnh Đại Diện</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-3" id="content_image_upload op-0">
                            <img src="" class="op-0" alt="hình ảnh" id="image_upload" height="100px" width="100px">
                        </div>
                    </div>
                    <div class="center mr-t">
                        <input type="submit" class="btn color-btn-them" value="Thêm Quản Trị Viên">
                    </div>
                </form>
            </div>
        </div>
    @endsection
