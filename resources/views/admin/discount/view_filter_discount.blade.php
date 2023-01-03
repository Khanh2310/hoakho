<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">{{ $string_title }}</h4>
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
                                    data-target="#Modal_filter_discount_over_time">
                                    Thời hạn giảm giá
                                </a>
                            </div>
                        </div>
                    </div>
                    @if (count($all_discount) > 0)
                        <div class="content_print_pdf_discount ml-10">
                            <form action="{{ URL::to('admin/print_pdf_discount') }}" method="post">
                                @csrf
                                @if (isset($type_filter))
                                    <input type="hidden" class="type_filter" name="type_filter"
                                        value="{{ $type_filter }}">
                                    <input type="hidden" class="level_filter" name="level_filter"
                                        value="{{ $level_filter }}">
                                    @if (isset($level_array))
                                        @foreach ($level_array as $level)
                                            <input type="hidden" name="level_array[]" value="{{ $level }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="level_array[]" value="">
                                    @endif
                                    @if (isset($price_filter_start) && isset($price_filter_end))
                                        <input type="hidden" name="price_filter_start"
                                            value="{{ $price_filter_start }}">
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

            <div class="content_find_admin">
                @if (count($all_discount) > 0)
                    <div class="center">
                        Tìm thấy
                        <span style="color: blue"> {{ count($all_discount) }} </span>
                        kết quả phù hợp
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
                                            rowspan="1" colspan="1" data-defaultsign="AZ">Các Sản Phẩm</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1">Giảm Giá 1</th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0"
                                            rowspan="1" colspan="1">Giảm Giá 2</th>
                                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                                            aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody id="table_all_discount">
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($all_discount as $discount)
                                        @php
                                            $stt++;
                                            $now = Carbon\Carbon::now();
                                        @endphp
                                        <tr role="row" class="odd">
                                            <td>{{ $stt }}</td>
                                            <td>
                                                @foreach ($all_product as $product)
                                                    @if ($product->discount_id == $discount->discount_id)
                                                        <i class="icon-copy fa fa-check-circle" aria-hidden="true"
                                                            style="color: #626364"></i>
                                                        {{ $product->product_name }}<br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                @if ($discount->condition_discount_1 != '')
                                                    @if ($now > $discount->end_date_1)
                                                        @if ($discount->condition_discount_1 == 1)
                                                            <del>-{{ $discount->amount_discount_1 }}%</del>
                                                        @else
                                                            <del>-{{ number_format($discount->amount_discount_1, 0, ',', '.') }}vnđ</del>
                                                        @endif
                                                    @else
                                                        @if ($discount->condition_discount_1 == 1)
                                                            -{{ $discount->amount_discount_1 }}%
                                                        @else
                                                            -{{ number_format($discount->amount_discount_1, 0, ',', '.') }}vnđ
                                                        @endif
                                                    @endif
                                                @else
                                                    Null
                                                @endif

                                            </td>
                                            <td class="text-center">
                                                @if ($discount->condition_discount_2 != '')
                                                    @if ($now > $discount->end_date_2)
                                                        @if ($discount->condition_discount_2 == 1)
                                                            <del>-{{ $discount->amount_discount_2 }}%</del>
                                                        @else
                                                            <del>-{{ number_format($discount->amount_discount_2, 0, ',', '.') }}vnđ</del>
                                                        @endif
                                                    @else
                                                        @if ($discount->condition_discount_2 == 1)
                                                            -{{ $discount->amount_discount_2 }}%
                                                        @else
                                                            -{{ number_format($discount->amount_discount_2, 0, ',', '.') }}vnđ
                                                        @endif
                                                    @endif
                                                @else
                                                    Null
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                                        href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item"
                                                            href="{{ URL::to('admin/detail_discount/' . $discount->discount_id) }}">
                                                            <i class="dw dw-eye"></i>Chi tiết giảm giá
                                                        </a>
                                                        @hasrole(['admin', 'manager'])
                                                            <a class="dropdown-item"
                                                                href="{{ URL::to('admin/update_discount/' . $discount->discount_id) }}">
                                                                <i class="dw dw-edit2"></i>Thiết lập lại
                                                            </a>
                                                        @endhasrole
                                                        @hasrole('admin')
                                                        <a class="dropdown-item" href="{{ URL::to('admin/delete_discount_when_filter/'.$discount->discount_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
                                                        @endhasrole
                                                    </div>
                                                </div>
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
</div>
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
