@if (count($orders) > 0)
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th style="width: 2%;" class="sorting text-center" tabindex="0"
                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                        <th style="width: 13%;" class="sorting text-center" tabindex="0"
                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Mã
                            Đơn Hàng</th>
                        <th style="width: 20%;" class="sorting" text-center tabindex="0"
                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Tổng Giá Đơn Hàng</th>
                        <th style="width: 30%;" class="sorting" text-center tabindex="0"
                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">
                            Phương Thức Thanh Toán</th>
                        <th style="width: 20%;" class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                            rowspan="1" colspan="1" data-defaultsort="disabled">Tình Trạng Đơn Hàng</th>
                        <th style="width: 15%;" class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                            aria-label="Action" data-defaultsort="disabled">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($orders as $order)
                        <tr role="row" class="odd">
                            <td class="text-center">{{ $stt++ }}</td>
                            <td class="text-center">
                                <a href="{{ URL::to('admin/detail_order_item/'.$order->order_id) }}"><b>{{ $order->order_code }}</b></a>
                            </td>
                            <td class="">{{ number_format($order->total_price, 0, ',', '.') }} vnđ</td>
                            <td class="">
                                @foreach ($payment_method as $method_pay)
                                    @if ($order->payment_id == $method_pay->payment_id)
                                        {{ $method_pay->payment_name }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if ($order->status_pay == 1)
                                    <span class="badge badge-success" style="width: 107px">Đã Thanh Toán</span>
                                @else
                                    <span class="badge badge-danger" style="width: 107px">Chưa Thanh Toán</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($order_detail_status as $status_order_detail)
                                    @if ($order->order_id == $status_order_detail->order_id)
                                        @foreach ($status_order as $status)
                                            @if ($status->status_id == $status_order_detail->status_id)
                                                @if ($status_order_detail->status_id == 1)
                                                    <span class="badge badge-warning"
                                                        style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif
                                                @if ($status_order_detail->status_id == 2)
                                                    <span class="badge badge-info"
                                                        style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif
                                                @if ($status_order_detail->status_id == 3)
                                                    <span class="badge"
                                                        style="background-color:rgb(0, 180, 137); color: white; width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif
                                                @if ($status_order_detail->status_id == 4)
                                                    <span class="badge badge-success"
                                                        style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif
                                                @if ($status_order_detail->status_id == 5)
                                                    <span class="badge badge-danger"
                                                        style="width: 88.5px;">{{ $status->status_name }}</span>
                                                @endif

                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
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
