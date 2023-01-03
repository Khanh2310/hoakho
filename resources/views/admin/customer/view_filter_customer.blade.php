<link rel="stylesheet" type="text/css" href="{{ asset('public/back_end/sort_table/Contents/bootstrap-sortable.css') }}">
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="pd-20">
    <h4 class="text-blue h4">Danh Sách Khách Hàng {{ $string_title }}</h4>
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
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_customer_follow_order_quantity">Số lượng đơn đặt hàng</a>
                        </div>
                    </div>
                </div>
                @if (count($all_customer) > 0)
                    <div class="content_print_pdf_customer ml-10">
                        <form action="{{ URL::to('admin/print_pdf_customer') }}" method="post">
                            @csrf
                            @if (isset($type_filter))
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
        </div>
        @if (count($all_customer) > 0)
            <div class="text-center pd-10">
                "Tìm thấy <span style="color: blue">{{ count($all_customer) }}</span> kết quả phù hợp"
            </div>
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Họ Và Tên</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Điện Thoại</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Đơn Hàng Đã Mua</th>
                                <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        <a href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}"><i class="dw dw-eye"></i> Xem chi tiết</a>
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
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
<script src="{{ asset('public/back_end/filter_customer/filter_order_customer.js') }}"></script>
