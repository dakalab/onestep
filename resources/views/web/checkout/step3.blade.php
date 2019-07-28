<div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-payment-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="{{ $step == 3 ? 'true' : 'false' }}">@lang('checkout.step') 3: @lang('checkout.payment_method') <i class="fa fa-caret-down"></i></a></h4>
</div>
<div class="panel-collapse collapse {{ $step == 3 ? 'in' : '' }}" id="collapse-payment-method" aria-expanded="{{ $step == 3 ? 'true' : 'false' }}">
    <div class="panel-body">
    <form class="form-horizontal ajax" action="{{ route('checkout.step3') }}" method="post">
        @csrf
        <p>@lang('checkout.select_payment')</p>
        <div class="radio">
            <label><input type="radio" name="payment_method" value="paypal" checked="checked">Paypal</label>
        </div>
        <div class="buttons clearfix">
            <div class="pull-right">
            <input type="submit" value="@lang('checkout.continue')" id="button-payment-method" class="btn btn-primary">
            </div>
        </div>
    </form>
    </div>
</div>
