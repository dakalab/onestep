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
			&nbsp;
			</div>

			<div class="box-tools">
				<div class="input-group input-group-sm">
					<a href="#" data-remote="{{ url('/admin/page/set') }}" data-toggle="modal" data-target="#modal-800">
						<button type="button" class="btn btn-primary btn-sm">新增页面</button>
					</a>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped" style="font-size:12px">
			<tr>
				<th>ID</th>
				<th>分类</th>
				<th>标题</th>
				<th>排序</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->category->name }}</td>
				<td><a href="{{ $row->url() }}" target="_blank">{{ $row->title }}</a></td>
				<td>{{ $row->sort }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/page/set?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/page/delete/' . $row->id) }}" msg="确认要删除该页面吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
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
