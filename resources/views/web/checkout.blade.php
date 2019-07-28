@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="row">
    <div class="panel-group" id="accordion">

        <div class="panel panel-default">
            @include('web.checkout.step1')
        </div> <!-- panel -->

        <div class="panel panel-default">
            @include('web.checkout.step2')
        </div>

        <div class="panel panel-default">
            @include('web.checkout.step3')
        </div> <!-- panel -->

        <div class="panel panel-default">
            @include('web.checkout.confirm')
        </div> <!-- panel -->

        <div class="panel panel-default">
            @include('web.checkout.pay')
        </div> <!-- panel -->
    </div> <!-- panel-group -->
</div>

@endsection

@section('scripts')
@include('web.parts.scripts')
<script type="text/javascript">
$().ready( function () {
    $('input[name=address_option]').on('change', function() {
        if (this.value == 'new') {
            $('#address-existing').hide()
            $('#address-new').show()
        } else {
            $('#address-existing').show()
            $('#address-new').hide()
        }
    })

    @if (session('step') == 5 && $order)
        @include('web.parts.paypal', ['order' => $order])
    @endif
})
</script>
@endsection
