<div class="row pd-20">
    <div class="col-10 pd-20">
        <h4 class="text-blue h4">Danh Sách Voucher - {{ $product_name }}</h4>
        <h4 class="text-blue h4">{{ $string_title }}</h4>
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
                            <a class="dropdown-item btn_filter_voucher_follow_status_apply" href="#">Đang Áp
                                dụng</a>
                            <a class="dropdown-item btn_filter_voucher_follow_status_unapply" href="#">Ngưng
                                Áp dụng</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_voucher_follow_date_create">Ngày Tạo Voucher</a>
                        </div>
                    </div>
                </div>
                @if (count($all_voucher) > 0)
                    <div class="content_print_pdf_voucher ml-10">
                        <form action="{{ URL::to('admin/print_pdf_voucher') }}" method="post">
                            @csrf
                            @if (isset($type_filter))
                                <input type="hidden" name="product_id" value="{{ $product_id }}">
                                <input type="hidden" class="type_filter" name="type_filter" value="{{ $type_filter }}">
                                <input type="hidden" class="level_filter" name="level_filter" value="{{ $level_filter }}">
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
        @if (count($all_voucher) > 0)
            <div class="text-center pd-10">
                "Tìm thấy <span style="color: blue">{{ count($all_voucher) }}</span> kết quả phù hợp"
            </div>
            <div class="content_find_voucher">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                            aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row" class="text-center">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Mã Voucher</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Tên Voucher</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Bắt Đầu</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Kết Thúc</th>
                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Tình Trạng</th>
                                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt = 0;
                                @endphp
                                @foreach ($all_voucher as $voucher)
                                    @php
                                        $stt++;
                                    @endphp
                                    <tr role="row" class="odd text-center">
                                        <td>{{ $stt }}</td>
                                        <td style="cursor: pointer;">
                                            <a href="#" class=" btn_open_modal" data-id={{ $voucher->voucher_id }} data-toggle="modal" data-target="#modal_voucher">
                                                {{ $voucher->voucher_code }}
                                            </a>
                                        </td>
                                        <td class="text-left" id="voucher_name" style="cursor: pointer;">
                                            <a href="#" class=" btn_open_modal" data-id={{ $voucher->voucher_id }} data-toggle="modal" data-target="#modal_voucher">
                                                {{ $voucher->voucher_name }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ date('d-m-y H:i a', strtotime($voucher->start_date)) }}
                                        </td>
                                        <td>
                                            {{ date('d-m-y H:i a', strtotime($voucher->end_date)) }} </td>
                                        <td>
                                            @php
                                                $now = Carbon\Carbon::now();
                                            @endphp
                                            @if ($voucher->start_date <= $now && $now <= $voucher->end_date && $voucher->voucher_quantity > 0)
                                                <span class="badge badge-success" style="width: 105px;">Đang áp
                                                    dụng</span>
                                            @elseif ($voucher->start_date > $now)
                                                <span class="badge badge-warning" style="width: 105px;">Chưa áp
                                                    dụng</span>
                                            @else
                                                <span class="badge badge-danger" style="width: 105px;">Ngưng áp
                                                    dụng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                    <i class="dw dw-more"></i>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <a class="dropdown-item" href="{{ URL::to('admin/detail_voucher/'.$voucher->voucher_id) }}"><i class="dw dw-eye"></i>Xem chi
                                                        tiết</a>
                                                    @hasrole(['admin', 'manager'])
                                                        <a class="dropdown-item" href="{{ URL::to('admin/update_voucher/' . $voucher->voucher_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                                    @endhasrole
                                                    @hasrole('admin')
                                                    <a class="dropdown-item" href="{{ URL::to('admin/delete_voucher_when_find/'.$voucher->voucher_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
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
                {{-- <div class="row">
                    <div class="col-sm-12 col-md-5">
                        <a href="{{ URL::to('admin/view_recycle_product_voucher/' . $product_id) }}"
                            class="btn color-btn-them ml-10" style="color: white"><i class="dw dw-delete-3"></i>
                            Thùng Rác</a>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            <ul class="pagination">
                                {!! $all_voucher->links() !!}
                            </ul>
                        </div>
                    </div>
                </div> --}}
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
<script src="{{ asset('public/back_end/custom_voucher/custom_voucher.js') }}"></script>
<script src="{{ asset('public/back_end/filter_voucher/filter_voucher.js') }}"></script>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
