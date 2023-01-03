@if (count($history_price) > 0)
    <div class="pd-20 card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">Lịch Sử Giá Sản Phẩm -"{{ $product->product_name }}" {{ $string_title }}</h4>
        </div>
        <div class="row">
            <div class="content_filter pd-10 ml-10">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="icon-copy dw dw-filter"></i> Lọc
                    </a>
                    <div class="dropdown-menu dropdown-menu-left" style="">
                        <a class="dropdown-item" href="#" data-toggle="modal"
                        data-target="#Modal_filter_price_product_history">Thời gian cập nhật giá sản phẩm </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-20">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                <div class="row">
                    <div class="col-12 table-responsive">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Tên Sản Phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Ngày Cập Nhật</th>
                                <th scope="col" class="center">Trạng Thái</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $stt=1;
                                @endphp
                                @foreach ($history_price as $price)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $price->product_name }}</td>
                                    <td>{{ number_format($price->price, 0, ',', '.') }}₫</td>
                                    <td>{{ date("d-m-Y H:i", strtotime($price->updated_at)) }}</td>
                                    <td class="center">
                                        @if ($price->status == 1)
                                            <span class="badge badge-success">Mới</span>
                                        @else
                                            <span class="badge badge-secondary">Cũ</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="center">
        Không tìm thấy kết quả nào
    </div>
@endif
