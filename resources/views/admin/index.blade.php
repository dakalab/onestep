@extends('layouts.app')

@section('htmlheader_title')
	{{ $pageTitle }}
@endsection

@section('contentheader_title')
	{{ $pageTitle }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
				<h3>{{ $newOrder }}</h3>

				<p>New Orders</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="/admin/order/list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-green">
				<div class="inner">
				<h3>{{ $income }}</h3>

				<p>Income</p>
				</div>
				<div class="icon">
				<i class="ion ion-stats-bars"></i>
				</div>
				<a href="/admin/order/list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
				<h3>{{ $newUser }}</h3>

				<p>New Users</p>
				</div>
				<div class="icon">
				<i class="ion ion-person-add"></i>
				</div>
				<a href="/admin/user/list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
			<div class="small-box bg-red">
				<div class="inner">
				<h3>{{ $totalUser }}</h3>

				<p>Total Users</p>
				</div>
				<div class="icon">
				<i class="ion ion-pie-graph"></i>
				</div>
				<a href="/admin/user/list" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
			</div>
			</div>
			<!-- ./col -->
		</div>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<li class="pull-left header"><i class="fa fa-inbox"></i> Daily Sales</li>
				</ul>
				<div class="tab-content no-padding">
					<div class="chart" id="daily-sales-chart" style="height: 300px;"></div>
				</div>
			</div>
			<div class="nav-tabs-custom">
				<!-- Tabs within a box -->
				<ul class="nav nav-tabs pull-right">
					<li class="pull-left header"><i class="fa fa-inbox"></i> Monthly Sales</li>
				</ul>
				<div class="tab-content no-padding">
					<div class="chart" id="monthly-sales-chart" style="height: 300px;"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	@include('layouts.partials.scripts')

<script>

$(function () {
	echarts.init(document.getElementById('daily-sales-chart')).setOption({
		tooltip: {},
		legend: {
			data: ['销售金额']
		},
		toolbox: {
			feature: {
				dataView: {},
				saveAsImage: {
					pixelRatio: 2
				},
				restore: {}
			}
		},
		xAxis: {
			type: 'category',
			data: {!! json_encode(array_keys($dailySales)) !!}
		},
		yAxis: {},
		series: [{
			name: '销售金额',
			type: 'line',
			smooth: true,
			data: {!! json_encode(array_values($dailySales)) !!}
		}]
	});

	echarts.init(document.getElementById('monthly-sales-chart')).setOption({
		tooltip : {
			trigger: 'axis',
			axisPointer : {
				type : 'shadow'
			}
		},
		legend: {
			data: ['销售金额']
		},
		toolbox: {
			feature: {
				dataView: {},
				saveAsImage: {
					pixelRatio: 2
				},
				restore: {}
			}
		},
		xAxis: {
			type: 'category',
			data: {!! json_encode($months) !!}
		},
		yAxis: {},
		series: [
			{
				name: '销售金额',
				type: 'bar',
				data: {!! json_encode(array_values($monthlySales)) !!}
			}
		]
	});
});

</script>

@endsection
