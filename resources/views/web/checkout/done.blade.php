@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')
<div id="content" class="row">
    @lang('checkout.done_header')
    @if (!Auth::guest())
    @lang('checkout.done_order')
    @endif
    @lang('checkout.done_tracking')
    @lang('checkout.done_help')
    <div class="buttons">
        <div class="pull-right"><a href="/" class="btn btn-primary">@lang('checkout.continue')</a></div>
    </div>
</div>
@endsection
