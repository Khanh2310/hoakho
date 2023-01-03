@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_shipping_cost') }}">Danh sách
                                    phí vận chuyển</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sửa phí vận chuyển</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Sửa Phí Vận Chuyển</h4>
            </div>
            <div class="pd-20">
                <form action="{{ URL::to('admin/process_update_shipping_cost/' . $shipping_cost->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-sm-6">
                            <label>Vị Trí Bắt Đầu</label>
                            <select name="start_position" class="custom-select2 form-control select2-hidden-accessible" style="width: 100%; height: 38px;" data-select2-id="1" tabindex="-1"
                                aria-hidden="true">
                                @foreach ($citys as $city)
                                    @if ($city->name_tp == $shipping_cost->start_position)
                                        <option value="{{ $city->matp }}" selected>{{ $city->name_tp }}</option>
                                    @else
                                        <option value="{{ $city->matp }}">{{ $city->name_tp }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('start_position'))
                                <div class="alert alert-danger alert-dismissible mt-1">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ $errors->first('start_position') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-sm-6">
                            <label>Vị Trí Kết Thúc</label>
                            <select name="end_position" class="custom-select2 form-control select2-hidden-accessible" style="width: 100%; height: 38px;" data-select2-id="2" tabindex="-1"
                                aria-hidden="true">
                                <option value="">Chọn Điểm Giao Hàng</option>
                                @foreach ($citys as $city)
                                    @if ($city->name_tp == $shipping_cost->end_position)
                                        <option value="{{ $city->matp }}" selected>{{ $city->name_tp }}</option>
                                    @else
                                        <option value="{{ $city->matp }}">{{ $city->name_tp }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if ($errors->has('end_position'))
                                <div class="alert alert-danger alert-dismissible mt-1">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ $errors->first('end_position') }}
                                </div>
                            @endif
                            @if (session('error_position'))
                                <div class="alert alert-danger alert-dismissible mt-1">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('error_position') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-sm-6">
                            <label>Phí Vận Chuyển</label>
                            <div class="form-group">

                                <input class="form-control" type="number" name="cost" value="{{ $shipping_cost->cost }}" placeholder="Nhập Phí Vận Chuyển">
                                @if (session('cost'))
                                    <div class="alert alert-danger alert-dismissible mt-1">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {{ session('cost') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="center mr-t">
                        <button type="submit" class="btn color-btn-them"><i class="icon-copy fi-page-edit"></i>Sửa Phí Vận
                            Chuyển</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
