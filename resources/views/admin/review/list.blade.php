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
			<h3 class="box-title">
			</h3>

			<div class="box-tools">
				<div class="input-group input-group-sm">
					<a data-remote="{{ url('/admin/review/set') }}" data-toggle="modal" data-target="#modal-800">
						<button type="button" class="btn btn-primary btn-sm">添加评论</button>
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
				<th>作者</th>
				<th>分数</th>
				<th>评论</th>
				<th>是否显示</th>
				<th>评论时间</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->product_id }}</td>
				<td>{{ $row->author }}</td>
				<td>{{ $row->rating }}</td>
				<td>{{ str_limit($row->comment,50) }}</td>
				<td>{!! $row->hidden ? '<span class="text-red">否</span>' : '<span class="text-green">是</span>' !!}</td>
				<td>{{ $row->comment_time }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/review/set?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/review/delete/' . $row->id) }}" msg="确认要删除这条记录吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
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
