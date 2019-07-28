@extends('layouts.app')

@section('htmlheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_here')
{{ $pageTitle }}
@endsection

@section('main-content')
<div class="row">
	<div class="col-xs-12">

		<div class="box">
			<table class="table table-hover table-bordered table-striped" style="font-size:12px">
				<tr>
					<th>累计采购数量</th>
					<th>累计采购金额</th>
					<th>剩余商品数量</th>
					<th>剩余商品金额</th>
					<th>累计销售数量</th>
					<th>累计销售金额</th>
				</tr>
				<tr>
					<td>{{ array_get($stats, 'total_num') }}</td>
					<td>{{ array_get($stats, 'total_amount') }}</td>
					<td>{{ array_get($remains, 'total_num') }}</td>
					<td>{{ array_get($remains, 'total_amount') }}</td>
					<td>{{ array_get($sales, 'total_num') }}</td>
					<td>{{ array_get($sales, 'total_amount') }}</td>
				</tr>
			</table>
        </div>

		<div class="box">
		<div class="box-header">
			<div>
			<form action="{{ url('/admin/stock/check') }}" class="form-inline">
				<div class="input-group date">
					<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control pull-right datepicker" name="start" value="{{ $start }}">
				</div>
				<div class="input-group date">
					<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control pull-right datepicker" name="end" value="{{ $end }}">
				</div>
				<div class="input-group">
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
				</div>
			</form>
			</div>
			<div class="box-tools">
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped" style="font-size:12px">
			<tr>
				<th>ID</th>
				<th>商品ID</th>
				<th>订单ID</th>
				<th>数量</th>
				<th>单价</th>
				<th>货币</th>
				<th>汇率</th>
				<th>备注</th>
				<th>操作人</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->product_id }}</td>
				<td>{{ $row->order_id }}</td>
				<td>{{ $row->change }}</td>
				<td>{{ $row->unit_cost }}</td>
				<td>{{ $row->currency }}</td>
				<td>{{ $row->exchange_rate }}</td>
				<td>{{ $row->remark }}</td>
				<td>{{ $row->operator() }}</td>
				<td>{{ $row->created_at }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/stock/edit/' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
						<i class="fa fa-pencil"></i> 编辑
					</a>
				</td>
			</tr>
			@endforeach
			</table>

			<div class="box-footer clearfix pull-right">
			  {{ $data->links('layouts.pagination.default') }}
            </div>
		</div>
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
@endsection
