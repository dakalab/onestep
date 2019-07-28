<!DOCTYPE html>

<html lang="en">

@section('htmlheader')
    @include('web.parts.htmlheader')
@show

<body>

@if (config('google.tag'))
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={!! config('google.tag') !!}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

<div id="app" v-cloak>

    @include('web.parts.mainheader')

    <div class="container">
        @include('web.parts.breadcrumb')
        @yield('main-content')
    </div>

    @include('web.parts.footer')

</div>

@section('scripts')
    @include('web.parts.scripts')
@show

</body>
</html>
