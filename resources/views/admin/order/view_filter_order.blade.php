
    <div class="row pd-20">
        <div class="pd-20">
            <h4 class="text-blue h4">{{ $string_title }}</h4>
        </div>
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
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#Modal_filter_order_follow_price">Theo giá</a>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#Modal_filter_order_follow_payment_status">
                                    Trạng thái thanh toán
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#Modal_filter_order_follow_method_pay">
                                    Hình thức thanh toán
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#Modal_filter_order_follow_date">
                                    Theo ngày
                                </a>
                            </div>
                        </div>
                    </div>
                    @if (count($orders) > 0)
                        <div class="content_print_pdf_product ml-10">
                            <form action="{{ URL::to('admin/print_pdf_order') }}" method="post">
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
            </div>

            <div class="content_find_order pt-10">
                @if (count($orders) > 0)
                    <div class="center">
                        Tìm thấy <span style="color: blue">{{ count($orders) }}</span> kết quả phù hợp
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th  class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">STT</th>
                                        <th  class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Mã Đơn Hàng</th>
                                        <th  class="sorting" text-center tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1">Tổng Giá Đơn Hàng</th>
                                        <th  class="sorting" text-center tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Phương Thức Thanh Toán</th>
                                        <th  class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" data-defaultsort="disabled">Tình Trạng Đơn Hàng</th>
                                        <th  class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
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
                                                    <td class="">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
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
                                                                                <span class="badge badge-warning" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 2)
                                                                                <span class="badge badge-info" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 3)
                                                                                <span class="badge" style="background-color:rgb(0, 180, 137); color: white; width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 4)
                                                                                <span class="badge badge-success" style="width: 88.5px;">{{ $status->status_name }}</span>

                                                                            @elseif($status_order_detail->status_id == 5)
                                                                                <span class="badge badge-danger" style="width: 88.5px;">{{ $status->status_name }}</span>
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
                            <div class="center">
                                <a href="" class="btn btn-outline-dark">
                                    <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="center pd-10">
                        Không tìm thấy kết quả nào
                        <a href="" class="btn btn-outline-dark">
                            <i class="icon-copy fa fa-history" aria-hidden="true"></i>
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
