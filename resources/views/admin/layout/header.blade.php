<div class="header">
    {{-- SEARCH --}}
    @include('admin.layout.header.search')
    <div class="header-right">
        {{-- SETTING LATOUT --}}
        @include('admin.layout.header.setting_layout')

        {{-- NOTIFICATION --}}
        @include('admin.layout.header.notification')

        {{-- USER INFO --}}
        @include('admin.layout.header.user_info')

        <div class="github-link">
            <a href="https://github.com/dropways/deskapp" target="_blank"><img src="vendors/images/github.svg" alt=""></a>
        </div>
    </div>
</div>
