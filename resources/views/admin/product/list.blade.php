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
				<form action="{{ url('/admin/product/list') }}" class="form-inline">
					<div class="input-group input-group-sm">
						<select name="category_id" onchange="this.form.submit()" class="form-control">
							<option value="0">-- Category --</option>
							@foreach ($categories as $category)
							<option value={{ $category->id }} {{ array_get($params, 'category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="input-group input-group-sm">
						<select name="status" onchange="this.form.submit()" class="form-control">
							<option value="0">-- Status --</option>
							<option value="1" {{ array_get($params, 'status') == 1 ? 'selected' : '' }}>上架</option>
							<option value="2" {{ array_get($params, 'status') == 2 ? 'selected' : '' }}>下架</option>
						</select>
					</div>
					<div class="input-group input-group-sm">
						<select name="order_by" onchange="this.form.submit()" class="form-control">
							<option value="id">-- 排序 --</option>
							@foreach ($sortable as $k => $v)
							<option value={{ $k}} {{ array_get($params, 'order_by') == $k ? 'selected' : '' }}>{{ $v }}</option>
							@endforeach
						</select>
					</div>
					<div class="input-group input-group-sm">
						<select name="sort" onchange="this.form.submit()" class="form-control">
							<option value="desc" {{ array_get($params, 'sort') == 'desc' ? 'selected' : '' }}>降序</option>
							<option value="asc" {{ array_get($params, 'sort') == 'asc' ? 'selected' : '' }}>升序</option>
						</select>
					</div>
					<div class="input-group input-group-sm" style="width: 300px;">
						<input type="text" name="keyword" class="form-control pull-right" placeholder="Search" value="{{ array_get($params, 'keyword') }}">
						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
			</div>

			<div class="box-tools">
				<div class="input-group input-group-sm">
					<a href="#" data-remote="{{ url('/admin/product/set') }}" data-toggle="modal" data-target="#modal-800">
						<button type="button" class="btn btn-primary btn-sm">新增商品</button>
					</a>
					&nbsp;
					<a href="{!! $exportURL !!}">
						<button type="button" class="btn btn-primary btn-sm">导出</button>
					</a>
				</div>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive no-padding">
			<table class="table table-hover table-bordered table-striped" style="font-size:12px">
			<tr>
				<th>ID</th>
				<th>SKU</th>
				<th>编号</th>
				<th width=300>名称</th>
				<th>价格</th>
				<th>库存</th>
				<th>销量</th>
				<th>点击</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
			@foreach ($data as $row)
			<tr>
				<td>{{ $row->id }}</td>
				<td>{{ $row->sku }}</td>
				<td>{{ $row->spu }}</td>
				<td><a href="{{ $row->url() }}" target="_blank">{{ $row->name }}</a></td>
				<td>{{ $row->price }}</td>
				<td>{{ $row->quantity }}</td>
				<td>{{ $row->sales }}</td>
				<td>{{ $row->viewed }}</td>
				<td>{!! $row->hidden ? '<span class="text-red">下架</span>' : '<span class="text-green">上架</span>' !!}</td>
				<td>
					<a href="#" data-remote="{{ url('/admin/product/set?id=' . $row->id) }}" data-toggle="modal" data-target="#modal-800">
					<i class="fa fa-pencil"></i> 编辑
					</a>
					&nbsp;
					<a href="{{ url('/admin/product/photos/' . $row->id) }}">
					<i class="fa fa-image"></i> 图片
					</a>
					&nbsp;
					<a href="{{ url('/admin/stock/list/' . $row->id) }}">
					<i class="fa fa-cubes"></i> 库存
					</a>
					&nbsp;
					<ajax-link url="{{ url('admin/product/stop/' . $row->id) }}" msg="确认要下架该商品吗？"><i class="fa fa-level-down"></i> 下架</ajax-link>
					&nbsp;
					<ajax-link url="{{ url('admin/product/delete/' . $row->id) }}" msg="确认要删除该商品吗？"><i class="fa fa-trash"></i> 删除</ajax-link>
				</td>
			</tr>
			@endforeach
			</table>

			<div class="box-footer clearfix pull-right">
			  {{ $data->appends($params)->links('layouts.pagination.default') }}
            </div>
		</div>
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
@endsection
