@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

    <div class="col-md-3">
    @include('web.account.menus')
    </div>

    <div class="col-md-9">

        <form class="form-horizontal ajax" action="{{ route('account.password') }}" method="post">

        <div class="modal-header">
            <h3 class="modal-title">
            <i class="fa fa-pencil"></i>
            <strong>{{ $pageTitle }}</strong>
            </h3>
        </div>
        <div class="modal-body form">
            <div class="form-body">
            <div class="form-group">
                <label class="col-md-3 control-label">
                @lang('account.new_password')
                </label>
                <div class="col-md-9">
                <input type="password" class="form-control input-large" id="inputPassword" name="password">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label">
                @lang('account.password_confirm')
                </label>
                <div class="col-md-9">
                <input type="password" class="form-control input-large" id="inputPassword2" name="password_confirmation">
                </div>
            </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" role="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> @lang('web.submit')
            </button>
            <a href="javascript:history.back()" class="btn btn-default">
            <i class="fa fa-times"></i> @lang('web.back')
            </a>
        </div>
        </form>

    </div>

@endsection
