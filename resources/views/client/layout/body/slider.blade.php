<link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/slider.css') }}">
<div class="content-sider">
    <div class="container">
        {{-- content slider laptop --}}
        <div class="container-slider">
            <div class="slider--box1">
                <div class="center">
                    <div class="slider">
                        @php
                            $all_slider = App\Http\Controllers\SliderController::show_slider();
                        @endphp
                        <ul>
                            @if (count($all_slider) > 0)
                                @foreach ($all_slider as $slider)
                                    <li><img src="{{ asset('public/upload/' . $slider->slider_image) }}" /></li>
                                @endforeach
                            @else
                                <li><img src="{{ asset('public/upload/no-image-banner.jpg') }}" /></li>
                                <li><img src="{{ asset('public/upload/no-image-banner.jpg') }}" /></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="space"></div>
            <div class="slider--box2">
                <div class="slider--box2--kotak mb-2">
                    <img src="{{ asset('public/upload/banner-right1.jpg') }}" alt="">
                </div>
                <div class="slider--box2--kotak">
                    <img src="{{ asset('public/upload/banner-right2.jpg') }}" alt="">
                </div>
            </div>
            <div class="clear"></div>
        </div>

        {{-- content slider mobile --}}
    </div>
</div>
<script src="{{ asset('public/font_end/assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('public/font_end/custom_ui/js/slider_js.js') }}"></script>
