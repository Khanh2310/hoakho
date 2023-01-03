@if (count($all_shipping_cost) > 0)
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Vị Trí Bắt Đầu</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Vị Trí Kết Thúc</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Giá Vận Chuyển</th>
                        @hasrole(['admin', 'manager'])
                            <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                        @endhasrole
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stt = 0;
                    @endphp
                    @foreach ($all_shipping_cost as $cost)
                        @php
                            $stt++;
                        @endphp
                        <tr role="row" class="odd">
                            <td>{{ $stt }}</td>
                            <td>{{ $cost->start_position }}</td>
                            <td>{{ $cost->end_position }}</td>
                            <td>{{ number_format($cost->cost, 0, ',', '.') }}₫</td>
                            @hasrole(['admin', 'manager'])
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                            @hasrole(['admin', 'manager'])
                                                <a class="dropdown-item" href="{{ URL::to('admin/update_shipping_cost/' . $cost->id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                            @endhasrole
                                            @hasrole('admin')
                                                <button class="dropdown-item delete_shipping_cost" data-id="{{ $cost->id }}" data-toggle="modal" data-target="#Modal_delete"><i
                                                        class="dw dw-delete-3"></i>Xóa</button>
                                            @endhasrole
                                        </div>
                                    </div>
                                </td>
                            @endhasrole
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="text-center">Không tìm thấy kết quả nào</div>
@endif
