@extends('admin.layout_admin')
@section('container')
<div class="min-height-200px">
    <div class="page-header">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh sách bình luận chờ duyệt</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                </div>
            </div>
    </div>
    {{-- Message  --}}
    @if (session('accept_comment_success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('accept_comment_success') }}
        </div>
    @endif
    @if (session('accept_comment_error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('accept_comment_error') }}
        </div>
    @endif
    @if (session('unaccept_comment_success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('unaccept_comment_success') }}
        </div>
    @endif
    @if (session('unaccept_comment_error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('unaccept_comment_error') }}
        </div>
    @endif

    <!-- Simple Datatable start -->
    <div class="card-box mb-30 content_filter_comment">
        <div class="pd-20">
            <h4 class="text-blue h4">Danh Sách Bình Luận Chờ Duyệt</h4>
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
                        <div class="content_print_pdf_product ml-10">
                            <form action="{{ URL::to('admin/print_pdf_comment') }}" method="post">
                                @csrf
                                {{-- type filter --}}
                                    <input type="hidden" class="type_filter" name="type_filter" value="">
                                    <input type="hidden" class="level_filter" name="level_filter" value="">
                                    <input type="hidden" name="level_array" value="">
                                    <input type="hidden" name="price_filter_start" value="">
                                    <input type="hidden" name="price_filter_end" value="">
                                {{--  --}}
                                <button type="submit" class="btn btn-secondary">
                                    Xuất
                                    <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div id="DataTables_Table_0_filter" class="dataTables_filter">
                            <form action="">
                                @csrf
                                <label>Tìm Kiếm:<input type="search" class="form-control form-control-sm" id="find_comment_to_process" placeholder="Tìm Kiếm"
                                    aria-controls="DataTables_Table_0"></label>
                            </form>
                        </div>
                    </div>
                </div>
                @if (count($all_comment) > 0)
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
                                                            @foreach ($all_product as $product)
                                                                @if ($product->product_id == $comment->product_id)
                                                                    <img src="{{ asset('public/upload/'.$product->product_image) }}"
                                                                        style="width: 70px; height: 70px" alt="">
                                                                @endif
                                                            @endforeach
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
                                                            <a href="#" class="btn_open_modal_unaccep_comment" data-id='{{ $comment->comment_id }}' data-toggle="modal" data-target="#Modal_upaccep_comment">
                                                                <i class="icon-copy fi-x" style="color: red; font-size: 25px"></i>
                                                            </a>

                                                            <a href="#" class="btn_open_modal_accep_comment" data-id='{{ $comment->comment_id }}' data-toggle="modal" data-target="#Modal_accep_comment">
                                                                <i class="icon-copy fa fa-check" aria-hidden="true"
                                                                    style="color: rgb(16, 209, 32); font-size: 25px; padding-left: 5px"></i>
                                                            </a>

                                                        </td>

                                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="center">Không có bình luận nào đang chờ duyệt</div>
                @endif
            </div>
        </div>
    </div>
    @include('admin.comment.modal_filter_comment')
    <!-- The Modal accep comment -->
    <div class="modal fade" id="Modal_accep_comment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn muốn duyệt đánh giá này ?
                    <form action="{{ URL::to('admin/process_accep_comment') }}" method="post" name="form_accep_comment">
                        @csrf
                        <input type="hidden" class="id_accep_comment" name="comment_id" value="">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-danger btn_confirm_accep_comment">Duyệt</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal unaccep comment -->
    <div class="modal fade" id="Modal_upaccep_comment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông Báo</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn muốn xóa đánh giá này ?
                    <form action="{{ URL::to('admin/process_unaccep_comment') }}" method="post" name="form_unaccep_comment">
                        @csrf
                        <input type="hidden" class="id_unaccep_comment" name="comment_id" value="">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button class="btn btn-danger btn_confirm_unaccep_comment">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Thoát</button>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script>
$(document).ready(function(){
    $("#find_comment_to_process").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#table_content_comment_process tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endsection

