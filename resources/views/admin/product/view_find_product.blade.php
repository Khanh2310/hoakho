@if (count($all_product) > 0)
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">STT</th>
                        <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1" aria-label="Name"
                            data-defaultsort="disabled">Hình Ảnh</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">Giá</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">Trong Kho</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">Đã Bán</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">Đánh Giá</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" data-defaultsort="disabled">Mới</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" data-defaultsort="disabled">Đặc Trưng</th>
                        @hasrole(['admin', 'manager'])
                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action"
                            data-defaultsort="disabled">Thao Tác</th>
                        @endhasrole
                    </tr>
                </thead>
                <tbody class="">
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($all_product as $prod)
                    @php
                        $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($prod->product_id);
                        $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($prod->product_id);
                    @endphp
                    <tr role="row" class="odd">
                        <td>{{ $stt++ }}</td>
                        <td class="table-plus" tabindex="0">
                                <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                    <div class="da-card-photo">
                                        <img src="{{ asset('public/upload/' . $prod->product_image) }}" alt="hình ảnh"
                                            srcset="" style="height: 80px; width: 80px">
                                        <div class="da-overlay">
                                            <div class="da-social">
                                                <ul class="clearfix">
                                                    <li><a href="{{ URL::to('admin/all_gallery_product/'.$prod->product_id) }}"><i class="icon-copy dw dw-eye"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </td>
                        <td>
                            <a href="{{ URL::to('admin/view_detail_product/'.$prod->product_id) }}">{{ $prod->product_name }}</a>
                        </td>
                        <td>
                            <a href="{{ URL::to('admin/history_price_product/'.$prod->product_id) }}">{{ number_format($prod->price, 0, ',', '.') }}₫</a>
                        </td>
                        <td class="text-center">
                            {{ $prod->total_quantity_product }}
                        </td>
                        <td class="text-center">
                            {{ $info_rating_saled->count_product_saled }}
                        </td>
                        <td class="text-center">
                            {{ $info_rating_saled->avg_rating }} <i class="icon-copy fa fa-star" aria-hidden="true" style="color: #eded4e; font-size: 18px"></i>
                        </td>
                        <td class="center">
                            @if ($prod->is_new == 1)
                                <i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                            @else
                                <i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                            @endif
                        </td>
                        @hasrole(['admin','manager'])
                        <td class="center">
                            @if ($prod->is_featured == 1)
                                <a href="{{ URL::to('admin/is_not_featured/'.$prod->product_id) }}"><i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i></a>
                            @else
                                <a href="{{ URL::to('admin/is_featured/'.$prod->product_id) }}"><i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i></a>
                            @endif
                        </td>
                        @endhasrole
                        @hasrole(['employee'])
                        <td class="center">
                            @if ($prod->is_featured == 1)
                                <i class="icon-copy fa fa-check" aria-hidden="true" style="font-size: 25px; color: rgb(5, 199, 30)"></i>
                            @else
                                <i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                            @endif
                        </td>
                        @endhasrole
                        <td class="">
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="{{ URL::to('admin/view_detail_product/'.$prod->product_id) }}"><i class="dw dw-eye"></i>Thông tin sản phẩm</a>
                                    @hasrole(['admin','manager'])
                                    <a class="dropdown-item" href="{{ URL::to('admin/update_product/'.$prod->product_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                    @endhasrole
                                    @hasrole(['admin'])
                                        <a class="dropdown-item" href="{{ URL::to('admin/delete_when_find_product/'.$prod->product_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
                                    @endhasrole
                                </div>
                            </div>
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
<script>
    $('.soft_delete_product_class').click(function() {
        var product_id = $(this).attr('data-id');
        $('.id_delete_product').val(product_id);
    });
    $('.btn_delete_soft_product').click(function() {
        var form_delete = document.forms['form_soft_delete_product'];
        form_delete.submit();
    });
</script>
