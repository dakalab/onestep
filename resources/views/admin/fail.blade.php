@extends('layouts.app')

@section('htmlheader_title')
	设置失败
@endsection

@section('contentheader_title')
	设置失败
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="box box-default">
					<div class="box-header with-border">
						<i class="fa fa-times-circle text-red"></i>
						<h3 class="box-title">错误消息</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						@if ($errors->any())
						<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						</div>
						@endif
						<a href="javascript:history.back()">返回上一页</a>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3"></div>
		</div>
	</div>
@endsection
