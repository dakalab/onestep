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
				<ajax-upload url="{{ url('/admin/photo/upload') }}" filename="photo"></ajax-upload>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover">
			<tr>
				<th>ID</th>
				<th>文件名</th>
				<th>类型</th>
				<th>大小（KB）</th>
				<th>上传时间</th>
				<th>删除</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td><a href="{{ $row->url() }}" target="_blank">{{ $row->filename }}</a></td>
				<td>{{ $row->extension }}</td>
				<td>{{ $row->toKB() }}</td>
				<td>{{ $row->created_at }}</td>
				<td>
					<ajax-link url="{{ route('admin.photo.delete', ['photo_id' => $row->id]) }}" msg="确认要删除这条记录吗？">
					<i class="fa fa-trash"></i>
					</ajax-link>
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
