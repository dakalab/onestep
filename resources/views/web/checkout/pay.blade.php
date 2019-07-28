<div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-pay-order" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="{{ $step == 5 ? 'true' : 'false' }}">@lang('checkout.step') 5: @lang('checkout.pay_order') <i class="fa fa-caret-down"></i></a></h4>
</div>
<div class="panel-collapse collapse {{ $step == 5 ? 'in' : '' }}" id="collapse-pay-order" aria-expanded="{{ $step == 5 ? 'true' : 'false' }}">
    <div class="panel-body">
    @if (session('order_id'))
        <div id="paypal-button"></div>
    @else
        <div class="buttons clearfix">@lang('checkout.goto_step4')</div>
    @endif
    </div>
</div>
