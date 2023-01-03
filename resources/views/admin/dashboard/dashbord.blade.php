@extends('admin.layout_admin')
@section('container')
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    @if (session('no_permission'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('no_permission') }}
        </div>
    @endif
    {{-- load --}}
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset('public/upload/logo-flower.svg') }}" style="height: 200px; width: 350px" alt="">
            </div>
            <div class='loader-progress' id="progress_div">
                <div class='bar' id='bar1'>
                </div>
            </div>
            <div class='percent' id='percent1'>0%</div>
            <div class="loading-text">
                Đang Tải...
            </div>
        </div>
    </div>
    <div class="title pb-20">
        <h2 class="h3 mb-0">Trang Chủ</h2>
    </div>
    <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ count($all_customer) }}</div>
                        <div class="font-14 text-secondary weight-500">Khách Hàng</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-user1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ count($all_order) }}</div>
                        <div class="font-14 text-secondary weight-500">Đơn Hàng</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#9ae9f8">
                            {{-- <span class="icon-copy ti-heart"></span> --}}
                            <span class="micon dw dw-file"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ count($all_product) }}</div>
                        <div class="font-14 text-secondary weight-500">Sản Phẩm</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#8bc6f2">
                            {{-- <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i> --}}
                            <span class="micon dw dw-inbox-4"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ number_format($revenue, 0, ',', '.') }}₫</div>
                        <div class="font-14 text-secondary weight-500">Doanh Thu</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="rgb(52, 238, 152)">
                            <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- CULUMN CHART --}}
        <div class="col-lg-7">
            <div class="card-box mb-30" style="position: relative;">
                <div class="d-flex flex-wrap justify-content-between pl-20 pt-20 pr-20">
                    <div class="h6" id="title_chart_culumn">
                        Đồ Thị Biểu Diễn Đơn Hàng RADIUS Hoa Khô {{ $year }}
                    </div>
                    <div class="form-group">
                        @php
                            $current_year = date('Y');
                        @endphp
                        <select class="form-control form-control-sm selectpicker" id="select_year_filter_order_dashboard">
                            @for ($i = $current_year; $i >= $current_year - 5; $i--)
                                <option value="{{ $i }}">Năm {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div id="chart3" class="pl-20 pr-20 pb-20"></div>
            </div>
        </div>
        {{-- INFO RELATE --}}
        <div class="col-lg-5">
            <div class="card-box pd-20" style="position: relative; height: 448px">
                <div class="d-flex justify-content-between">
                    <div class="h5 mb-0">Thông Số Khác</div>
                </div>
                <div id="chart9" class="pt-30"></div>
            </div>
        </div>
    </div>
    {{-- AREA CHART --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box mb-30" style="position: relative;">
                <div class="d-flex flex-wrap justify-content-between pd-20">
                    <div class="h6" id="title_chart_area">
                        Đồ Thị Biểu Diễn Doanh Thu RADIUS Hoa Khô {{ $year }} (Tổng Doanh Thu {{ $total_revenue_year }})
                    </div>
                    <div class="form-group">
                        <select class="form-control form-control-sm selectpicker" id="select_year_filter_revenue_dashboard">
                            @for ($i = $current_year; $i >= $current_year - 5; $i--)
                                <option value="{{ $i }}">Năm {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div id="chart2" class="pd-10"></div>
            </div>
        </div>
    </div>
    {{-- view top --}}
    <div class="row">
        @if (count($topCustomerBuy) > 0)
            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px">
                    <div class="d-flex justify-content-between pb-10">
                        <div class="h5 mb-0">Khách Hàng Mua Nhiều</div>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" data-color="#1b3133" href="#" role="button" data-toggle="dropdown" style="color: rgb(27, 49, 51);">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                <a class="dropdown-item" href="{{ URL::to('admin/all_customer') }}"><i class="dw dw-eye"></i>
                                    Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-list">
                        <ul>
                            @php
                                $top = 1;
                            @endphp
                            @foreach ($topCustomerBuy as $customer)
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="name-avatar d-flex align-items-center pr-2">
                                        <a href="{{ URL::to('admin/detail_customer/' . $customer->customer_id) }}" class="d-flex">
                                            <div class="avatar mr-2 flex-shrink-0">
                                                <img src="{{ asset('public/upload/' . $customer->customer_avt) }}" class="border-radius-100 box-shadow" style="width: 50px; height: 50px" alt="">
                                            </div>
                                            <div class="txt">
                                                <span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">1</span>
                                                <div class="font-14 weight-600">{{ $customer->username }}</div>

                                            </div>
                                        </a>
                                    </div>
                                    <div class="cta flex-shrink-0">
                                        <span class="btn btn-sm btn-outline-primary" style="font-size: 12px; width: 98px">
                                            {{ $customer->all_product_buy }} sản phẩm
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if (count($topProductRating) > 0)
            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px" style="position: relative;">
                    <div class="d-flex justify-content-between">
                        <div class="h5 mb-0">Sản Phẩm Đánh Giá Cao</div>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" data-color="#1b3133" href="#" role="button" data-toggle="dropdown" style="color: rgb(27, 49, 51);" aria-expanded="false">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list" style="">
                                <a class="dropdown-item" href="{{ URL::to('admin/all_product') }}">
                                    <i class="dw dw-eye"></i> Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-list">
                        <ul>
                            @php
                                $topRating = 1;
                            @endphp
                            @foreach ($topProductRating as $product)
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="name-avatar d-flex align-items-center pr-2">
                                        <div class="avatar mr-2 flex-shrink-0">
                                            <img src="{{ asset('public/upload/' . $product['product_image']) }}" class="border-radius-100 box-shadow" style="width: 50px; height: 50px" alt="">
                                        </div>
                                        <div class="txt">
                                            <span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">{{ $topRating++ }}</span>
                                            <div class="weight-600" style="font-size: 13px">
                                                {{ $product['product_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="cta flex-shrink-0">
                                        <span class="btn btn-sm btn-outline-secondary" style="font-size: 12px; width: 66px">
                                            {{ $product['avg_rating'] }}
                                            <i class="icon-copy fa fa-star" aria-hidden="true" style="color: #fddf0a; font-size: 18px"></i>
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @if (count($topProductSaled) > 0)
            <div class="col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p pd-20 min-height-200px" style="position: relative;">
                    <div class="d-flex justify-content-between">
                        <div class="h5 mb-0">Sản Phẩm Bán Nhiều</div>
                        <div class="dropdown">
                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" data-color="#1b3133" href="#" role="button" data-toggle="dropdown" style="color: rgb(27, 49, 51);" aria-expanded="false">
                                <i class="dw dw-more"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list" style="">
                                <a class="dropdown-item" href="{{ URL::to('admin/all_product') }}">
                                    <i class="dw dw-eye"></i> Chi Tiết
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-list">
                        <ul>
                            @php
                                $topSaled = 1;
                            @endphp
                            @foreach ($topProductSaled as $product)
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="name-avatar d-flex align-items-center pr-2">
                                        <div class="avatar mr-2 flex-shrink-0">
                                            <img src="{{ asset('public/upload/' . $product['product_image']) }}" class="border-radius-100 box-shadow" style="width: 50px; height: 50px" alt="">
                                        </div>
                                        <div class="txt">
                                            <span class="badge badge-pill badge-sm" data-bgcolor="#e7ebf5" data-color="#265ed7" style="color: rgb(38, 94, 215); background-color: rgb(231, 235, 245);">{{ $topSaled++ }}</span>
                                            <div class="weight-600" style="font-size: 13px">
                                                {{ $product['product_name'] }}</div>
                                        </div>
                                    </div>
                                    <div class="cta flex-shrink-0">
                                        <span class="btn btn-sm btn-outline-dark" style="font-size: 12px; width: 66px">
                                            {{ $product['count_product_saled'] }}
                                            sản phẩm
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{-- thống kê doanh thu --}}
    <!-- Simple Datatable start -->
    @if (count($statisticals_daily) > 0)
        <div class="content_filter_daily_order">
            <div class="card-box mb-30 content_filter_admin">
                <div class="row">
                    <div class="col-sm-12 col-md-8">
                        <div class="pd-20">
                            <h4 class="text-blue h4">Thống Kê Doanh Thu</h4>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 text-right">
                        <div class="content_print_pdf_product pd-20">
                            <form action="{{ URL::to('admin/print_pdf_dashbpard_revenue_daily') }}" method="post">
                                @csrf
                                {{-- type filter --}}
                                <input type="hidden" name="date_start" value="">
                                <input type="hidden" name="date_end" value="">
                                {{--  --}}
                                <button type="submit" class="btn btn-secondary">
                                    Xuất
                                    <img src="{{ asset('public/upload/pdf1.svg') }}" style="height: 25px" alt="">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="pb-20">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer ">
                        <div class="row">
                            <div class="col-sm-12 col-md-8 d-flex">
                                <div class="content-filter-date pd-10 d-flex">
                                    <div class="row">
                                        <div class="col-5">
                                            <input type="date" class="form-control" id="date_start_order_daily">
                                        </div>
                                        <div class="col-1" style="display: flex; align-items: center">
                                            <i class="icon-copy fa fa-long-arrow-right" aria-hidden="true"></i>
                                        </div>
                                        <div class="col-5">
                                            <input type="date" class="form-control" id="date_end_order_daily">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-4 text-right">
                                <h6 class="pd-10 pr-30 pt-30">
                                    Tổng doanh thu: {{ number_format($revenue, 0, ',', '.') }}₫
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ngày</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Số Lượng Đơn Hàng Đã Bán</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Tổng Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody class="content_find_admin">
                                        @php
                                            $stt = 0;
                                        @endphp
                                        @foreach ($statisticals_daily as $stati)
                                            <tr>
                                                <td>{{ ++$stt }}</td>
                                                <td>
                                                    {{ date('d/m/Y', strtotime($stati['date'])) }}
                                                </td>
                                                <td>
                                                    {{ $stati['count_order'] }}
                                                </td>
                                                <td>
                                                    {{ number_format($stati['total_receive'], 0, ',', '.') }}₫

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
                                        {!! $statisticals_daily->links() !!}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- SCRIPT --}}
    <script src="{{ asset('public/back_end/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
    <script>
        const arrSaled = [<?php if (isset($arrSaled)) {
    echo '"' . implode('","', $arrSaled) . '"';
} ?>];
        const arrRevenue = [<?php if (isset($arrRevenue)) {
    echo '"' . implode('","', $arrRevenue) . '"';
} ?>];
        const arrOrder = [<?php if (isset($arrOrder)) {
    echo '"' . implode('","', $arrOrder) . '"';
} ?>];
        const countAdmin = <?php if (isset($all_admin)) {
    echo count($all_admin);
} ?>;
        const countCate = <?php if (isset($all_category)) {
    echo count($all_category);
} ?>;
        const countStorage = <?php if (isset($all_storage)) {
    echo count($all_storage);
} ?>;
        const countSlider = <?php if (isset($all_slider)) {
    echo count($all_slider);
} ?>;
        const countVoucher = <?php if (isset($all_voucher)) {
    echo count($all_voucher);
} ?>;
        const total_revenue_year = '<?php if (isset($total_revenue_year)) {
    echo $total_revenue_year;
} ?>'
        //call function
        radiaBar(countAdmin, countCate, countStorage, countSlider, countVoucher);

        //ColumnChart
        var options3 = {
            series: [{
                name: 'Đã Bán',
                data: arrSaled,
            }, {
                name: 'Đơn Hàng',
                data: arrOrder
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false,
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            },
            yaxis: {
                title: {
                    text: ''
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "" + val + ""
                    }
                }
            }
        };
        var chart_culumn = new ApexCharts(document.querySelector("#chart3"), options3);
        chart_culumn.render();

        // AreaChart
        var options2 = {
            // title: {
            //     text: total_revenue_year,
            //     align: 'center',
            //     style: {
            //         fontSize: "16px",
            //         fontWeight:'500'
            //     }
            // },
            series: [{
                name: 'Doanh Thu',
                data: arrRevenue
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false,
                }
            },
            grid: {
                show: false,
                padding: {
                    left: 0,
                    right: 0
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: [
                    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5',
                    'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10',
                    'Tháng 11', 'Tháng 12'
                ],
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "" + formatNumber(val) + "₫"
                    }
                },
            },
        };
        var chart_area = new ApexCharts(document.querySelector("#chart2"), options2);
        chart_area.render();

        // jquery
        $('#select_year_filter_order_dashboard').change(function() {
            let year = $('#select_year_filter_order_dashboard').val();
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: 'admin/filer_year_order_dashboard',
                method: 'post',
                dataType: 'JSON',
                data: {
                    _token: _token,
                    year: year,
                },
                success: function(data) {
                    chart_culumn.updateSeries([{
                        name: 'Đã Bán',
                        data: data[0],
                    }, {
                        name: 'Đơn Hàng',
                        data: data[1]
                    }]);
                    $('#title_chart_culumn').html('Đồ Thị Biểu Diễn Đơn Hàng RADIUS Hoa Khô ' + year);
                }
            });
        });
        $('#select_year_filter_revenue_dashboard').change(function() {
            let year = $('#select_year_filter_revenue_dashboard').val();
            let _token = $('input[name="_token"]').val();
            $.ajax({
                url: 'admin/filer_year_revenue_dashboard',
                method: 'post',
                dataType: 'JSON',
                data: {
                    _token: _token,
                    year: year,
                },
                success: function(data) {
                    chart_area.updateSeries([{
                        name: 'Doanh Thu',
                        data: data[0]
                    }]);
                    $('#title_chart_area').html('Đồ Thị Biểu Diễn Doanh Thu RADIUS Hoa Khô ' + year + ' (Tổng Doanh Thu ' + data[1] + ')');
                }
            });
        });

        // function
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
        }

        function radiaBar(countAdmin, countCate, countStorage, countSlider, countVoucher) {
            var options9 = {
                series: [countAdmin, countStorage, countCate, countSlider, countVoucher],
                chart: {
                    height: 390,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 0,
                        startAngle: 0,
                        endAngle: 270,
                        hollow: {
                            margin: 5,
                            size: '60%',
                            background: 'transparent',
                            image: undefined,
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                show: false,
                            }
                        }
                    }
                },
                colors: ['#1ab7ea', '#0084ff', '#39539E', '#0077B5', '#34ee98'],
                labels: ['Nhân Viên', 'Kho', 'Danh Mục', 'Slider', 'Voucher'],
                legend: {
                    show: true,
                    floating: true,
                    fontSize: '12px',
                    position: 'left',
                    offsetX: 40,
                    offsetY: 15,
                    labels: {
                        useSeriesColors: true,
                    },
                    markers: {
                        size: 0
                    },
                    formatter: function(seriesName, opts) {
                        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
                    },
                    itemMargin: {
                        vertical: 3
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            show: false
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#chart9"), options9);
            chart.render();
        }
    </script>
@endsection
