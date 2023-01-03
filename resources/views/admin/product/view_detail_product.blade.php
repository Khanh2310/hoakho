@extends('admin.layout_admin')
@section('container')
@php
    $price_discount = App\Http\Controllers\HomeClientController::check_price_discount($product->product_id);
    $info_rating_saled = App\Http\Controllers\HomeClientController::info_rating_saled($product->product_id);
@endphp
<div class="min-height-200px">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Chi Tiết Sản Phẩm</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ URL::to('admin/all_product') }}">Danh sách sản phẩm</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="blog-wrap">
        <div class="container pd-0">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="blog-detail card-box overflow-hidden mb-30">
                        <div class="blog-img">
                            <div class="content-image-deatail-product">
                                <img
                                class="img_detail_product"
                                src="{{ asset('public/upload/'.$product->product_image) }}"
                                alt=""
                                style="width: 100%;"
                                >
                            </div>
                        </div>
                        <div class="blog-caption">
                            <h4 class="mb-10">Mô tả ngắn sản phẩm</h4>
                           {!! $product->product_sort_desc !!}
                            <h5 class="mb-10">Mô tả sản phẩm</h5>
                            {!! $product->product_desc !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card-box mb-30">
                        <h5 class="pd-20 h5 mb-0">Thông Tin</h5>
                        <div class="latest-post">
                            <ul>
                                <li>
                                    <h4><a href="#">Tên sản phẩm</a></h4>
                                    <span>{{ $product->product_name }}</span>
                                </li>
                                <li>
                                    <h4><a href="#">Danh mục sản phẩm</a></h4>
                                    <span>
                                        @foreach ($all_cate as $cate)
                                            @if ($cate->cate_id == $product->category_id)
                                                {{ $cate->cate_name }}
                                            @endif
                                        @endforeach

                                    </span>
                                </li>
                                <li>
                                    <h4><a href="#">Giá sản phẩm</a></h4>
                                    <span>
                                        @if ($price_discount->percent_discount != 0)
                                            {{ number_format($price_discount->price_now, 0, ',', '.') }}₫
                                            <del class="ml-10">{{ number_format($price_discount->price_old, 0, ',', '.') }}₫</del>
                                            <span class="badge badge-danger">-{{ $price_discount->percent_discount }}%</span>
                                        @else
                                            {{ number_format($price_discount->price_now, 0, ',', '.') }}₫
                                        @endif
                                    </span>
                                </li>
                                <li>
                                    <h4><a href="#">Số lượng trong kho</a></h4>
                                    <span>{{ $product->total_quantity_product }}</span>
                                </li>
                                <li>
                                    <h4><a href="#">Đơn vị tính</a></a></h4>
                                    <span>
                                        @foreach ($all_unit as $unit)
                                            @if ($unit->unit_id == $product->unit_id)
                                                {{ $unit->unit_name }}
                                            @endif
                                        @endforeach
                                    </span>
                                </li>
                                <li>
                                    <h4><a href="#">Kho</a></h4>
                                    <span>
                                        @foreach ($all_storage as $storage)
                                            @if ($storage->storage_id == $product->storage_id)
                                                {{ $storage->storage_name }}
                                            @endif
                                        @endforeach
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-box mb-30">
                        <div class="latest-post">
                            <ul>
                                <li>
                                    <h4 class="d-flex">
                                        <a href="#" class="">Đã bán</a>
                                        <span class="ml-10">{{ $info_rating_saled->count_product_saled }}</span>
                                    </h4>
                                </li>
                                <li>
                                    <h4 class="d-flex">
                                        <a href="#" class="">Đánh giá</a>
                                        <span class="ml-10">{{ $info_rating_saled->avg_rating }}<i class="icon-copy fa fa-star" aria-hidden="true" style="color: #eded4e; font-size: 18px"></i></span>
                                    </h4>
                                </li>
                                <li>
                                    <h4 class="d-flex">
                                        <a href="#" class="">Bình luận</a>
                                        <span class="ml-10">{{ count($comment) }}</span>
                                    </h4>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-box overflow-hidden">
                        <h5 class="pd-20 h5 mb-0">Ngày Thêm Sản Phẩm</h5>
                        <div class="list-group">
                            <a href="#" class="list-group-item d-flex align-items-center justify-content-between">
                                {{ date("d-m-Y H:i", strtotime($product->create_at)) }}
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
