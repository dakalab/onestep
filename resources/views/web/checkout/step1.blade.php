<div class="panel-heading">
    <h4 class="panel-title"><a href="#collapse-address" data-toggle="collapse" data-parent="#accordion" class="accordion-toggle" aria-expanded="{{ $step == 1 ? 'true' : 'false' }}">@lang('checkout.step') 1: @lang('checkout.shipping_address') <i class="fa fa-caret-down"></i></a></h4>
</div>

<div class="panel-collapse collapse {{ $step == 1 ? 'in' : '' }}" id="collapse-address" aria-expanded="{{ $step == 1 ? 'true' : 'false' }}">
    <div class="panel-body">
    <form class="form-horizontal ajax validator" action="{{ route('checkout.step1') }}" method="post">
        @csrf
        @if (count($addressbook))
        <div class="radio">
            <label>
            <input type="radio" name="address_option" value="existing" checked="checked">
            @lang('checkout.use_existing_address')
            </label>
        </div>
        <div id="address-existing" style="display: block; margin: 10px">
            <select name="address_id" class="form-control">
            @foreach ($addressbook as $address)
                <option value="{{ $address->id }}" {{ $address->id == $addressID ? 'selected' : '' }}>{{ $address->firstname }} {{ $address->lastname }}, {{ str_limit($address->address, 100) }}, {{ $address->city }}, {{ $address->province }}, {{ $address->country }}</option>
            @endforeach
            </select>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="address_option" value="new">
                @lang('checkout.use_new_address')
            </label>
        </div>
        @endif

        <div id="address-new" {!! count($addressbook) ? 'style="display: none;"' : '' !!}>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-firstname">@lang('address.firstname')</label>
                <div class="col-sm-10">
                    <input type="text" name="firstname" value="" placeholder="@lang('address.firstname')" id="input-address-firstname" class="form-control">
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-lastname">@lang('address.lastname')</label>
                <div class="col-sm-10">
                    <input type="text" name="lastname" value="" placeholder="@lang('address.lastname')" id="input-address-lastname" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-address-company">@lang('address.company')</label>
                <div class="col-sm-10">
                    <input type="text" name="company" value="" placeholder="@lang('address.company')" id="input-address-company" class="form-control">
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-address">@lang('address.address')</label>
                <div class="col-sm-10">
                    <input type="text" name="address" value="" placeholder="@lang('address.address')" id="input-address-address" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-address-phone">@lang('address.phone')</label>
                <div class="col-sm-10">
                    <input type="text" name="phone" value="" placeholder="@lang('address.phone')" id="input-address-phone" class="form-control">
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-city">@lang('address.city')</label>
                <div class="col-sm-10">
                    <input type="text" name="city" value="" placeholder="@lang('address.city')" id="input-address-city" class="form-control">
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-address-postcode">@lang('address.postcode')</label>
                <div class="col-sm-10">
                    <input type="text" name="postcode" value="" placeholder="@lang('address.postcode')" id="input-address-postcode" class="form-control">
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="select-country">@lang('address.country')</label>
                <div class="col-sm-10">
                    <select name="country" id="select-country" class="form-control select2">
                        @foreach (Helper::countries() as $country)
                        <option value="{{ $country }}" {{ config('app.country') == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="select-province">@lang('address.province')</label>
                <div class="col-sm-10">
                    <select id="select-province" name="province" class="form-control select2">
                    </select>
                </div>
            </div>
        </div> <!-- address-new -->
        <div class="buttons clearfix">
            <div class="pull-right">
                <input type="submit" value="@lang('checkout.continue')" id="button-address" class="btn btn-primary">
            </div>
        </div>
    </form>
    </div>
</div>
