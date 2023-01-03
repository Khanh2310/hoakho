@if (count($all_product) > 0)
    <div class="row">
        <div class="col-12">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Hình Ảnh</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Tên Sản Phẩm</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số lượng</th>
                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="content_find_storage_product">
                    @php
                        $stt = 0;
                    @endphp
                    @foreach ($all_storage_product as $storage_product)
                        @php
                            $stt++;
                        @endphp
                        @foreach ($all_product as $product)
                            @if ($product->product_id == $storage_product->product_id)
                                <tr>
                                    <td>{{ $stt }}</td>
                                    <td class="table-plus sorting_1" tabindex="0">
                                        <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                            <div class="da-card-photo">
                                                <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="hình ảnh" srcset="">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $storage_product->total_quantity_product }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                            href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            @hasrole(['admin','manager'])
                                            <a class="dropdown-item" href="{{ URL::to('admin/import_storage_product/'.$storage_product->storage_product_id) }}"><i class="icon-copy dw dw-add"></i>Nhập hàng</a>
                                            @endhasrole
                                            <a class="dropdown-item" href="{{ URL::to('admin/history_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-eye"></i>Xem Lịch sử</a>
                                            @hasrole(['admin','manager'])
                                            <a class="dropdown-item" href="{{ URL::to('admin/update_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                            @endhasrole
                                            @hasrole(['admin'])
                                            <a class="dropdown-item" href="{{ URL::to('admin/process_delete_storage_product/'.$storage_product->storage_product_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
                                            @endhasrole
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="center">Không có kết quả tìm kiếm</div>
@endif
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
