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
                                data-target="#Modal_filter_comment_follow_product">
                                Theo sản phẩm
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal"
                                data-target="#Modal_filter_comment_follow_rating">
                                Theo đánh giá
                            </a>
                        </div>
                    </div>
                </div>
                @if(count($all_comment) > 0)
                    <div class="content_print_pdf_product ml-10">
                        <form action="{{ URL::to('admin/print_pdf_comment') }}" method="post">
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
        @if(count($all_comment) > 0)
            <div class="center pd-10">
                Tìm thấy
                <span style="color: blue">{{ count($all_comment) }}</span>
                kết quả phù hợp
            </div>
            <div class="">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" data-defaultsort="disabled">Sản Phẩm</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" data-defaultsign="AZ">Khách Hàng</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1">Đánh Giá</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" data-defaultsign="AZ">Bình Luận</th>
                                    <th class="datatable-nosort sorting_disabled text-center" rowspan="1" colspan="1"
                                        aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody id="table_content_comment_process">
                                    @foreach ($all_comment as $comment)
                                            <tr>
                                                <td class="text-center">
                                                    <img src="{{ asset('public/upload/'.$comment->product_image) }}"
                                                        style="width: 70px; height: 70px" alt="">
                                                </td>
                                                <td>
                                                    @foreach ($all_customer as $customer)
                                                        @if ($customer->customer_id == $comment->customer_id)
                                                            <div class="name-avatar d-flex align-items-center">
                                                                <div class="avatar mr-2 flex-shrink-0">
                                                                    <img src="{{ asset('public/upload/'. $customer->customer_avt) }}" class="border-radius-100 shadow" width="50" height="50" alt="">
                                                                </div>
                                                                <div class="txt">
                                                                    <div class="weight-600">{{ $customer->username }}</div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                </td>
                                                <td>
                                                    @foreach ($all_rating as $rating)
                                                        @if ($rating->customer_id == $comment->customer_id && $rating->product_id == $comment->product_id)
                                                            {{ $rating->rating_level }}
                                                            <i class="icon-copy fa fa-star" aria-hidden="true" style="color: #fddf0a; font-size: 18px"></i>
                                                        @endif
                                                    @endforeach

                                                </td>
                                                <td>
                                                    {{ $comment->comment_message }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ URL::to('admin/process_unaccep_comment_when_filter/'.$comment->comment_id) }}" class="">
                                                        <i class="icon-copy fi-x" style="color: red; font-size: 25px"></i>
                                                    </a>
                                                    <a href="{{ URL::to('admin/process_accep_comment_when_filter/'.$comment->comment_id) }}" class="">
                                                        <i class="icon-copy fa fa-check" aria-hidden="true"
                                                            style="color: rgb(16, 209, 32); font-size: 25px; padding-left: 5px"></i>
                                                    </a>

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
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
