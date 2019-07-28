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
				<ajax-upload url="{{ url('/admin/photo/upload?product_id=' . $product->id) }}" filename="photo"></ajax-upload>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table id="product-photos" class="table table-hover">
			<tr>
				<th>ID</th>
				<th>文件名</th>
				<th>类型</th>
				<th>大小（KB）</th>
				<th>上传时间</th>
				<th>删除</th>
			</tr>
			@foreach ($product->photos as $photo)
			<tr>
				<td style="vertical-align: middle">{{ $photo->id }}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/photo/view/' . $photo->id) }}" data-toggle="modal" data-target="#modal-600">
					<img src="{{ $photo->url() }}" height=100 />
					</a>
				</td>
				<td style="vertical-align: middle">{{ $photo->extension }}</td>
				<td style="vertical-align: middle">{{ $photo->toKB() }}</td>
				<td style="vertical-align: middle">{{ $photo->created_at }}</td>
				<td style="vertical-align: middle">
					<ajax-link url="{{ route('admin.photo.delete', ['product_id' => $product->id, 'photo_id' => $photo->id]) }}" msg="确认要删除这条记录吗？">
					<i class="fa fa-trash"></i>
					</ajax-link>
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
