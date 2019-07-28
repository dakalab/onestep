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
					<a data-remote="{{ url('/admin/address/set?user_id=') . array_get($params, 'user_id') }}" data-toggle="modal" data-target="#modal-800">
						<button type="button" class="btn btn-primary btn-sm">添加地址</button>
					</a>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped">
			<tr>
				<th>ID</th>
				<th>姓氏</th>
				<th>名字</th>
				<th>地址</th>
				<th>国家</th>
				<th>省份</th>
				<th>城市</th>
				<th>默认</th>
				<th>创建时间</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->lastname }}</td>
				<td>{{ $row->firstname }}</td>
				<td>{{ str_limit($row->address,50) }}</td>
				<td>{{ $row->country }}</td>
				<td>{{ $row->province }}</td>
				<td>{{ $row->city }}</td>
				<td>{!! $row->is_default ? '<span class="text-green">是</span>' : '<span class="text-red">否</span>' !!}</td>
				<td>{{ $row->created_at }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/address/set?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/address/delete/' . $row->id) }}" msg="确认要删除这条记录吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
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
