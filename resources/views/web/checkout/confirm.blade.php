<div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-checkout-confirm" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="{{ $step == 4 ? 'true' : 'false' }}">@lang('checkout.step') 4: @lang('checkout.confirm_order') <i class="fa fa-caret-down"></i></a></h4>
</div>
<div class="panel-collapse collapse {{ $step == 4 ? 'in' : '' }}" id="collapse-checkout-confirm" aria-expanded="{{ $step == 4 ? 'true' : 'false' }}">
    <div class="panel-body">
    @if (session('address_id'))
    <form class="form-horizontal" action="{{ route('checkout.confirm') }}" method="post">
        @csrf

        <div class="row" style="display:flex;">
            <div class="text-center hidden-xs hidden-sm col-md-2 table-cell">@lang('cart.image')</div>
            <div class="text-left col-md-5 col-xs-9 table-cell">@lang('cart.product_name')</div>
            <div class="text-left hidden-xs hidden-sm col-md-1 table-cell">@lang('cart.sku')</div>
            <div class="text-left col-md-1 col-xs-3 table-cell">Qty.</div>
            <div class="text-right hidden-xs hidden-sm col-md-1 table-cell">@lang('cart.price')</div>
            <div class="text-right hidden-xs hidden-sm col-md-2 table-cell">@lang('cart.subtotal')</div>
        </div>

        <tbody>
        @foreach (Cart::getItems() as $item)
        <div class="row" style="display:flex;">
            <div class="text-center hidden-xs hidden-sm col-md-2 table-cell">
                <a href="{{ $item->product->url() }}">
                <img src="{{ $item->product->mainPhoto() }}" alt="{{ $item->product->name }}" title="{{ $item->product->name }}" class="img-thumbnail cart-item">
                </a>
            </div>
            <div class="text-left col-md-5 col-xs-9 table-cell">
                <a href="{{ $item->product->url() }}">{{ $item->product->name }}</a>
                @foreach ($item->product->getAttributeGroup() as $k => $v)
                <br><small>{{ $k }}: {{ implode(', ', $v) }} </small>
                @endforeach
            </div>
            <div class="text-left hidden-xs hidden-sm col-md-1 table-cell">{{ $item->product->sku }}</div>
            <div class="text-right col-md-1 col-xs-3 table-cell">{{ $item->quantity }}</div>
            <div class="text-right hidden-xs hidden-sm col-md-1 table-cell">{{ $item->product->money() }}</div>
            <div class="text-right hidden-xs hidden-sm col-md-2 table-cell">{{ $item->subtotal() }}</div>
        </div>
        @endforeach

        <div class="row" style="display:flex;">
            <div class="text-right col-md-10 col-xs-9 table-cell"><strong>@lang('cart.subtotal'):</strong></div>
            <div class="text-right col-md-2 col-xs-3 table-cell">{{ $total }}</div>
        </div>
        <div class="row" style="display:flex;">
            <div class="text-right col-md-10 col-xs-9 table-cell"><strong>@lang('checkout.free_shipping'):</strong></div>
            <div class="text-right col-md-2 col-xs-3 table-cell">{{ \Helper::money(0) }}</div>
        </div>
        <div class="row" style="display:flex;">
            <div class="text-right col-md-10 col-xs-9 table-cell"><strong>@lang('cart.total'):</strong></div>
            <div class="text-right col-md-2 col-xs-3 table-cell">{{ $total }}</div>
        </div>

        <p><strong>@lang('checkout.order_comment')</strong></p>
        <p>
            <textarea name="comment" rows="3" class="form-control"></textarea>
        </p>
        <div class="buttons clearfix">
            <div class="pull-right">
                <input type="submit" value="@lang('checkout.confirm_order')" id="button-confirm" class="btn btn-primary">
            </div>
        </div>
    </form>
    @else
    <div class="buttons clearfix">@lang('checkout.goto_step1')</div>
    @endif
    </div>
</div>
