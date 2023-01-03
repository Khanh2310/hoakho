<div class="pd-20">
    <h4 class="text-blue h4">{{ $string_title }}</h4>
</div>
<div class="pb-20">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
        <div class="row">
            <div class="col-sm-12 col-md-6 d-flex pd-10">
                <div class="content_filter pl-20">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                            <i class="icon-copy dw dw-filter"></i> Lọc
                        </a>
                        <div class="dropdown-menu dropdown-menu-left" style="">
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#Modal_filter_admin_roles">
                                Chức vụ
                            </a>
                        </div>
                    </div>
                </div>
                @if (count($all_admin) > 0)
                    <div class="content_print_pdf_product ml-10">
                        <form action="{{ URL::to('admin/print_pdf_admin') }}" method="post">
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
            <div class="col-sm-12 col-md-6">

            </div>
        </div>
        <div class="center">

        </div>
        <div class="content_find_admin">
            @if (count($all_admin) > 0)
                <div class="center">
                    Tìm thấy
                    <span style="color: blue"> {{ count($all_admin) }} </span>
                    kết quả phù hợp
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Họ Và Tên</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Chức Vụ</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày Sinh</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Điện Thoại</th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsign="AZ">Email</th>
                                    @hasrole('admin')
                                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Thao Tác</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody class="content_find_admin">
                                @php
                                    $stt = 0;
                                @endphp
                                @foreach ($all_admin as $ad)
                                    @php
                                        $stt++;
                                    @endphp
                                    <tr role="row" class="odd">
                                        <td>{{ $stt }}</td>
                                        <td>
                                            <div class="name-avatar d-flex align-items-center">
                                                <div class="avatar mr-2 flex-shrink-0">
                                                    <img src="{{ asset('public/upload/' . $ad->avt) }}" class="border-radius-100 shadow" style="width: 50px; height: 50px;" alt="">
                                                </div>
                                                <div class="txt">
                                                    <div class="weight-600">{{ $ad->admin_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($ad->name == 'admin')
                                                Quản trị viên
                                            @elseif($ad->name == 'manager')
                                                Nhân viên quản lý
                                            @elseif($ad->name == 'employee')
                                                Nhân viên
                                            @elseif($ad->name == 'delivery')
                                                Nhân viên giao hàng
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($ad->admin_birthday)) }}
                                        </td>
                                        <td>{{ $ad->admin_phone }}</td>
                                        <td>{{ $ad->admin_email }}</td>
                                        @hasrole('admin')
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                        <i class="dw dw-more"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                        <a class="dropdown-item" href="{{ URL::to('admin/view_profile/' . $ad->admin_id) }}"><i class="dw dw-eye"></i>Thông tin cá nhân</a>
                                                        <a class="dropdown-item" href="{{ URL::to('admin/update_admin/' . $ad->admin_id) }}"><i class="dw dw-edit2"></i>Chỉnh Sửa</a>

                                                        @if (Session::get('admin_id') != $ad->admin_id)
                                                            <a class="dropdown-item" href="{{ URL::to('admin/delete_when_find/' . $ad->admin_id) }}"><i class="dw dw-delete-3"></i>Xóa</a>
                                                        @endif

                                                    </div>
                                                </div>
                                            </td>
                                        @endhasrole
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
{{-- sort table --}}
<script src="{{ asset('public/back_end/sort_table/Scripts/bootstrap-sortable.js') }}"></script>
