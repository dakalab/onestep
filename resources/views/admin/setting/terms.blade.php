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
<div class="row"><div class="col-xs-12">

<form class="form-horizontal ajax validator" action="{{ url('/admin/setting/terms') }}" method="post">
    <div class="modal-body form">
        <div class="form-body">
            <div class="form-group">
                <textarea name="terms" id="editor">
                {{ $terms }}
                </textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" role="submit" class="btn btn-primary">
        <i class="fa fa-check"></i> 保存
        </button>
    </div>
</form>
@endsection

@section('script-init')
$(function () {
  CKEDITOR.replace('editor')
})
@endsection
