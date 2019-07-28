@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

<div class="col-md-3">
@include('web.account.menus')
</div>

<div class="col-md-9">

    <form data-redirect="{{ route('account.address') }}" class="form-horizontal ajax validator" action="{{ route('account.address.set') }}" method="post">
        <input type="hidden" name="id" value="{{ $address->id }}">

        <div class="modal-header">
            <h3 class="modal-title">
            <i class="fa fa-pencil"></i>
            <strong>{{ $pageTitle }}</strong>
            </h3>
        </div>

        <div class="modal-body form">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.firstname')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="firstname" value="{{ $address->firstname }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.lastname')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="lastname" value="{{ $address->lastname }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.address')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="address" value="{{ $address->address }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.country')
                    </label>
                    <div class="col-md-9">
                    <select id="select-country" name="country" class="form-control select2">
                        @foreach ($countries as $country)
                        <option value="{{ $country }}" {{ $address->country == $country ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.province')
                    </label>
                    <div class="col-md-9">
                    <select id="select-province" name="province" class="form-control select2">
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.city')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="city" value="{{ $address->city }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.postcode')
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="postcode" value="{{ $address->postcode }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.phone') (@lang('address.optional'))
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="phone" value="{{ $address->phone }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.company') (@lang('address.optional'))
                    </label>
                    <div class="col-md-9">
                    <input type="text" class="form-control input-large" name="company" value="{{ $address->company }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">
                    @lang('address.set_default')
                    </label>
                    <div class="col-md-9">
                    <select name="is_default" class="form-control">
                        <option value=0 {{ $address->is_default ? '' : 'selected' }}>@lang('web.no')</option>
                        <option value=1 {{ $address->is_default ? 'selected' : '' }}>@lang('web.yes')</option>
                    </select>
                    </div>
                </div>
            </div> <!-- form-body -->
        </div> <!-- modal-body -->

        <div class="modal-footer">
            <button type="submit" role="submit" class="btn btn-primary">
            <i class="fa fa-check"></i> @lang('web.submit')
            </button>
            <a href="javascript:history.back()" class="btn btn-default">
            <i class="fa fa-times"></i> @lang('web.back')
            </a>
        </div>
    </form> <!-- form -->

</div>
<!-- col-md-9 -->

@endsection
