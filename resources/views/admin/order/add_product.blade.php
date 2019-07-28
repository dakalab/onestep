<form class="form-horizontal ajax validator" action="{{ url('/admin/order/product-add') }}" method="post">
  <input type="hidden" name="order_id" value="{{ $order->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-plus"></i>
      <strong>添加订单商品</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品
        </label>
        <div class="col-md-10">
          <select name="product_id" class="form-control" id="select-product"></select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        数量
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="quantity" value="1">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        价格
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" id="input-price" name="price" value="0">
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

<script>
$(function () {
  $('#select-product').select2({
    theme: "bootstrap",
    ajax: {
      url: '{{ url("/api/products") }}',
      dataType: 'json'
    }
  })
  $('#select-product').on('change', function () {
    axios.get('/api/product/' + this.value)
      .then(function (response) {
        let data = response.data
        $('#input-price').val(data.price)
      })
      .catch(function (error) {
        console.log(error)
      })
  })
})
</script>
