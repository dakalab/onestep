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
				<div><a href="javascript:history.back()">&lt;&lt;返回上一页</a></div>
				<div class="box-tools">
					<div class="input-group input-group-sm">
						<a href="#" data-remote="{{ url('/admin/order/product-add?order_id=' . $order->id) }}" data-toggle="modal" data-target="#modal-800">
							<button type="button" class="btn btn-primary btn-sm">新增商品</button>
						</a>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-hover table-bordered table-striped" style="font-size:12px">
				<tr>
					<th>商品ID</th>
					<th>SKU</th>
					<th width=400>名称</th>
					<th>价格</th>
					<th>数量</th>
					<th>操作</th>
				</tr>
				@foreach ($order->products as $row)
				<tr>
					<td>{{ $row->product_id }}</td>
					<td>{{ $row->detail->sku }}</td>
					<td><a href="{{ $row->detail->url() }}" target="_blank">{{ $row->detail->name }}</a></td>
					<td>{{ $row->price }}</td>
					<td>{{ $row->quantity }}</td>
					<td>
						<a href="#" data-remote="{{ url('/admin/order/product-edit?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
						<i class="fa fa-pencil"></i> 编辑
						</a>
						&nbsp;
						<ajax-link url="{{ url('admin/order/product-delete/' . $row->id) }}" msg="确认要从订单里面删除该商品吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
					</td>
				</tr>
				@endforeach
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
@endsection
