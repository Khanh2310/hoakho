<div class="card-box mb-30">
    <div class="row pd-20">
        <div class="pd-20">
            <h4 class="text-blue h4">Danh Sách Kho Sản Phẩm {{ $string_title }}</h4>
        </div>
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_storage_product_follow_quantity">Số lượng đơn đặt
                                    hàng</a>
                            </div>
                        </div>
                    </div>
                    @if (count($all_storage_product) > 0)
                        <div class="content_print_pdf_storage_product ml-10">
                            <form action="{{ URL::to('admin/print_pdf_storage_product') }}" method="post">
                                @csrf
                                @if (isset($type_filter))
                                    <input type="hidden" name="storage_id" value="{{ $storage_id }}">
                                    <input type="hidden" class="type_filter" name="type_filter" value="{{ $type_filter }}">
                                    <input type="hidden" class="level_filter" name="level_filter" value="{{ $level_filter }}">
                                    @if (isset($quantity_start) && isset($quantity_end))
                                        <input type="hidden" name="quantity_start" value="{{ $quantity_start }}">
                                        <input type="hidden" name="quantity_end" value="{{ $quantity_end }}">
                                    @else
                                        <input type="hidden" name="quantity_start" value="">
                                        <input type="hidden" name="quantity_end" value="">
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
                    {{-- <div id="DataTables_Table_0_filter" class="dataTables_filter">
                        <form action="">
                            @csrf
                            <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm"
                                    id="find_storage_product" placeholder="Tìm Kiếm"
                                    aria-controls="DataTables_Table_0"></label>
                            <input type="hidden" value="{{ $storage_id }}" name="storage_id" id="storage_id">
                        </form>
                    </div> --}}
                </div>
            </div>
            @if (count($all_storage_product) > 0)
                <div class="text-center pd-10">
                    "Tìm thấy <span style="color: blue">{{ count($all_storage_product) }}</span> kết quả phù hợp"
                </div>
                <div class="content_find_storage_product">
                    <div class="row">
                        <div class="col-12">
                            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                                aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Hình Ảnh</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số lượng</th>
                                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($all_storage_product as $storage_product)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <td>{{ $stt }}</td>
                                            @foreach ($all_product as $product)
                                                @if ($storage_product->product_id == $product->product_id)
                                                    <td class="table-plus sorting_1" tabindex="0">
                                                        <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                                            <div class="da-card-photo">
                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" style="height: 80px !important; width: 80px !important;"
                                                                    alt="hình ảnh" srcset="">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $product->product_name }}</td>
                                                @endif
                                            @endforeach
                                            <td>{{ $storage_product->total_quantity_product }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        @hasrole(['admin','manager'])
                                                        <a class="dropdown-item" href="{{ URL::to('admin/import_storage_product/'.$storage_product->storage_product_id) }}"><i class="icon-copy dw dw-add"></i>Nhập hàng</a>
                                                        @endhasrole
                                                        <a class="dropdown-item" href="{{ URL::to('admin/history_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-eye"></i>Xem Lịch sử</a>
                                                        @hasrole(['admin','manager'])
                                                        <a class="dropdown-item" href="{{ URL::to('admin/update_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                                        @endhasrole
                                                        @hasrole(['admin'])
                                                        <a class="dropdown-item" href="{{ URL::to('admin/process_delete_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
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
                </div>
            @else
                <div class="center">
                    Không tìm thấy kết quả nào
                    <a href="" class="btn btn-outline-dark">
                        <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
            {{-- <div class="row">
                <div class="col-sm-12 col-md-5">
                    <a href="{{ URL::to('admin/view_recycle_storage_product/' . $storage_id) }}"
                        class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i> Thùng
                        Rác</a>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        <ul class="pagination">
                            {!! $all_storage_product->links() !!}
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<script src="{{ asset('public/back_end/src/scripts/custom.js') }}"></script>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
