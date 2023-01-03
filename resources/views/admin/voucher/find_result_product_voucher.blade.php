@if (count($count_result) > 0)
    <div class="row">
        <div class="col-12">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row" class="text-center">
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Sản Phẩm</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Lượng Voucher</th>
                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="content_find_product_voucher">
                    @php
                        $stt = 0;
                    @endphp
                    @foreach ($all_product_voucher as $product_voucher)
                        @php
                            $unique_product_id = App\Http\Controllers\VoucherController::unique_product($product_voucher->product_id);
                        @endphp
                        @if ($unique_product_id == 1)
                            @php
                                $stt++;
                            @endphp
                            <tr role="row" class="odd text-center">
                                <td>{{ $stt }}</td>
                                <td>
                                    <a href="{{ URL::to('admin/all_voucher/' . $product_voucher->product_id) }}">
                                        {{ $product_voucher->product_name }}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $count_voucher = 0;
                                    @endphp
                                    @foreach ($all_voucher as $voucher)
                                        @if ($voucher->product_id == $product_voucher->product_id)
                                            @php
                                                $count_voucher++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{ $count_voucher }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            <a class="dropdown-item" href="{{ URL::to('admin/all_voucher/' . $product_voucher->product_id) }}"><i class="dw dw-eye"></i>Xem danh sách
                                                voucher</a>
                                            @hasrole(['admin', 'manager'])
                                                <a class="dropdown-item" href="{{ URL::to('admin/add_product_voucher/' . $product_voucher->product_id) }}"><i class="icon-copy dw dw-add"></i>Thêm
                                                    voucher</a>
                                            @endhasrole
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="center">Không tìm thấy kết quả nào</div>
@endif
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
