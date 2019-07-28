@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

    <div class="col-md-3">
    @include('web.account.menus')
    </div>

    <div class="col-md-9">
        <h1 class="text-center">@lang('account.hi') {{ Auth::user()->name }}, @lang('account.welcome')</h1>
    </div>

@endsection
