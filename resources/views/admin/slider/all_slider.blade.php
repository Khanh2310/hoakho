@extends('admin.layout_admin')
@section('container')
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách slider</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6 col-sm-12">
                    {{-- <div class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        January 2018
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">Export List</a>
                        <a class="dropdown-item" href="#">Policies</a>
                        <a class="dropdown-item" href="#">View Assets</a>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            @if (session('slider_status_unactive'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('slider_status_unactive') }}
                </div>
            @endif
        </div>
        <div class="card-box mb-30">
            @if (session('delete_slider'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('delete_slider') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('slider_status_active'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('slider_status_active') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('change_status_slider'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('change_status_slider') }}
                </div>
            @endif
        </div>

        <div class="card-box mb-30">
            @if (session('error_active_slider'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    @php
                        $storage_id_recycle = session('storage_id');
                    @endphp
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ session('error_active_slider') }}
                </div>
            @endif
        </div>

        <!-- Simple Datatable start -->
        <div class="card-box mb-30">
            <div class="row pd-20">
                <div class="col-10 pd-20">
                    <h4 class="text-blue h4">Danh Sách Slider</h4>
                </div>
            </div>
            <div class="pb-20">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                    <div class="content_find_storage">
                        <div class="col-12 table-responsive">
                            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid"
                                aria-describedby="DataTables_Table_0_info">
                                <thead>
                                    <tr role="row">
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" data-defaultsort="disabled">Hình Ảnh</th>
                                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Trạng Thái</th>
                                        <th class="datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Action" data-defaultsort="disabled">Xóa</th>
                                    </tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($all_slider as $slider)
                                        @php
                                            $stt++;
                                        @endphp

                                        <tr role="row" class="odd">
                                            <td>{{ $stt }}</td>
                                            <td>
                                                <img src="{{ asset('public/upload/' . $slider->slider_image) }}" style="width: 200px; height: 78px; border-radius: 2px;
                                                                    border: 1px solid #ecf0f4;" alt="hình ảnh" srcset="">
                                            </td>
                                            <td>
                                                @if ($slider->slider_status == 1)
                                                    <a href="{{ URL::to('admin/unactive_slider/' . $slider->slider_id) }}">
                                                        <span class="badge badge-success" style="width: 105px;">Bật/Tắt</span>
                                                    </a>
                                                @else
                                                    <a href="{{ URL::to('admin/active_slider/' . $slider->slider_id) }}">
                                                        <span class="badge badge-danger" style="width: 105px;">Bật/Tắt</span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="delete_slider" data-id="{{ $slider->slider_id }}" data-toggle="modal" data-target="#Modal_delete_slider" style="cursor: pointer">
                                                    <i class="icon-copy fa fa-close" aria-hidden="true" style="font-size: 25px; color: rgb(207, 51, 11)"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-5">
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    {!! $all_slider->links() !!}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="Modal_delete_slider">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Thông Báo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        Bạn có muốn xóa slider này ?
                        <form action="{{ URL::to('admin/process_delete_slider') }}" method="post" name="form_delete_slider">
                            @csrf
                            <input type="hidden" class="slider_id" name="slider_id" value="">
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button class="btn btn-danger btn_delete_slider">Xóa</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
        <script src="{{ asset('public/back_end/custom_slider/slider_js.js') }}"></script>
    @endsection
