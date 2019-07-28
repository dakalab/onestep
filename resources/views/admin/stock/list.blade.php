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
		<div class="box-header">
			<div>
				<a href="javascript:history.back()">&lt;&lt;返回上一页</a>
			</div>
			<div class="box-tools">
				<div class="input-group input-group-sm">
					<a href="#" data-remote="{{ url('/admin/stock/set/' . $product->id) }}" data-toggle="modal" data-target="#modal-800">
						<button type="button" class="btn btn-primary btn-sm">增减库存</button>
					</a>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
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
