<form class="form-horizontal ajax" action="{{ url('/admin/stock/edit/' . $stock->id ) }}" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $pageTitle }}</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
        商品SKU
        </label>
        <div class="col-md-7">
        <p class="form-control-static">{{ $stock->product->sku }}</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        商品名称
        </label>
        <div class="col-md-7">
        <p class="form-control-static">{{ $stock->product->name }}</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        数量（负数为减少）
        </label>
        <div class="col-md-7">
          <p class="form-control-static">{{ $stock->change }}</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        单价
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="unit_cost" value="{{ $stock->unit_cost }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        货币
        </label>
        <div class="col-md-9">
          <select name="currency" class="form-control">
						@foreach (config('currency') as $currency => $monetary)
						<option value={{ $currency }} {{ $currency == $stock->currency ? 'selected' : '' }}>{{ $currency }}</option>
						@endforeach
					</select>
          <p class="help-block">以 {{ config('app.currency') }} 为基准</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        备注
        </label>
        <div class="col-md-7">
          <input type="text" class="form-control input-large" name="remark">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" role="submit" class="btn btn-primary">
      <i class="fa fa-check"></i> 提交
    </button>
    <button type="button" class="btn btn-default" data-dismiss="modal">
      <i class="fa fa-times"></i> 关闭
    </button>
  </div>
</form>

<script src="{{ mix('/js/custom.js')}}" type="text/javascript"></script>
