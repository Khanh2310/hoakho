@if (count($all_customer) > 0)
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Họ Và
                            Tên</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Điện Thoại</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Email
                        </th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Đơn Hàng Đã Mua</th>
                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác
                        </th>
                    </tr>
                </thead>
                <tbody class="content_find_customer">
                    @php
                        $stt = 0;
                    @endphp
                    @foreach ($all_customer as $customer)
                        @php
                            $stt++;
                        @endphp
                        <tr role="row" class="odd">
                            <td>{{ $stt }}</td>
                            <td>
                                <a href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}">
                                    <div class="name-avatar d-flex align-items-center">
                                        <div class="avatar mr-2 flex-shrink-0">

                                            <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" class="border-radius-100 shadow" width="50" height="50" alt="">
                                        </div>
                                        <div class="txt">
                                            <div class="weight-600">{{ $customer->username }}</div>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            @if ($customer->customer_phone != '')
                                <td>{{ $customer->customer_phone }}</td>
                            @else
                                <td>Chưa cập nhật</td>
                            @endif
                            <td>{{ $customer->email }}</td>
                            <td>
                                @php
                                    $count_order = 0;
                                @endphp
                                @foreach ($all_order as $order)
                                    @if ($order->customer_id == $customer->customer_id)
                                        @php
                                            $count_order++;
                                        @endphp
                                    @endif
                                @endforeach
                                {{ $count_order }}
                            </td>
                            <td>
                                <a class="dropdown-item" href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}"><i class="dw dw-eye"></i>Xem chi tiết</a>
                            </td>
                        </tr>
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
