@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách sản phẩm</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
        </div>
        {{-- Message --}}
        @if (session('change_status'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('change_status') }}
            </div>
        @endif
        @if (session('update_product_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('update_product_success') }}
            </div>
        @endif
        @if (session('add_product_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_product_success') }}
            </div>
        @endif
        @if (session('delete_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_success') }}
            </div>
        @endif
        @if (session('delete_error'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_error') }}
            </div>
        @endif
        {{--  --}}
        {{-- Statistical --}}
        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <a href="#">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ count($all_product) }}</div>
                                <div class="font-14 text-secondary weight-500">Sản Phẩm</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#76f6e2">
                                    <i class="icon-copy dw dw-inbox-1"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <a href="#">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ count($all_product_new) }}</div>
                                <div class="font-14 text-secondary weight-500">Sản Phẩm Mới</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#8de5f5">
                                    <i class="icon-copy dw dw-inbox"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <a href="#">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ count($all_product_featured) }}</div>
                                <div class="font-14 text-secondary weight-500">Sản Phẩm Đặc Trưng</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#8dbaf5">
                                    <i class="icon-copy dw dw-inbox-4"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <a href="#">
                        <div class="d-flex flex-wrap">
                            <div class="widget-data">
                                <div class="weight-700 font-24 text-dark">{{ count($all_product_discount) }}</div>
                                <div class="font-14 text-secondary weight-500">Khuyến Mãi</div>
                            </div>
                            <div class="widget-icon">
                                <div class="icon" data-color="#afaefb">
                                    <i class="icon-copy dw dw-analytics-111"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        {{--  --}}
        <!-- Simple Datatable start -->
        <div class="card-box mb-30 content_filter_product">
            <div class="pd-20">
                <h4 class="text-blue h4">Danh Sách Sản Phẩm</h4>
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 d-flex">
                            <div class="content_filter pl-20">
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="icon-copy dw dw-filter"></i> Lọc
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left" style="">
                                        <a class="dropdown-item" href="#" class="filter_new_product"
                                            id="filter_new_product">Sản phẩm mới</a>
                                        <a class="dropdown-item" href="#" class="filter_product_feature"
                                            id="filter_product_feature">Sản phẩm đặc trưng</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#Modal_filter_product_follow_cate">Danh mục</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#Modal_filter_product_follow_storage">Kho</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#Modal_filter_product_follow_price">Giá</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#Modal_filter_product_follow_rating">Đánh giá</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                            data-target="#Modal_filter_product_follow_date_create">Ngày thêm sản phẩm </a>
                                    </div>
                                </div>
                            </div>
                            <div class="content_print_pdf_product ml-10">
                                <form action="{{ URL::to('admin/print_pdf_product') }}" method="post">
                                    @csrf
                                    {{-- type filter --}}
                                        <input type="hidden" class="type_filter" name="type_filter" value="">
                                        <input type="hidden" class="level_filter" name="level_filter" value="">
                                        <input type="hidden" name="level_array" value="">
                                        <input type="hidden" name="price_filter_start" value="">
                                        <input type="hidden" name="price_filter_end" value="">
                                    {{--  --}}
                                    <button type="submit" class="btn btn-secondary">
                                        Xuất
                                        <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <form action="">
                                    @csrf
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm"
                                            id="find_product" placeholder="Tìm Kiếm"
                                            aria-controls="DataTables_Table_0"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_product">
                        @if (count($all_product) > 0)
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table
                                        class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">STT</th>
                                                <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1"
                                                    aria-label="Name" data-defaultsort="disabled">Hình Ảnh</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">Giá</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">Trong Kho</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">Đã Bán</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1">Đánh Giá</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" data-defaultsort="disabled">Mới</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1" data-defaultsort="disabled">Đặc Trưng</th>
                                                @hasrole(['admin','manager','employee'])
                                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                                                    aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                                @endhasrole
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="">
                                        @php
                                            $stt = 1;
                                        @endphp
                                        @foreach ($all_product as $prod)
                                        @php
                                            $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($prod->product_id);
                                            $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($prod->product_id);
                                        @endphp
                                        <tr role="
                                            row" class="odd">
                                            <td>{{ $stt++ }}</td>
                                            <td class="table-plus" tabindex="0">
                                                <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                                    <div class="da-card-photo">
                                                        <img src="{{ asset('public/upload/' . $prod->product_image) }}"
                                                            alt="hình ảnh" srcset="" style="height: 80px; width: 80px">
                                                        <div class="da-overlay">
                                                            <div class="da-social">
                                                                <ul class="clearfix">
                                                                    <li><a
                                                                            href="{{ URL::to('admin/all_gallery_product/' . $prod->product_id) }}"><i
                                                                                class="icon-copy dw dw-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ URL::to('admin/view_detail_product/' . $prod->product_id) }}">{{ $prod->product_name }}</a>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ URL::to('admin/history_price_product/' . $prod->product_id) }}">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</a>
                                            </td>
                                            <td class="text-center">
                                                {{ $prod->total_quantity_product }}
                                            </td>
                                            <td class="text-center">
                                                {{ $info_rating_saled->count_product_saled }}
                                            </td>
                                            <td class="text-center">
                                                {{ $info_rating_saled->avg_rating }} <i class="icon-copy fa fa-star"
                                                    aria-hidden="true" style="color: #fddf0a; font-size: 18px"></i>
                                            </td>
                                            <td class="center">
                                                @if ($prod->is_new == 1)
                                                    <i class="icon-copy fa fa-check" aria-hidden="true"
                                                        style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                                                @else
                                                    <i class="icon-copy fa fa-close" aria-hidden="true"
                                                        style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                                                @endif
                                            </td>
                                            @hasrole(['admin','manager'])
                                            <td class="center">
                                                @if ($prod->is_featured == 1)
                                                    <a href="{{ URL::to('admin/is_not_featured/' . $prod->product_id) }}"><i
                                                            class="icon-copy fa fa-check" aria-hidden="true"
                                                            style="font-size: 25px; color: rgb(5, 199, 30)"></i></a>
                                                @else
                                                    <a href="{{ URL::to('admin/is_featured/' . $prod->product_id) }}"><i
                                                            class="icon-copy fa fa-close" aria-hidden="true"
                                                            style="font-size: 25px; color: rgb(207, 51, 11)"></i></a>
                                                @endif
                                            </td>
                                            @endhasrole
                                            @hasrole(['employee'])
                                            <td class="center">
                                                @if ($prod->is_featured == 1)
                                                <i class="icon-copy fa fa-check" aria-hidden="true"
                                                            style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                                                @else
                                                    <i class="icon-copy fa fa-close" aria-hidden="true"
                                                            style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                                                @endif
                                            </td>
                                            @endhasrole
                                            <td class="">
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    @hasrole(['admin','manager','employee'])
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item"
                                                            href="{{ URL::to('admin/view_detail_product/' . $prod->product_id) }}"><i
                                                                class="dw dw-eye"></i>Thông tin sản phẩm</a>
                                                        @hasrole(['admin','manager'])
                                                        <a class="dropdown-item"
                                                            href="{{ URL::to('admin/update_product/' . $prod->product_id) }}"><i
                                                                class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                                        @endhasrole
                                                        @hasrole(['admin'])
                                                        <button class="dropdown-item soft_delete_product_class"
                                                            data-id="{{ $prod->product_id }}" data-toggle="modal"
                                                            data-target="#Modal_delete_product"><i
                                                                class="dw dw-delete-3"></i>Xóa</button>
                                                        @endhasrole
                                                    </div>
                                                    @endhasrole
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="center">Chưa có sản phẩm nào</div>
                @endif

                <div class="row">
                    <div class="col-sm-12 col-md-5">
                        @hasrole(['admin'])
                            <a href="{{ URL::to('admin/view_recycle_product') }}" class="btn color-btn-them ml-10"
                                style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
                        @endhasrole
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <ul class="pagination">
                                {!! $all_product->links() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- The Modal -->
    <div class="modal fade" id="Modal_delete_product">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Bạn có muốn xóa sản phẩm này ?
                    <form action="{{ URL::to('admin/soft_delete_product') }}" method="post"
                        name="form_soft_delete_product">
                        @csrf
                        <input type="hidden" class="id_delete_product" name="product_id" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn_delete_soft_product">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>

    {{-- include modal filter --}}
    @include('admin.product.modal_filter_product')
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('public/back_end/filter_product/filter_product.js') }}"></script>
@endsection
