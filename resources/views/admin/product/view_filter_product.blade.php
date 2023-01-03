<link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/sort_table/Contents/bootstrap-sortable.css') }}">
<div class="pd-20">
    <h4 class="text-blue h4">Danh Sách {{ $string_title }}</h4>
</div>
<div class="pb-20">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
        <div class="row">
            <div class="col-sm-12 col-md-6 d-flex">
                <div class="content_filter pl-20">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
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
                @if (count($all_product) > 0)
                    <div class="content_print_pdf_product ml-10">
                        <form action="{{ URL::to('admin/print_pdf_product') }}" method="post">
                            @csrf
                            @if (isset($type_filter))
                                <input type="hidden" class="type_filter" name="type_filter" value="{{ $type_filter }}">
                                <input type="hidden" class="level_filter" name="level_filter" value="{{ $level_filter }}">
                                @if (isset($level_array))
                                    @foreach ($level_array as $level)
                                        <input type="hidden" name="level_array[]" value="{{ $level }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="level_array[]" value="">
                                @endif
                                @if (isset($price_filter_start) && isset($price_filter_end))
                                    <input type="hidden" name="price_filter_start" value="{{ $price_filter_start }}">
                                    <input type="hidden" name="price_filter_end" value="{{ $price_filter_end }}">
                                @else
                                    <input type="hidden" name="price_filter_start" value="">
                                    <input type="hidden" name="price_filter_end" value="">
                                @endif
                                @if (isset($start_date) && isset($end_date))
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                @else
                                    <input type="hidden" name="start_date" value="">
                                    <input type="hidden" name="end_date" value="">
                                @endif
                            @else
                                <input type="hidden" class="type_filter" name="type_filter" value="">
                                <input type="hidden" class="level_filter" name="level_filter" value="">
                            @endif
                            <button type="submit" class="btn btn-secondary">
                                Xuất
                                <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                            </button>
                        </form>
                    </div>
                @endif

            </div>
            <div class="col-sm-12 col-md-6">
            </div>
        </div>
        <div class="content_find_product">
        @if (count($all_product) > 0)
            <div class="text-center pd-10">
                "Tìm thấy <span style="color: blue">{{ count($all_product) }}</span> kết quả phù hợp"
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1">STT</th>
                                <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1"
                                    aria-label="Name" data-defaultsort="disabled">Hình Ảnh</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1">Giá</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1">Trong Kho</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1">Đã Bán</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1">Đánh Giá</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" data-defaultsort="disabled">Mới</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" data-defaultsort="disabled">Đặc Trưng</th>

                                @hasrole(['admin', 'manager','employee'])
                                <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                                    aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody class="">
                            @php
                                $stt = 1;
                            @endphp
                            @foreach ($all_product as $prod)
                            @php
                                $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($prod->product_id);
                                $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($prod->product_id);

                            @endphp
                            <tr role="row" class="odd">
                                <td>{{ $stt++ }}</td>
                                <td class="table-plus" tabindex="0">
                                        <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                            <div class="da-card-photo">
                                                <img src="{{ asset('public/upload/' . $prod->product_image) }}" alt="hình ảnh"
                                                    srcset="" style="height: 80px; width: 80px">
                                                <div class="da-overlay">
                                                    <div class="da-social">
                                                        <ul class="clearfix">
                                                            <li><a href="{{ URL::to('admin/all_gallery_product/'.$prod->product_id) }}"><i class="icon-copy dw dw-eye"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/view_detail_product/'.$prod->product_id) }}">{{ $prod->product_name }}</a>
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/history_price_product/'.$prod->product_id) }}">{{ number_format($price_discount->price_now, 0, ',', '.') }}₫</a>
                                </td>
                                <td class="text-center">
                                    {{ $prod->total_quantity_product }}
                                </td>
                                <td class="text-center">
                                    {{ $info_rating_saled->count_product_saled }}
                                </td>
                                <td class="text-center">
                                    {{ $info_rating_saled->avg_rating }} <i class="icon-copy fa fa-star" aria-hidden="true" style="color: #fddf0a; font-size: 18px"></i>
                                </td>
                                <td class="center">
                                    @if ($prod->is_new == 1)
                                        <i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                                    @else
                                        <i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                                    @endif
                                </td>
                                @hasrole(['admin','manager'])
                                <td class="center">
                                    @if ($prod->is_featured == 1)
                                        <a href="{{ URL::to('admin/is_not_featured/'.$prod->product_id) }}"><i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i></a>
                                    @else
                                        <a href="{{ URL::to('admin/is_featured/'.$prod->product_id) }}"><i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i></a>
                                    @endif
                                </td>
                                @endhasrole
                                @hasrole(['employee'])
                                <td class="center">
                                    @if ($prod->is_featured == 1)
                                        <i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                                    @else
                                        <i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                                    @endif
                                </td>
                                @endhasrole
                                <td class="">
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                            href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ URL::to('admin/view_detail_product/'.$prod->product_id) }}"><i class="dw dw-eye"></i>Thông tin sản phẩm</a>
                                            @hasrole(['admin','manager'])
                                            <a class="dropdown-item" href="{{ URL::to('admin/update_product/'.$prod->product_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                            @endhasrole
                                            @hasrole(['admin'])
                                            <a class="dropdown-item" href="{{ URL::to('admin/delete_when_find_product/'.$prod->product_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
                                            @endhasrole
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="center">
                        <a href="" class="btn btn-outline-dark">
                            <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="center">
                Không tìm thấy kết quả nào
                <a href="" class="btn btn-outline-dark">
                    <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                </a>
            </div>
        @endif
        </div>
    </div>
</div>
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
<script src="{{ asset('public/back_end/filter_product/filter_product.js') }}"></script>
