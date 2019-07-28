@extends('layouts.app')

@section('htmlheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_here')
{{ $pageTitle }}
@endsection

@section('main-content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">批量导入使用说明</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ul>
            <li>导入前请下载 <a href="/downloads/import.xlsx">商品导入模板</a></li>
            <li>SKU需保证唯一，SPU可以为空，如果SPU为空则会使用SKU填充</li>
            <li>导入是后台异步处理，请耐心等待处理结果</li>
        </ul>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">商品导入</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <ajax-upload url="{{ url('/admin/product/import') }}" filename="file"></ajax-upload>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

@endsection
