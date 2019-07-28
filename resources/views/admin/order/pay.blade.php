<form class="form-horizontal ajax validator" action="{{ url('/admin/order/pay/' . $order->id) }}" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-usd"></i>
      <strong>订单付款</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
        金额
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="amount" value="{{ $order->total }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        货币
        </label>
        <div class="col-md-9">
          <select name="currency" class="form-control">
            @foreach (config('currency') as $currency => $monetary)
						<option value={{ $currency }} {{ $currency == config('app.currency') ? 'selected' : '' }}>{{ $currency }}</option>
						@endforeach
					</select>
          <p class="help-block">以 {{ config('app.currency') }} 为基准</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        交易号（选填）
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="transaction_no">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        备注（选填）
        </label>
        <div class="col-md-9">
          <textarea name="description" class="form-control"></textarea>
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
