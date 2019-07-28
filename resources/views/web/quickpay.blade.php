@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-6">
        <h4>@lang('quickpay.sign_in')</h4>

        <login-form name="{{ config('auth.providers.users.field','email') }}"
                    domain="{{ config('auth.defaults.domain','') }}"></login-form>

        @include('auth.partials.social_login')

        <a href="{{ url('/password/reset') }}">@lang('adminlte_lang::message.forgotpassword')</a><br>
        <a href="{{ url('/register') }}" class="text-center">@lang('adminlte_lang::message.registermember')</a>
    </div>
    <div class="col-md-6">
        <h4>@lang('quickpay.pay')</h4>
        <div id="paypal-button"></div>
    </div>
</div>
@endsection

@section('scripts')
@include('web.parts.scripts')
<script type="text/javascript">
$().ready( function () {
    @include('web.parts.paypal', ['order' => $order])
})
</script>
@endsection
