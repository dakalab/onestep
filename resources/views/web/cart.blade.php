@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="row">

    <h2 style="margin-top:-10px">{{ $pageTitle }} (@lang('cart.total'): {{ Cart::totalMoney() }})</h2>

    <h4>@lang('cart.warranty')</h4>

    <div class="row" style="display:flex;">
        <div class="text-center hidden-xs hidden-sm col-md-2 table-cell">@lang('cart.image')</div>
        <div class="text-left col-md-4 col-xs-8 table-cell">@lang('cart.product_name')</div>
        <div class="text-left hidden-xs hidden-sm col-md-1 table-cell">@lang('cart.sku')</div>
        <div class="text-left col-md-2 col-xs-4 table-cell">@lang('cart.quantity')</div>
        <div class="text-right hidden-xs hidden-sm col-md-1 table-cell">@lang('cart.price')</div>
        <div class="text-right hidden-xs hidden-sm col-md-2 table-cell">@lang('cart.subtotal')</div>
    </div>

    @if (count($items))
    @foreach ($items as $item)
    <div class="row" style="display:flex;">
        <div class="text-center hidden-xs hidden-sm col-md-2 table-cell">
            <a href="{{ $item->product->url() }}">
            <img src="{{ $item->product->mainPhoto() }}" alt="{{ $item->product->name }}" title="{{ $item->product->name }}" class="img-thumbnail cart-item">
            </a>
        </div>
        <div class="text-left col-md-4 col-xs-8 table-cell">
            <a href="{{ $item->product->url() }}">{{ $item->product->name }}</a>
            @foreach ($item->product->getAttributeGroup() as $k => $v)
            <br><small>{{ $k }}: {{ implode(', ', $v) }} </small>
            @endforeach
        </div>
        <div class="text-left hidden-xs hidden-sm col-md-1 table-cell">{{ $item->product->sku }}</div>
        <div class="text-left col-md-2 col-xs-4 table-cell">
        <form action="{{ route('cart.update') }}" method="post" class="ajax">
            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
            <div class="input-group btn-block" style="max-width: 200px;">
                <input type="text" name="quantity" value="{{ $item->quantity }}" size="1" class="form-control">
                <span class="input-group-btn">
                    <!--button title="@lang('cart.update_quantity')" type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i></button-->
                    <ajax-link title="@lang('cart.remove_item')" msg="@lang('cart.confirm_remove')" class="btn btn-danger" url="{{ route('cart.remove', ['product_id' => $item->product->id]) }}">
                    <i class="fa fa-times-circle"></i>
                    </ajax-link>
                </span>
            </div>
        </form>
        </div>
        <div class="text-right hidden-xs hidden-sm col-md-1 table-cell">{{ $item->product->money() }}</div>
        <div class="text-right hidden-xs hidden-sm col-md-2 table-cell">{{ $item->subtotal() }}</div>
    </div>
    @endforeach
    @else
    <div class="row">
        <h3 class="text-danger text-center">@lang('cart.empty_cart')</h3>
    </div>
    @endif

    <div class="buttons clearfix">
        <div class="pull-left"><a href="javascript:history.back()" class="btn btn-default">@lang('cart.continue')</a></div>
        @if (count($items))
        <div class="pull-right"><a href="{{ route('checkout') }}" class="btn btn-primary">@lang('web.checkout')</a></div>
        @endif
    </div>
</div>

@endsection


@section('scripts')
@include('web.parts.scripts')

<script type="text/javascript">
$().ready( function () {
    $('input[name=quantity]').on('change', function() {
        $(this).parent().submit();
    })
})
</script>

@endsection
