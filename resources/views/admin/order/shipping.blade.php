<form class="form-horizontal ajax validator" action="{{ url('/admin/order/shipping/' . $order->id) }}" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-send"></i>
      <strong>订单发货</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        快递公司
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="express" value="{{ $order->express }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        快递单号
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="tracking_no" value="{{ $order->tracking_no }}">
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
