
    //ADD ADRESS ADMIN
    $('#city_add_trans').change(function(){
        var city = $('#city_add_trans').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'load_district',
            method: 'POST',
            data: {
                city: city,
                _token: _token
            },
            success: function (data) {
                $('#district_add_trans').html(data);
            }
        });
    });
    $('#district_add_trans').change(function(){
        var district = $('#district_add_trans').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: 'load_ward',
            method: 'POST',
            data: {
                district: district,
                _token: _token
            },
            success: function (data) {
                $('#ward_add_trans').html(data);
            }
        });
    });



