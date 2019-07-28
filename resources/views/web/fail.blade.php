@extends('web.layout')

@section('htmlheader_title')
@lang('fail.something_wrong')
@endsection

@section('main-content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="box box-default">
					<div class="box-header with-border">
						<i class="fa fa-times-circle text-red"></i>
						<h3 class="box-title">@lang('fail.error_message')</h3>
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
						<a href="{!! URL::previous() !!}">@lang('fail.back')</a>
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
