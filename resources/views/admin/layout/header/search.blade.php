<style>
    @import 'https://fonts.googleapis.com/css?family=Open+Sans';

    #clock {
        align-items: center;
        -webkit-align-items: center;
        display: flex;
        display: -webkit-flex;
        /* height: 48px; */
        /* justify-content: space-around; */
        /* -webkit-justify-content: space-around; */
        left: calc(50% - 130px);
        /* position: absolute; */
        /* top: calc(50% - 61px); */
        width: 300px;
    }

    .unit {
        background: linear-gradient(#fff, #ffffff);
        border-radius: 15px;
        box-shadow: 0 0px 2px #334148;
        color: #334148;
        font-family: "Open Sans", sans-serif;
        font-size: 2em;
        height: 100%;
        line-height: 61px;
        margin: 0 5px;
        text-align: center;
        /* text-shadow: 0 2px 2px #fff; */
        width: 20%;
    }

</style>
<div class="header-left">
    <div id="clock">
        <p class="unit" id="hours"></p>
        <p class="unit" id="minutes"></p>
        <p class="unit" id="seconds"></p>
        <p class="unit" id="ampm"></p>
    </div>
</div>
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script>
    var $dOut = $('#date'),
        $hOut = $('#hours'),
        $mOut = $('#minutes'),
        $sOut = $('#seconds'),
        $ampmOut = $('#ampm');
    var months = [
        'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
    ];

    var days = [
        'Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'
    ];

    function update() {
        var date = new Date();

        var ampm = date.getHours() < 12 ?
            'AM' :
            'PM';

        var hours = date.getHours() == 0 ?
            12 :
            date.getHours() > 12 ?
            date.getHours() - 12 :
            date.getHours();

        var minutes = date.getMinutes() < 10 ?
            '0' + date.getMinutes() :
            date.getMinutes();

        var seconds = date.getSeconds() < 10 ?
            '0' + date.getSeconds() :
            date.getSeconds();

        var dayOfWeek = days[date.getDay()];
        var month = months[date.getMonth()];
        var day = date.getDate();
        var year = date.getFullYear();

        var dateString = dayOfWeek + ', ' + month + ' ' + day + ', ' + year;

        $dOut.text(dateString);
        $hOut.text(hours);
        $mOut.text(minutes);
        $sOut.text(seconds);
        $ampmOut.text(ampm);
    }

    update();
    window.setInterval(update, 1000);
</script>
