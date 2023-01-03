@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage') }}">Danh sách kho hàng</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_storage_product/' . $storage_id) }}">Danh sách kho sản
                                    phẩm</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch sử nhập hàng</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-4 col-sm-12">
                    {{-- <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        January 2018
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Export List</a>
                        <a class="dropdown-item" href="#">Policies</a>
                        <a class="dropdown-item" href="#">View Assets</a>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="row pd-20">
                <div class="pd-20">
                    <h4 class="text-blue h4">Lịch Sử Nhập Hàng
                        @foreach ($all_product as $product)
                            @if ($product->product_id == $storage_product->product_id)
                                - "{{ $product->product_name }}"
                            @endif
                        @endforeach
                    </h4>
                </div>
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    @if (count($history_storage_product) > 0)
                        <div class="row">
                            <div class="col-sm-12 col-md-6 d-flex">
                                <div class="content_print_pdf_storage_product ml-10 mb-10">
                                    <form action="{{ URL::to('admin/print_pdf_history_storage_product') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $storage_product->product_id }}">
                                        <input type="hidden" name="storage_product_id" value="{{ $storage_product->storage_product_id }}">
                                        <button type="submit" class="btn btn-secondary">
                                            Xuất
                                            <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 table-responsive">
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Nhân Viên Nhập</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Lượng Tồn Kho</th>
                                            <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action">Số Lượng Nhập Mới</th>
                                            <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action">Ngày Nhập Hàng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $stt = 0;
                                        @endphp
                                        @foreach ($history_storage_product as $history_item)
                                            @php
                                                $stt++;
                                            @endphp
                                            <tr role="row" class="odd">
                                                <td>{{ $stt }}</td>
                                                <td>
                                                    @foreach ($all_admin as $admin)
                                                        @if ($history_item->admin_id == $admin->admin_id)
                                                            {{ $admin->admin_name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $history_item->quantity_current }}</td>
                                                <td>{{ $history_item->quantity_import }}</td>
                                                <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $history_item->created_at)->format('d-m-Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="1" style="font-size: 18px">Số lượng hiện tại:</td>
                                            <td colspan="1" style="font-size: 18px">{{ $quantity_total }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="center">
                            Lịch sử trống
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $history_storage_product->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
