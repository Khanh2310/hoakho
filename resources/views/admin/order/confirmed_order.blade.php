@extends('admin.layout_admin')
@section('container')
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_order') }}">Danh sách đơn hàng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách đơn hàng chờ giao</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    {{-- MESSAGE --}}
    @if (session('confirm_delivary_success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('confirm_delivary_success') }}
        </div>
    @endif
    {{--  --}}
    <div class="card-box mb-30">
        <div class="row pd-20">
            <div class="pd-20">
                <h4 class="text-blue h4">Danh Sách Đơn Hàng Chờ Giao</h4>
            </div>
        </div>
        @if (count($orders) > 0)
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                <form action="">
                                    @csrf
                                    <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm"  placeholder="Tìm Kiếm"
                                        aria-controls="DataTables_Table_0" id="mySearch"></label>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content_find_category">
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
                                                aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_search">
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
                                                    <button type="button" class="btn btn-success btn_confirm_delivery_order" data-toggle="modal" data-target="#modal_confirm_delivery_modal" data-id="{{ $order->order_code }}"><i class="icon-copy dw dw-truck"></i>... Giao Hàng</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {{-- {!! $all_category->links() !!} --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="center pd-10">
                Không có đơn hàng nào đang chờ giao
            </div>
        @endif

    </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="modal_confirm_delivery_modal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thông Báo</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="modal_body_delivary">Xác nhận giao đơn hàng ?</div>
            <form action="{{ URL::to('admin/confirm_delivary_order') }}" method="post" name="form_submit_confirm_delivary_order">
                @csrf
                <input type="hidden" value="" name="order_code" class="val_order_code">
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-success btn_confirm_delivery_modal">Xác Nhận</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        </div>

      </div>
    </div>
</div>
@endsection
