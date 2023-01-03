@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                                <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Lịch sử giá sản phẩm</li>
                            </ol>
                        </nav>
                    </div>
                </div>
        </div>
        {{-- Message  --}}
        @if (session('update_price_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('update_price_success') }}
            </div>
        @endif
        @if (session('update_price_error'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('update_price_error') }}
            </div>
        @endif
        @if ($errors->has('price'))
            <div class="alert alert-danger alert-dismissible mt-1">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $errors->first('price') }}
            </div>
        @endif
        <div class="content_filter_price_product_history">
            <!-- Simple Datatable start -->
            <div class="pd-20 card-box mb-30">
                <div class="pd-20">
                    <h4 class="text-blue h4">Lịch Sử Thay Đổi Giá Sản Phẩm - "{{ $product->product_name }}"</h4>
                </div>
                <div class="row">
                    <div class="content_filter pd-10 ml-10">
                        <div class="dropdown">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                <i class="icon-copy dw dw-filter"></i> Lọc
                            </a>
                            <div class="dropdown-menu dropdown-menu-left" style="">
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                data-target="#Modal_filter_price_product_history">Thời gian cập nhật giá sản phẩm </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($history_price) > 0)
                    {{-- product id --}}
                    <input type="hidden" class="product_id" value="{{ $product->product_id }}">
                    {{--  --}}
                    <div class="pb-20">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                            <div class="row">
                                <div class="col-12 table-responsive">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Tên Sản Phẩm</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col">Ngày Cập Nhật</th>
                                            <th scope="col" class="center">Trạng Thái</th>
                                            @hasrole(['admin','manager'])
                                            <th scope="col" class="center">#</th>
                                            @endhasrole
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $stt=1;
                                            @endphp
                                            @foreach ($history_price as $price)
                                            <tr>
                                                <td>{{ $stt++ }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ number_format($price->price, 0, ',', '.') }}₫</td>
                                                <td>{{ date("d-m-Y H:i", strtotime($price->updated_at)) }}</td>
                                                <td class="center">
                                                    @if ($price->status == 1)
                                                        <span class="badge badge-success">Mới</span>
                                                    @else
                                                        <span class="badge badge-secondary">Cũ</span>
                                                    @endif
                                                </td>
                                                @hasrole(['admin','manager'])
                                                <td class="center">
                                                    @if ($price->status == 1)
                                                        <button class="btn color-btn-them update_price_product" data-id = {{ $price->price_id }} data-toggle="modal"
                                                        data-target="#Modal_update_price_product">Cập Nhật</button>
                                                    @endif
                                                </td>
                                                @endhasrole
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="center">Chưa có thay đổi nào</div>
                @endif
            </div>
        </div>

        <!-- The Modal -->
        <div class="modal fade" id="Modal_update_price_product">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Cập Nhật Giá Sản Phẩm</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ URL::to('admin/update_price_product') }}" method="post" name="update_price_product">
                            @csrf
                            <input type="hidden" class="form-control val_price_product" name="price_id" value="">
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            @foreach ($history_price as $price)
                                @if ($price->status == 1)
                                    <input type="number" class="form-control" name="price" value="{{ $price->price }}">
                                @endif
                            @endforeach
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn color-btn-them btn_update_price_product">Cập Nhật</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>

    {{-- modal filter product follow date  --}}
    <div class="modal fade" id="Modal_filter_price_product_history">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h4">Thời gian cập nhật sản phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="content-filter-price-cus-option pd-20">
                        <form method="post">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Ngày bắt đầu</label>
                                        <input class="form-control time_start" name="time_start" type="date">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Ngày kết thúc</label>
                                        <input class="form-control time_end" name="time_end" type="date">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    <button type="button" class="btn btn-success" id="btn_filter_price_product_history">Lọc</button>
                </div>
            </div>
        </div>
    </div>
@endsection
