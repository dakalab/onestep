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

	<div class="clearfix"></div>

	<table class="table table-hover table-bordered table-striped">
		<tr>
			<th>@lang('order.date')</th>
			<th>@lang('order.order_no')</th>
			<th>@lang('order.total')</th>
			<th>@lang('order.paid')</th>
			<th>@lang('order.receiver')</th>
			<th>@lang('order.city')</th>
			<th>@lang('web.status')</th>
			<th>@lang('order.action')</th>
		</tr>
		@foreach ($data as $row)
		<tr>
			<td>{{ $row->created_at }}</td>
			<td><a href="{{ route('account.order.detail', ['id' => $row->id]) }}">{{ $row->order_no }}</a></td>
			<td>{{ $row->totalMoney() }}</td>
			<td>{{ $row->paidMoney() }}</td>
			<td>{{ $row->firstname }} {{ $row->lastname }}</td>
			<td>{{ $row->city }}</td>
			<td>{!! $row->showStatus() !!}</td>
			<td>
				@if ($row->payable())
				<a href="{{ route('checkout', ['order_id' => $row->id]) }}"><i class="fa fa-usd"></i> @lang('order.pay')</a>
				@endif
				@if ($row->trackable())
				&nbsp;&nbsp;
				<a href="{{ route('tracking', ['number' => $row->tracking_no]) }}"><i class="fa fa-truck"></i> @lang('order.track')</a>
				@endif
				@if ($row->cancelable())
				&nbsp;&nbsp;
				<ajax-link url="{{ route('account.order.cancel', ['id' => $row->id]) }}" msg="@lang('order.confirm_cancel')"><i class="fa fa-trash"></i> @lang('order.cancel')</ajax-link>
				@endif
			</td>
		</tr>
		@endforeach
	</table>

	<div class="clearfix"></div>

	<div class="pull-right">{{ $data->links() }}</div>

</div>

@endsection
