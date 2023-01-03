@if (count($result_find) > 0)
    <div class="col-12 table-responsive">
        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
            <thead>
                <tr role="row">
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                        STT</th>
                    <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1" aria-label="Name">Hình
                        Ảnh</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                        Tên Danh Mục</th>
                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                        Ngày Thêm</th>
                    @hasrole(['admin'])
                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action">Thao Tác
                        </th>
                    @endhasrole
                </tr>
            </thead>
            <tbody class="content_find_category">
                @php
                    $stt = 0;
                @endphp
                @foreach ($result_find as $cate)
                    @php
                        $stt++;
                    @endphp
                    <tr role="row" class="odd">
                        <td>{{ $stt }}</td>
                        <td class="table-plus sorting_1" tabindex="0">
                            <div class="da-card box-shadow" style="height: 80px; width: 80px">
                                <div class="da-card-photo">
                                    <img src="{{ asset('public/upload/' . $cate->cate_image) }}" alt="hình ảnh" srcset="" width="80" height="80">
                                </div>
                            </div>
                        </td>
                        <td>{{ $cate->cate_name }}</td>
                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cate->created_at)->format('d-m-Y') }}
                        </td>
                        @hasrole(['admin','manager'])
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    @hasrole(['admin', 'manager'])
                                        <a class="dropdown-item" href="{{ URL::to('admin/update_category/' . $cate->cate_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>
                                    @endhasrole
                                    @hasrole(['admin'])
                                        <a class="dropdown-item" href="{{ URL::to('admin/process_delete_category/' . $cate->cate_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
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
@else
    <div class="center">
        Không tìm thấy kết quả nào
    </div>
@endif
