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

<form class="form-horizontal ajax validator" action="{{ url('/admin/setting/tracking') }}" method="post">
    <div class="modal-body form">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">
                Name
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="name" value="{{ object_get($setting, 'name') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Address
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="address" value="{{ object_get($setting, 'address') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Company
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="company" value="{{ object_get($setting, 'company') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Phone
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="phone" value="{{ object_get($setting, 'phone') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Fax
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="fax" value="{{ object_get($setting, 'fax') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Postcode
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="postcode" value="{{ object_get($setting, 'postcode') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" role="submit" class="btn btn-primary">
        <i class="fa fa-check"></i> 保存
        </button>
    </div>
</form>

</div></div>
@endsection
