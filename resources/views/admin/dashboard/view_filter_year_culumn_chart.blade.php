<div id="chart_culumn" class="pl-20 pr-20 pb-20"></div>
<script src="{{ asset('public/back_end/src/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script>
    const arrSaled= [<?php if(isset($arrSaled)) echo '"'.implode('","',  $arrSaled ).'"' ?>];
    const arrOrder= [<?php if(isset($arrOrder)) echo '"'.implode('","',  $arrOrder ).'"' ?>];
    function ColumnChart(arrSaled,arrOrder){
        var options3 = {
            series: [
                {
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
                categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9','10','11','12'],
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
                    formatter: function (val) {
                        return "" + val + ""
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart_culumn"), options3);
        chart.render();
    }
</script>
