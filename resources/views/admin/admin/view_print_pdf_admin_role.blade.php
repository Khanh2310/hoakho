<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .title{
            text-align: center;
            font-size: 20px;
            font-weight: bold

        }
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .table td, .table th {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="title">{{ $string_title }}</div>
    <table class="table table-bordered mt-20">
        <tr style="font-size: 15px">
            <th>STT</th>
            <th>Họ Và Tên</th>
            <th>Chức Vụ</th>
            <th>Ngày Sinh</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Địa Chỉ</th>
        </tr>
        @php
             $stt = 1;
        @endphp
        @foreach ($all_admin as $ad)
            <tr>
                <td>{{ $stt++ }}</td>
                <td>
                    {{ $ad->admin_name }}
                </td>
                <td style="width: 10%">
                    @if ($ad->name == 'admin')
                        Quản trị viên
                    @elseif($ad->name == 'manager')
                        Nhân viên quản lý
                    @elseif($ad->name == 'employee')
                        Nhân viên
                    @elseif($ad->name == 'delivery')
                        Nhân viên giao hàng
                    @endif
                </td>
                <td>
                    {{ date("d/m/Y", strtotime($ad->admin_birthday)) }}
                </td>
                <td>
                    {{ $ad->admin_phone }}
                </td>
                <td>
                    {{ $ad->admin_email }}
                </td>
                <td style="width: 20%">
                    {{ $ad->admin_address }}
                </td>

            </tr>
        @endforeach
    </table>
    <div class="row">
        <div class="" style="float: right">Ngày xuất file: {{ date("d/m/Y") }}</div>
    </div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
