@extends('layouts.app')

@section('htmlheader_title')
	设置成功
@endsection

@section('contentheader_title')
	设置成功
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="box box-default">
					<div class="box-header with-border">
						<i class="fa fa-check-circle text-green"></i>
						<h3 class="box-title">设置成功</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
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
