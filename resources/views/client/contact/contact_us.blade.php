@extends('client.layout_client')
@section('content_body')
    <link rel="stylesheet" href="{{ asset('public/font_end/custom_ui/css/custom_breadcrumb.css') }}">
    {{-- <div class="hero-section hero-background">
    <h1 class="page-title">Organic Fruits</h1>
</div> --}}
    <div class="container">
        <nav class="biolife-nav cus_breadcrumb nav-86px">
            <ul>
                <li class="nav-item"><a href="/" class="permal-link">Home</a></li>
                <li class="nav-item"><span class="current-page">Liên hệ</span></li>
            </ul>
        </nav>
    </div>
    <div class="page-contain contact-us">
        <div id="main-content" class="main-content">
            <div class="wrap-map biolife-wrap-map" id="map-block">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31417.309556360866!2d105.89721436492562!3d10.167346326970987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0790586f78b47%3A0xfeb0e853e3fff96f!2zUGjDuiBRdeG7m2ksIExvbmcgSOG7kywgVsSpbmggTG9uZywgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1637899499091!5m2!1svi!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

@endsection
