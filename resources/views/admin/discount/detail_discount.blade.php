@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4 style="color: #1b00ff;">Chi Tiết Giảm Giá</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_discount') }}">Danh sách giảm
                                    giá</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết giảm giá</li>
                        </ol>
                    </nav>
                </div>
                @hasrole('admin')
                    <div class="col-md-6 col-sm-12 text-right">
                        <button type="button" class="btn btn-primary dropdown-toggle waves-effect" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="icon-copy dw dw-search2"></i>
                            Truy vết theo
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item" data-toggle="modal"
                                data-target="#Modal_trace_discount_side_discount">
                                Giảm giá sản phẩm
                            </button>
                        </div>
                    </div>
                @endhasrole
            </div>
        </div>
        <div id="content_trace_discount">

        </div>
        <!-- Simple Datatable start -->
        <div class="card-box pd-20 mb-30">
            <div class="pd-10 d-flex flex-row">
                <h4 class="h4">#Giảm Giá 1</h4>
                <div class="h5 ml-10">
                    ({{ date('d/m/Y H:i a', strtotime($discount->start_date_1)) }}
                    -
                    {{ date('d/m/Y H:i a', strtotime($discount->end_date_1)) }})
                </div>
                @php
                    $now = Carbon\Carbon::now();
                @endphp
                @if ($discount->start_date_1 <= $now && $now <= $discount->end_date_1)
                    <span class="badge badge-success align-self-start ml-10">Còn Thời Hạn</span>
                @elseif($now < $discount->start_date_1)
                        <span class="badge badge-warning align-self-start ml-10">Chưa Tới Ngày Giảm</span>
                    @else
                        <span class="badge badge-danger align-self-start ml-10">Hết Thời Hạn</span>
                @endif
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-hover" id="DataTables_Table_0" role="grid"
                                aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" data-defaultsign="AZ">Sản Phẩm</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" data-defaultsign="AZ">Giảm</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1" data-defaultsign="AZ">Giá Sau Khi Giảm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_product as $product)
                                        <tr>
                                            <td>
                                                <div class="name-avatar d-flex align-items-center">
                                                    <div class="da-card box-shadow" style="height: 50px; width: 50px">
                                                        <div class="da-card-photo">
                                                            <img src="{{ asset('public/upload/' . $product->product_image) }}"
                                                                alt="hình ảnh" srcset="" style="height: 50px; width: 50px">
                                                        </div>
                                                    </div>
                                                    <div class="txt">
                                                        <div class="weight-600 ml-10">{{ $product->product_name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                    {{ date("d/m/Y H:i a", strtotime($discount->start_date_1)) }}
                                                </td>
                                                <td>
                                                    {{ date("d/m/Y H:i a", strtotime($discount->end_date_1)) }}
                                                </td> --}}
                                            <td>
                                                @if ($discount->condition_discount_1 == 1)
                                                    {{ $discount->amount_discount_1 }}%
                                                @else
                                                    -{{ number_format($discount->amount_discount_1, 0, ',', '.') }}₫
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $price = $product->price;
                                                @endphp
                                                @if ($discount->condition_discount_1 == 1)
                                                    @php
                                                        $price_discount = ($price * $discount->amount_discount_1) / 100;
                                                    @endphp
                                                    {{ number_format($price - $price_discount, 0, ',', '.') }}₫
                                                @else
                                                    {{ number_format($price - $discount->amount_discount_1, 0, ',', '.') }}₫
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Giảm Giá 2 --}}
            <div class="pd-10 d-flex flex-row">
                <h4 class="h4">#Giảm Giá 2</h4>
                <div class="h5 ml-10">
                    ({{ date('d/m/Y H:i a', strtotime($discount->start_date_2)) }}
                    -
                    {{ date('d/m/Y H:i a', strtotime($discount->end_date_2)) }})
                </div>
                @if ($discount->start_date_2 != '')
                    @if ($discount->start_date_2 <= $now && $now <= $discount->end_date_2)
                        <span class="badge badge-success align-self-start ml-10">Còn Thời Hạn</span>
                    @elseif($now < $discount->start_date_2)
                            <span class="badge badge-warning align-self-start ml-10">Chưa Tới Ngày Giảm</span>
                        @else
                            <span class="badge badge-danger align-self-start ml-10">Hết Thời Hạn</span>
                    @endif
                @endif
            </div>
            @if ($discount->start_date_2 == '')
                <div class="center">Bạn chưa thiết lập giảm giá 2</div>
            @else
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered table-hover" id="DataTables_Table_0" role="grid"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" data-defaultsign="AZ">Sản Phẩm</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" data-defaultsign="AZ">Giảm</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" data-defaultsign="AZ">Giá Sau Khi Giảm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($all_product as $product)
                                            <tr>
                                                <td>
                                                    <div class="name-avatar d-flex align-items-center">
                                                        <div class="da-card box-shadow" style="height: 50px; width: 50px">
                                                            <div class="da-card-photo">
                                                                <img src="{{ asset('public/upload/' . $product->product_image) }}"
                                                                    alt="hình ảnh" srcset=""
                                                                    style="height: 50px; width: 50px">
                                                            </div>
                                                        </div>
                                                        <div class="txt">
                                                            <div class="weight-600 ml-10">{{ $product->product_name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($discount->condition_discount_2 == 1)
                                                        {{ $discount->amount_discount_2 }}%
                                                    @else
                                                        -{{ number_format($discount->amount_discount_2, 0, ',', '.') }}₫
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $price = $product->price;
                                                    @endphp
                                                    @if ($discount->condition_discount_2 == 1)
                                                        @php
                                                            $price_discount = ($price * $discount->amount_discount_2) / 100;
                                                        @endphp
                                                        {{ number_format($price - $price_discount, 0, ',', '.') }}₫
                                                    @else
                                                        {{ number_format($price - $discount->amount_discount_2, 0, ',', '.') }}₫
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <a href="#time_line_his" class="h4 ml-10" data-toggle="collapse">Lịch Sử Giảm Giá</a>
            <div class="profile-timeline collapse" id="time_line_his">
                <div class="profile-timeline-list">
                    <ul>
                        @foreach ($time_line_his as $time)
                            <li>
                                <div class="date">{{ date('d/m/Y', strtotime($time->action_time)) }}</div>
                                <a href="#detail_time_line_{{ date('d_m_Y_H_i_s', strtotime($time->action_time)) }}"
                                    data-toggle="collapse" class="task-name">{{ $time->action_message }}</a>
                                <p>
                                <table class="table table-bordered collapse"
                                    id="detail_time_line_{{ date('d_m_Y_H_i_s', strtotime($time->action_time)) }}"
                                    style="font-size: 13px">
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Ngày Bắt Đầu 1</th>
                                        <th>Ngày Kết Thúc 1</th>
                                        <th>Giảm 1</th>
                                        <th>Ngày Bắt Đầu 2</th>
                                        <th>Ngày Kết Thúc 2</th>
                                        <th>Giảm 2</th>
                                    </tr>
                                    @foreach ($history_discount as $his)
                                        @if (date('d/m/Y H:i:s', strtotime($time->action_time)) == date('d/m/Y H:i:s', strtotime($his->created_at)))
                                            <tr>
                                                <td style="font-size: 12px">
                                                    @foreach ($all_product_history_discount as $prod_his)
                                                        @if ($prod_his->product_id == $his->product_id && $time->action_time == $his->created_at)
                                                            {{ $prod_his->product_name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td style="font-size: 12px">
                                                    {{ date('d/m/Y H:i a', strtotime($his->start_date_1)) }}</td>
                                                <td style="font-size: 12px">
                                                    {{ date('d/m/Y H:i a', strtotime($his->end_date_1)) }}</td>
                                                <td>
                                                    @if ($his->condition_discount_1 == 1)
                                                        {{ $his->amount_discount_1 }}%
                                                    @else
                                                        {{ number_format($his->amount_discount_1, 0, ',', '.') }}₫
                                                    @endif
                                                </td>
                                                @if ($his->start_date_2 != '')
                                                    <td style="font-size: 12px">
                                                        {{ date('d/m/Y H:i a', strtotime($his->start_date_2)) }}</td>
                                                    <td style="font-size: 12px">
                                                        {{ date('d/m/Y H:i a', strtotime($his->end_date_2)) }}</td>
                                                    <td>
                                                        @if ($his->condition_discount_2 == 1)
                                                            {{ $his->amount_discount_2 }}%
                                                        @else
                                                            {{ number_format($his->amount_discount_2, 0, ',', '.') }}₫
                                                        @endif
                                                    </td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif

                                            </tr>
                                        @endif
                                    @endforeach
                                </table>

                                </p>
                                <div class="task-time">{{ date('H:i:s a', strtotime($time->action_time)) }}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        {{-- include modal trace --}}
        @include('admin.discount.modal_trace_side_discount')
    @endsection
