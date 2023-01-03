@extends('admin.layout_admin')
@section('container')
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_discount') }}">Danh sách giảm giá</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Thiết lập lại giảm giá</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
            </div>
        </div>
    </div>
    {{-- Message  --}}
    @if (session('update_discount_success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('update_discount_success') }}
        </div>
    @endif
    <div class="pd-20 card-box mb-30">
        <div class="pd-10">
            <h4 class="text-blue h4">Thiết Lập Lại Giảm Giá Sản Phẩm</h4>
        </div>
        <div class="ml-10 pd-10">
            <form action="{{ URL::to('admin/process_update_discount/'.$discount->discount_id) }}" method="post" name="form_update_discount">
                @csrf
                <div class="">
                    <h4 class="h4">#Giảm Giá 1</h4>
                </div>
                <div class="row ml-10">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Thời Gian Bắt Đầu</label>
                            <input class="form-control time_start_1" type="datetime-local" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($discount->start_date_1)) }}" name="time_start_1">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Thời Gian Kết Thúc</label>
                            <input class="form-control time_end_1" type="datetime-local" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($discount->end_date_1)) }}" name="time_end_1">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Hình Thức Giảm</label>
                            <div class="dropdown bootstrap-select form-control dropup">
                                <select name="condition_discount_1" class="selectpicker form-control condition_discount_1">

                                    @if ($discount->condition_discount_1 == 1)
                                        <option value="1" selected>Giảm Theo %</option>
                                        <option value="2">Giảm Theo Tiền</option>
                                    @else
                                        <option value="1">Giảm Theo %</option>
                                        <option value="2" selected>Giảm Theo Tiền</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Giảm</label>
                            <input class="form-control amount_discount_1" type="number" value="{{ $discount->amount_discount_1 }}" name="amount_discount_1"  placeholder="Nhập số lượng giảm">
                        </div>
                    </div>
                </div>
                <div class="">
                    <a href="#discount2" data-toggle="collapse" class="h4">#Giảm Giá 2</a>
                </div>
                @if ($discount->start_date_2 != "" && $discount->end_date_2 != "" && $discount->condition_discount_2 != "" && $discount->amount_discount_2 != "")
                    <div class="row ml-10 collapse" id="discount2">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Thời Gian Bắt Đầu</label>
                                <input class="form-control time_start_2" type="datetime-local" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($discount->start_date_2)) }}" name="time_start_2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Thời Gian Kết Thúc</label>
                                <input class="form-control time_end_2" type="datetime-local" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($discount->end_date_2)) }}" name="time_end_2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hình Thức Giảm</label>
                                <div class="dropdown bootstrap-select form-control dropup">
                                    <select name="condition_discount_2" class="selectpicker form-control condition_discount_2" data-size="5">
                                        @if ($discount->condition_discount_2 == 1)
                                            <option value="1" selected>Giảm Theo %</option>
                                            <option value="2">Giảm Theo Tiền</option>
                                        @else
                                            <option value="1">Giảm Theo %</option>
                                            <option value="2" selected>Giảm Theo Tiền</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                                <label>Giảm</label>
                                <input class="form-control amount_discount_2" type="number" value="{{ $discount->amount_discount_2 }}" name="amount_discount_2"  placeholder="Nhập số lượng giảm">
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row ml-10 collapse" id="discount2">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Thời Gian Bắt Đầu</label>
                                <input class="form-control time_start_2" type="datetime-local" name="time_start_2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Thời Gian Kết Thúc</label>
                                <input class="form-control time_end_2" type="datetime-local" name="time_end_2">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Hình Thức Giảm</label>
                                <div class="dropdown bootstrap-select form-control dropup">
                                    <select name="condition_discount_2" class="selectpicker form-control condition_discount_2" data-size="5">
                                        <option value="">---Chọn hình thức giảm------</option>
                                        <option value="1">Giảm Theo %</option>
                                        <option value="2">Giảm Theo Tiền</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                                <label>Giảm</label>
                                <input class="form-control amount_discount_2" type="number" name="amount_discount_2"  placeholder="Nhập số lượng giảm">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="pd-10 ml-10 title_tag_input dis_none">
                    <h4 class="h4 ml-10">Danh Sách Sản Phẩm Áp Dụng</h4>
                </div>
                <div class="row ml-10 content_val_tag_input op-0">
                    <div class="col-sm-11 ml-10 pd-10">
                        <input type="text" class="form-control list_product_discount"
                            data-role="tagsinput"
                            placeholder="Các sản phẩm áp dụng"
                            name="list_product_discount"
                            value=
                            "
                                {{-- @foreach ($products as $prod)
                                    {{ $prod->product_name.',' }}
                                @endforeach --}}
                            "
                            >
                        <input type="hidden" class="val_hidden_discount_id" value="{{ $discount->discount_id }}">
                    </div>
                </div>
                <div class="center annouce_tag dis_none">
                    Bạn chưa chọn sản phẩm nào để áp dụng mã giảm giá
                </div>
                <div class="center mr-t content_btn_update_discount_product">
                    <button type="button" class="btn color-btn-them btn_update_discount_product">
                        <i class="icon-copy fi-page-edit"></i>
                        Thiết Lập Lại Giảm Giá Sản Phẩm
                    </button>
                    <a href="" class="btn btn-danger">
                        <i class="icon-copy fi-x"></i>
                        Hủy Thay Đổi
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Chọn Sản Phẩm Áp Dụng Giảm Giá</h4>
        </div>
        <div class="pb-20">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <form action="">
                                @csrf
                                <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm search_product_discount" id="search_product_discount_update" placeholder="Tìm Kiếm"
                                    aria-controls="DataTables_Table_0"></label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="content_find_product_discount">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <form class="form_checkbox_discount_product">
                                @csrf
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                                    id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="dt-body-center" rowspan="1" colspan="1" aria-label="" data-defaultsort="disabled">
                                                <div class="dt-checkbox">
                                                    <input type="checkbox" class="checkAll" name="select_all" id="example-select-all">
                                                    <span class="dt-checkbox-label"></span>
                                                </div>
                                            </th>
                                            <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1"
                                                aria-label="Name" data-defaultsort="disabled">Hình Ảnh</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                                            {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1">Đơn vị tính</th> --}}

                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">Giá</th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">Số Lượng Trong Kho</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_update_discount">
                                        @foreach ($all_product as $product)
                                            @if ($product->discount_id == null || $product->discount_id == $discount->discount_id)
                                                <tr>
                                                    <td class=" dt-body-center" tabindex="0">
                                                        <div class="dt-checkbox">
                                                            <input type="checkbox" class="check check_{{ str_replace(' ','',$product->product_name) }}" name="Product[]" value="{{ $product->product_name }}"
                                                                @foreach ($products as $prod)
                                                                    @if ($prod->product_id == $product->product_id)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            >
                                                            <span class="dt-checkbox-label"></span>
                                                        </div>
                                                    </td>
                                                    <td class="table-plus" tabindex="0">
                                                        <div class="da-card box-shadow" style="height: 50px; width: 50px">
                                                            <div class="da-card-photo">
                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="hình ảnh"
                                                                    srcset="" style="height: 50px; width: 50px">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ URL::to('admin/view_detail_product/'.$product->product_id) }}">{{ $product->product_name }}</a>
                                                    </td>
                                                    <td>
                                                        {{ number_format($product->price, 0, ',', '.') }} vnđ
                                                    </td>
                                                    <td class="text-center">{{ $product->total_quantity_product }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-sm-12 col-md-5">

                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $products->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
