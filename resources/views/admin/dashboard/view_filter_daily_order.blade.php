
<div class="card-box mb-30 content_filter_admin">
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <div class="pd-20">
                <h4 class="text-blue h4">{{ $string_title }}</h4>
            </div>
        </div>
        <div class="col-sm-12 col-md-4 text-right">
            @if (count($statisticals_daily) > 0)
                <div class="content_print_pdf_product pd-20">
                    <form action="{{ URL::to('admin/print_pdf_dashbpard_revenue_daily') }}" method="post">
                        @csrf
                        {{-- type filter --}}
                            <input type="hidden" name="date_start" value="{{ $date_start }}">
                            <input type="hidden" name="date_end" value="{{ $date_end }}">
                        {{--  --}}
                        <button type="submit" class="btn btn-secondary">
                            Xuất
                            <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <div class="pb-20">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
            @if (count($statisticals_daily) > 0)
                <div class="row">
                    <div class="col-sm-12 col-md-8 d-flex">
                        <div class="content-filter-date pd-10 d-flex">
                            <div class="row">
                                <div class="col-5">
                                    <input type="date" class="form-control" id="date_start_order_daily">
                                </div>
                                <div class="col-1" style="display: flex; align-items: center">
                                    <i class="icon-copy fa fa-long-arrow-right" aria-hidden="true"></i>
                                </div>
                                <div class="col-5">
                                    <input type="date" class="form-control" id="date_end_order_daily">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-4 text-right">
                        <h6 class="pd-10 pr-30 pt-30">
                            Tổng doanh thu: {{ number_format($revenue, 0, ',', '.') }}₫
                        </h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table
                            class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                        rowspan="1" colspan="1">STT</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                        rowspan="1" colspan="1">Ngày</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                        rowspan="1" colspan="1">Số Lượng Đơn Hàng Đã Bán</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                        rowspan="1" colspan="1">Tổng Tiền</th>
                                </tr>
                            </thead>
                            <tbody class="content_find_admin">
                                @php
                                    $stt = 0;
                                @endphp
                                @foreach ($statisticals_daily as $stati)
                                <tr>
                                    <td>{{ ++$stt }}</td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($stati['date'])) }}
                                    </td>
                                    <td>
                                        {{ $stati['count_order'] }}
                                    </td>
                                    <td>
                                        {{ number_format($stati['total_receive'], 0, ',', '.') }}₫

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<script src="{{ asset('public/back_end/src/scripts/ajax_filter_order_daily_dashboard.js') }}"></script>

