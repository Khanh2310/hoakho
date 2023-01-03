@if (count($all_storage) > 0)
<div class="row">
    <div class="col-12">
        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
            id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1">STT</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1" >Tên Loại</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1">Ngày Thêm</th>
                    <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1"
                        aria-label="Action">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="content_find_storage">
                @php
                    $stt = 0;
                @endphp
                @foreach ($all_storage as $storage)
                    @php
                        $stt++;
                    @endphp

                    <tr role="row" class="odd">
                        <td>{{ $stt }}</td>
                        <td>
                            <a href="{{ URL::to('admin/all_storage_product/'.$storage->storage_id) }}">
                                {{ $storage->storage_name }}
                            </a>
                        </td>
                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $storage->created_at)->format('d-m-Y') }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
                                    href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="{{ URL::to('admin/all_storage_product/'.$storage->storage_id) }}"><i class="dw dw-eye"></i>Xem kho hàng</a>
                                    @hasrole(['admin','manager'])
                                    <a class="dropdown-item" href="{{ URL::to('admin/update_storage_when_find/'.$storage->storage_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                    @endhasrole
                                    @hasrole(['admin'])
                                    <a class="dropdown-item" href="{{ URL::to('admin/process_delete_storage_when_find/'.$storage->storage_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
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
