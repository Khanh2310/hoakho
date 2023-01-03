@if (count($all_voucher) > 0)
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
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
                <tbody class="content_find_voucher">
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
                                    <span class="badge badge-success" style="width: 105px;">Đang áp dụng</span>
                                @elseif ($voucher->start_date > $now)
                                    <span class="badge badge-warning" style="width: 105px;">Chưa áp dụng</span>
                                @else
                                    <span class="badge badge-danger" style="width: 105px;">Ngưng áp dụng</span>
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
        </div>
    </div>
@else
    <div class="center">Không có kết quả tìm kiếm</div>
@endif
<script src="{{ asset('public/back_end/custom_voucher/custom_voucher.js') }}"></script>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>

