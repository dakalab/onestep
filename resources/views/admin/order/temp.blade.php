@extends('layouts.app')

@section('htmlheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_menu')
<li>临时订单管理</li>
@endsection

@section('contentheader_here')
临时订单列表
@endsection

@section('main-content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
		<div class="box-header">
			<div>
			<form action="{{ url('/admin/order/temp') }}" class="form-inline">
				<div class="input-group input-group-sm">
					<select name="status" onchange="this.form.submit()" class="form-control">
						<option value="">-- Status --</option>
						@foreach ($statusList as $status)
						<option value={{ $status }} {{ array_get($params, 'status') == $status ? 'selected' : '' }}>{{ $status }}</option>
						@endforeach
					</select>
				</div>
				<div class="input-group input-group-sm" style="width: 300px;">
					<input type="text" name="keyword" class="form-control pull-right" placeholder="Search" value="{{ array_get($params, 'keyword') }}">
					<div class="input-group-btn">
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</form>
			</div>

			<div class="box-tools"></div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
			<tr>
				<th>ID</th>
				<th>订单号</th>
				<th>总金额</th>
				<th>已付金额</th>
				<th>状态</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td><a href="#" title="订单详情" data-remote="{{ url('/admin/order/view/' . $row->id) }}" data-toggle="modal" data-target="#modal-900">{{ $row->order_no }}</a></td>
				<td>{{ $row->totalMoney() }}</td>
				<td>{{ $row->paidMoney() }}</td>
				<td>{!! $row->showStatus() !!}</td>
				<td>{{ $row->created_at }}</td>
				<td>
					@if ($row->editable())
					<a href="#" data-remote="{{ url('/admin/order/edit/' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<ajax-link url="{{ url('/admin/order/recover/' . $row->id) }}">
						<i class="fa fa-recycle"></i> 恢复
					</ajax-link>
					@endif
					@if ($row->cancelable())
					&nbsp;
					<ajax-link url="{{ url('/admin/order/cancel/' . $row->id) }}" msg="确认要取消这个订单吗？">
						<i class="fa fa-trash"></i> 取消
					</ajax-link>
					@endif
				</td>
			</tr>
			@endforeach
			</table>

			{!! $data->appends($params)->render() !!}
		</div>
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
@endsection
