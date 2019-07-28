<form class="form-horizontal ajax validator" action="{{ url('/admin/order/product-edit') }}" method="post">
  <input type="hidden" name="id" value="{{ $product->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>修改订单商品</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品名称
        </label>
        <div class="col-md-10">
        <p class="form-control-static">{{ $product->detail->name }}</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        SKU
        </label>
        <div class="col-md-10">
          <p class="form-control-static">{{ $product->detail->sku }}</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        数量
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="quantity" value="{{ $product->quantity }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        价格
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="price" value="{{ $product->price }}">
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
