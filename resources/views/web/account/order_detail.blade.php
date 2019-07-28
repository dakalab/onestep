@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="col-md-3">
@include('web.account.menus')
</div>

<div class="col-md-9">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-info-circle"></i> @lang('order.basic_info')</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>@lang('order.order_no')</th>
                    <th>@lang('order.order_time')</th>
                    <th>@lang('order.total')</th>
                    <th>@lang('order.paid')</th>
                    <th>@lang('web.status')</th>
                </tr>
                <tr>
                    <td>{{ $order->order_no }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->totalMoney() }}</td>
                    <td>{{ $order->paidMoney() }}</td>
                    <td>{!! $order->showStatus() !!}</td>
                </tr>
            </table>
            <p class="text-info"><b>@lang('order.comment'): </b> {{ $order->comment }}</p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-truck"></i> @lang('order.shipping') ({{ $order->shipping_method }})</h3>
        </div>
        <div class="panel-body">
            <p><b>@lang('account.name'):</b> {{ $order->firstname }} {{ $order->lastname }} </p>
            <p><b>@lang('address.phone'):</b> {{ $order->fullPhone() }}</p>
            <p><b>@lang('address.address'):</b> {{ $order->concatAddress() }}</p>
            <p><b>@lang('address.postcode'):</b> {{ $order->postcode }}</p>
            <p><b>@lang('address.company'):</b> {{ $order->company }}</p>
        </div>
    </div>

    @if (count($order->transactions))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-usd"></i> @lang('order.payment') ({{ $order->payment_method }})</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>@lang('order.trans_no')</th>
                    <th>@lang('order.trans_time')</th>
                    <th>@lang('order.amount')</th>
                </tr>
                @foreach ($order->transactions as $transaction)
                <tr>
                    <td>{{ $transaction->transaction_no }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->money() }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-gift"></i> @lang('order.product_list')</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover table-bordered table-striped">
                <tr>
                    <th>@lang('cart.product_name')</th>
                    <th>@lang('cart.sku')</th>
                    <th>@lang('cart.quantity')</th>
                    <th>@lang('cart.price')</th>
                    <th>@lang('cart.subtotal')</th>
                </tr>
                @if ($order->products->count())
                @foreach ($order->products as $product)
                <tr>
                    <td><a href="{{ $product->detail->url() }}" target="_blank">{{ $product->detail->name }}</a></td>
                    <td>{{ $product->detail->sku }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->money() }}</td>
                    <td>{{ $product->subtotal() }}</td>
                </tr>
                @endforeach
                @else
                <tr><td colspan=5>No records</td></tr>
                @endif
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b>@lang('cart.subtotal')</b></td>
                    <td>{{ $order->productMoney() }}</td>
                </tr>
            </table>
        </div>
    </div>

</div>

@endsection
