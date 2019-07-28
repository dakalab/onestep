@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="col-md-3">
@include('web.account.menus')
</div>

<div class="col-md-9">

    <form class="form-horizontal ajax" action="{{ route('account.edit') }}" method="post">

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
                    @lang('account.email')
                    </label>
                    <div class="col-md-9">
                    <p class="form-control-static">
                    {{ $user->email }}
                    </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('account.name')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" id="inputName" name="name" value="{{ $user->name }}">
                    </div>
                </div>
            </div> <!-- form-body -->
        </div> <!-- modal-body -->

        <div class="modal-footer">
            <button type="submit" role="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> @lang('web.submit')
            </button>
            <a href="javascript:history.back()" class="btn btn-default">
            <i class="fa fa-times"></i> @lang('web.back')
            </a>
        </div>

    </form>

</div> <!-- col-md-9 -->

@endsection
