<div class="row">
    <div class="col-12 table-responsive">
        <form class="form_checkbox_discount_product">
            @csrf
            <table class="data-table table table-hover multiple-select-row nowrap no-footer dtr-inline sortable"
                id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                <thead>
                    <tr role="row">
                        <th class="dt-body-center" rowspan="1" colspan="1" aria-label="" data-defaultsort="disabled">
                            <div class="dt-checkbox">
                                <input type="checkbox" class="checkAll" name="select_all" id="example-select-all">
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </th>
                        <th class="table-plus datatable-nosort sorting_asc" rowspan="1" colspan="1"
                            aria-label="Name" data-defaultsort="disabled">Hình Ảnh</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1" data-defaultsign="AZ">Tên Sản Phẩm</th>
                        {{-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                            colspan="1">Đơn vị tính</th> --}}

                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1">Giá</th>
                        <th class="sorting text-center" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                        colspan="1">Số Lượng Trong Kho</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($products as $product)
                    <tr>
                        <td class=" dt-body-center" tabindex="0">
                            <div class="dt-checkbox">
                                <input type="checkbox" class="check" name="Product[]" value="{{ $product->product_name }}">
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td class="table-plus" tabindex="0">
                            <div class="da-card box-shadow" style="height: 50px; width: 50px">
                                <div class="da-card-photo">
                                    <img src="{{ asset('public/upload/' . $product->product_image) }}" alt="hình ảnh"
                                        srcset="" style="height: 50px; width: 50px">
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ URL::to('admin/view_detail_product/'.$product->product_id) }}">{{ $product->product_name }}</a>
                        </td>
                        <td>
                            {{ number_format($product->price, 0, ',', '.') }} vnđ
                        </td>
                        <td class="text-center">{{ $product->total_quantity_product }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </form>
    </div>
</div>
{{-- <script src="{{ asset('public/back_end/src/scripts/discount_custom.js') }}"></script> --}}
<script>
$(document).ready(function(){
    var arrCheck = [];
    //function
    function check_val_tag(){
        var val_discount_product_tag = $('.list_product_discount').val();
        if(val_discount_product_tag != ''){
            $('.content_val_tag_input').removeClass('op-0');
            $('.annouce_tag').addClass('dis_none');
            $('.content_btn_add_discount_product').removeClass('dis_none');
        }
        else{
            $('.content_val_tag_input').addClass('op-0');
            $('.annouce_tag').removeClass('dis_none');
            $('.content_btn_add_discount_product').addClass('dis_none');
        }
    }
    $('.check').change(function(){
        var isCheck = $(this).prop('checked');
        if(isCheck){
            $('.list_product_discount').tagsinput('add', $(this).val());
        }
        else{
            $('.list_product_discount').tagsinput('remove', $(this).val());
        }
        check_val_tag();
    });
    $('.form_checkbox_discount_product :checkbox').change(function(){
        arrCheck = [];
        var checkAll = $('.checkAll').prop('checked');
        if(checkAll){
            $('.check').prop('checked', true);
        }
        $("input:checkbox[name='Product[]']:checked").each(function() {
            arrCheck.push($(this).val());
        });
        for(var i = 0; i<arrCheck.length; i++){
            $('.list_product_discount').tagsinput('add', arrCheck[i]);
        }
        check_val_tag();
    });
    $('.checkAll').click(function(){
        var checkAll = $('.checkAll').prop('checked');
        if(!checkAll){
            $('.check').prop('checked', false);
            $('.list_product_discount').tagsinput('removeAll');
        }
        check_val_tag();
    });

    //
    $('.check').click(function(){
        var countCheck = $('.check').length === $('input[name="Product[]"]:checked').length;
        if(!countCheck){
            $('.checkAll').prop('checked', false);
        }
        else{
            $('.checkAll').prop('checked', true);
        }
    });
    $(".list_product_discount").on('itemRemoved', function(event) {
        check_val_tag();
    });
});
</script>
