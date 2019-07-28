<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        @yield('contentheader_title', 'Page Header here')
        <small>@yield('contentheader_description')</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin"><i class="fa fa-dashboard"></i> 管理后台</a></li>
        @yield('contentheader_menu')
        <li class="active">@yield('contentheader_here', '首页')</li>
    </ol>
</section>
