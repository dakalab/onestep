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
					<a data-remote="{{ url('/admin/page-category/set') }}" data-toggle="modal" data-target="#modal-600">
						<button type="button" class="btn btn-primary btn-sm">新增分类</button>
					</a>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
			<tr>
				<th>ID</th>
				<th>分类名称</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->name }}</td>
				<td>{{ $row->created_at }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/page-category/set?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-600">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/page-category/delete/' . $row->id) }}" msg="确认要删除这条记录吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
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
