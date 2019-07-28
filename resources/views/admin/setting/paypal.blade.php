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
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-sandbox" data-toggle="tab" aria-expanded="true">Sandbox</a></li>
        <li><a href="#tab-production" data-toggle="tab" aria-expanded="false">Production</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tab-sandbox">
            @include('admin.setting.paypal_form', ['env' => 'sandbox', 'setting' => $sandbox])
        </div>
        <div class="tab-pane" id="tab-production">
            @include('admin.setting.paypal_form', ['env' => 'production', 'setting' => $production])
        </div>
    </div> <!-- tab-content -->
</div></div>
@endsection
