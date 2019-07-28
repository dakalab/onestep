<div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-shipping-method" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="{{ $step == 2 ? 'true' : 'false' }}">@lang('checkout.step') 2: @lang('checkout.delivery_method') <i class="fa fa-caret-down"></i></a></h4>
</div>
<div class="panel-collapse collapse {{ $step == 2 ? 'in' : '' }}" id="collapse-shipping-method" aria-expanded="{{ $step == 2 ? 'true' : 'false' }}">
    <div class="panel-body">
    <form class="form-horizontal ajax" action="{{ route('checkout.step2') }}" method="post">
        @csrf
        <p><strong>@lang('checkout.free_shipping')</strong></p>
        <div class="radio">
            <label><input type="radio" name="shipping_method" value="free" checked="checked">@lang('checkout.express') - {{ \Helper::money(0) }}</label>
        </div>
        <div class="buttons clearfix">
            <div class="pull-right">
            <input type="submit" value="@lang('checkout.continue')" id="button-shipping-method" class="btn btn-primary">
            </div>
        </div>
    </form>
    </div>
</div>
