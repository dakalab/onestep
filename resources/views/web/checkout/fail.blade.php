@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')
<div id="content" class="row">
    <h1>@lang('checkout.your_order_is'){{ $status }}!</h1>
    @lang('checkout.goto_account')
    <div class="buttons">
        <div class="pull-right"><a href="/" class="btn btn-primary">@lang('checkout.continue')</a></div>
    </div>
</div>
@endsection
