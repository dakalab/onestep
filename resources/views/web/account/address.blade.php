@extends('web.layout')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')

    <div class="col-md-3">
    @include('web.account.menus')
    </div>

    <div class="col-md-9">

        <h2 class="pull-left">{{ $pageTitle }}</h2>

        <div class="pull-right" style="margin-top:15px">
            <a href="{{ route('account.address.set') }}">
                <button type="button" class="btn btn-primary btn-sm">@lang('address.new_address')</button>
            </a>
        </div>

        <div class="clearfix"></div>

		<table class="table table-hover table-bordered table-striped">
			<tr>
				<th>@lang('address.firstname')</th>
				<th>@lang('address.lastname')</th>
				<th>@lang('address.company')</th>
				<th>@lang('address.country')</th>
				<th>@lang('address.province')</th>
				<th>@lang('address.city')</th>
				<th>@lang('address.default')</th>
				<th>@lang('account.action')</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->lastname }}</td>
				<td>{{ $row->firstname }}</td>
				<td>{{ str_limit($row->address,50) }}</td>
				<td>{{ $row->country }}</td>
				<td>{{ $row->province }}</td>
				<td>{{ $row->city }}</td>
				<td>
                    @if ($row->is_default)
                    <span class="text-success" title="Yes"><i class="fa fa-check"></i></span>
                    @else
                    <span class="text-danger" title="No"><i class="fa fa-times"></i></span>
                    @endif
                </td>
				<td>
					<a href="{{ route('account.address.set', ['id' => $row->id]) }}">
					<i class="fa fa-pencil"></i> @lang('account.edit')
					</a>
					&nbsp;
					<ajax-link url="{{ url('account/address/delete/' . $row->id) }}" msg="@lang('web.confirm_delete')"><i class="fa fa-trash"></i> @lang('account.delete')</ajax-link>
				</td>
			</tr>
			@endforeach
        </table>

        <div class="clearfix"></div>

		<div class="pull-right">{{ $data->links() }}</div>

    </div>

@endsection
