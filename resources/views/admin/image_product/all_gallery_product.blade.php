@extends('admin.layout_admin')
@section('container')
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="title">
                    <h4>
                        Danh Sách Hình Ảnh Của
                        @foreach ($all_product as $product)
                            @if($product->product_id == $prod_id)
                                {{ $product->product_name }}
                            @endif
                        @endforeach
                    </h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách hình ảnh</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-3 col-sm-12 text-right">
                @hasrole(['admin','manager'])
                <button class="btn color-btn-them" data-toggle="modal" data-target="#modal_add_image">
                    <i class="icon-copy fa fa-plus" aria-hidden="true"></i>
                </button>
                @endhasrole
            </div>
        </div>
    </div>
        @if (session('add_product_image_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('add_product_image_success') }}
            </div>
        @endif
        @if (session('delete_product_image_success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('delete_product_image_success') }}
            </div>
        @endif
        @if ($errors->has('image'))
            <div class="alert alert-danger alert-dismissible mt-1">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ $errors->first('image') }}
            </div>
        @endif
    <div class="gallery-wrap">
        @if (count($all_image) > 0)
            <ul class="row">
                @foreach ($all_image as $image)
                    <li class="col-lg-4 col-md-6 col-sm-12">
                        <div class="da-card box-shadow" >
                            <div class="da-card-photo">
                                <img src="{{ asset('public/upload/'.$image->image) }}" alt="" style="width: 320px; height: 269px">
                                <div class="da-overlay">
                                    <div class="da-social">
                                    <h5 class="mb-10 color-white pd-20">{{ date("d-m-Y H:i", strtotime($image->create_at))   }}</h5>
                                        <ul class="clearfix">
                                            <li><a href="{{ asset('public/upload/'.$image->image) }}" data-fancybox="images"><i class="fa fa-picture-o"></i></a></li>
                                            @hasrole(['admin'])
                                            <li>
                                                <a class="soft_delete_image_product_class" data-id = "{{ $image->image_id }}" data-toggle="modal" data-target="#modal_delete_image" >
                                                    <i class="dw dw-delete-3"></i>
                                                </a>
                                            </li>
                                            @endhasrole
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="center">Chưa có hình ảnh nào</div>
        @endif

    </div>
    <div class="row mr-bt">
        <div class="col-sm-12 col-md-5">
            @hasrole(['admin'])
            <a href="{{ URL::to('admin/view_recycle_image_product/'.$prod_id) }}" class="btn color-btn-them ml-10"
                style="color: white"><i class="dw dw-delete-3"></i> Thùng Rác</a>
            @endhasrole
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">

            </div>
        </div>
    </div>
</div>
<!-- The Modal Add Image -->
<div class="modal fade" id="modal_add_image">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal body -->
        <form action="{{ URL::to('admin/process_add_image_product/'.$prod_id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="file_upload" onchange="return uploadhinh()">
                        <label class="custom-file-label" for="customFile">Chọn hình ảnh</label>
                    </div>
                    <div class="da-card box-shadow mt-3">
                        <div class="da-card-photo">
                            <img src="" class="op-0" alt="hình ảnh" id="image_upload" height="100px" width="100px">
                            <div class="da-overlay">
                                <div class="da-social">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn color-btn-them" value="Thêm">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </form>
      </div>
    </div>
  </div>

<!-- The Modal Delete Image -->
<div class="modal fade" id="modal_delete_image">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thông Báo</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         Bạn muốn xóa hình ảnh này ?
         <form action="{{ URL::to('admin/delete_soft_image_product') }}" method="post" name="form_soft_delete_image_product">
            @csrf
            <input type="hidden" name="image_id" class="id_delete_image_product">
         </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button class="btn btn-danger btn_delete_soft_image_product">Xóa</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
        </div>

      </div>
    </div>
  </div>
@endsection
