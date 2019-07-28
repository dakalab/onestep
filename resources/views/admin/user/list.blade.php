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
			<h3 class="box-title"></h3>

			<div class="box-tools">
				<form>
				<div class="input-group input-group-sm" style="width: 300px;">
					<input type="text" name="keyword" class="form-control pull-right" placeholder="Search" value="{{ $keyword }}">

					<div class="input-group-btn">
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
					</div>
				</div>
				</form>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
			<tr>
				<th>ID</th>
				<th>姓名</th>
				<th>邮箱</th>
				<th>加入时间</th>
				<th>身份</th>
				<th>设置</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->name }}</td>
				<td>{{ $row->email }}</td>
				<td>{{ $row->created_at }}</td>
				<td>@if ($row->isAdmin()) <span class="label label-success">管理员</span> @endif</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/user/profile?uid=' . $row->id) }}" data-toggle="modal" data-target="#modal-750">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<a href="{{ url('/admin/address/list?user_id=' . $row->id) }}">
					<i class="fa fa-truck"></i> 地址
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/user/delete/' . $row->id) }}" msg="确认要删除该用户吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
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
