@extends('admin.layout_admin')
@section('container')
<style>
    .dis_ble{
        pointer-events: none;
        cursor: no-drop;
        opacity: 0.7;
    }
</style>
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Phân quyền</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        {{-- Message  --}}
        @if (session('permission_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('permission_success') }}
            </div>
        @endif
        {{--  --}}
        <div class="pd-20 card-box mb-30">
            <div class="pd-20">
                <h4 class="text-blue h4">Phân Quyền</h4>
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_3_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="row">
                        <div class="col-12">
                            <table class="dtr-inline table table-bordered" style="margin-right: 10px">
                                <thead style="text-align: center">
                                    <tr role="row">
                                        <th rowspan="2" valign="middle">STT</th>
                                        <th rowspan="2">Họ Và Tên</th>
                                        <th colspan="4">Quyền</th>
                                    </tr>
                                    <tr>
                                        <th>Nhân Viên</th>
                                        <th>Nhân Viên Giao Hàng</th>
                                        <th>Nhân Viên Quản Lý</th>
                                        <th>Quản Trị Hệ Thống</th>
                                        @hasrole(['admin'])
                                        <th></th>
                                        @endhasrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stt=0;
                                    @endphp
                                    @foreach ($admin as $ad)
                                        @php
                                            $stt++;
                                        @endphp
                                        <form action="{{ URL::to('admin/assign_roles') }}" method="post">
                                            @csrf
                                            <tr>
                                                <td style="text-align: center">{{ $stt }}</td>
                                                <td>
                                                    {{ $ad->admin_name }}
                                                    <input type="hidden" name="admin_email"
                                                        value="{{ $ad->admin_email }}">
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="checkbox" name="employee"
                                                        {{ $ad->hasRole('employee') ? 'checked' : '' }}
                                                        style="width: 20px; height: 20px;"
                                                        class="checkbox employee employee_{{ $ad->admin_id }}"
                                                        data-id = "{{ $ad->admin_id }}"
                                                        >
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="checkbox" name="delivery"
                                                        {{ $ad->hasRole('delivery') ? 'checked' : '' }}
                                                        style="width: 20px; height: 20px;"
                                                        class="checkbox"  data-id = "{{ $ad->admin_id }}"
                                                        >
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="checkbox" name="manager"
                                                        {{ $ad->hasRole('manager') ? 'checked' : '' }}
                                                        style="width: 20px; height: 20px;"
                                                        class="checkbox manager manager_{{ $ad->admin_id }}"
                                                        data-id = "{{ $ad->admin_id }}"
                                                        >
                                                </td>
                                                <td style="text-align: center">
                                                    <input type="checkbox" name="admin"
                                                        {{ $ad->hasRole('admin') ? 'checked' : 'disabled="disabled"' }}
                                                        style="width: 20px; height: 20px;pointer-events: none;cursor: no-drop;">
                                                </td>
                                                @hasrole(['admin'])
                                                <td style="text-align: center">
                                                    @if(Auth::user()->admin_id == 1)
                                                        @if(Auth::user()->admin_id == $ad->admin_id)
                                                            <button type="submit" class="btn disabled" disabled data-bgcolor="#1da1f2"
                                                            data-color="#ffffff"
                                                            style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);cursor: no-drop;"><i class="fa fa-dropbox"></i> Phân Quyền</button>
                                                        @else
                                                            <button type="submit" class="btn dis_ble btn_permission_{{ $ad->admin_id }}" data-bgcolor="#1da1f2"
                                                            data-color="#ffffff"
                                                            style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);"><i class="fa fa-dropbox"></i> Phân Quyền</button>
                                                        @endif
                                                    @endif
                                                </td>
                                                @endhasrole
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">

                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_3_paginate">
                                <ul class="pagination">
                                    {!! $admin->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.employee').click(function() {
                let admin_id = $(this).attr('data-id');
                $('.manager_'+admin_id).prop('checked', false);
            })
            $('.manager').click(function() {
                let admin_id = $(this).attr('data-id');
                $('.employee_'+admin_id).prop('checked', false);
            });
            $('.checkbox').change(function(){
                let admin_id = $(this).attr('data-id');
                $('.btn_permission_'+admin_id).removeClass('dis_ble');
            })
        });
    </script>
@endsection
