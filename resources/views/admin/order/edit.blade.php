<form class="form-horizontal ajax validator" action="{{ url('/admin/order/edit/' . $order->id) }}" method="post">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>编辑订单</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        名字
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="firstname" value="{{ $order->firstname }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        姓氏
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="lastname" value="{{ $order->lastname }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        邮箱
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="email" value="{{ $order->email }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        地址
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="address" value="{{ $order->address }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        国家
        </label>
        <div class="col-md-10">
          <select id="select-country" name="country" class="form-control select2">
            @foreach ($countries as $country)
            <option value="{{ $country }}" {{ $order->country == $country ? 'selected' : '' }}>{{ $country }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        省份
        </label>
        <div class="col-md-10">
          <select id="select-province" name="province" class="form-control select2">
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        城市
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="city" value="{{ $order->city }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        邮编
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="postcode" value="{{ $order->postcode }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        电话（选填）
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="phone" value="{{ $order->phone }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        公司（选填）
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="company" value="{{ $order->company }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        订单状态
        </label>
        <div class="col-md-10">
          <select name="status" class="form-control" disabled>
						@foreach ($statusList as $status)
						<option value={{ $status }} {{ $order->status == $status ? 'selected' : '' }}>{{ $status }}</option>
						@endforeach
					</select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        备注（选填）
        </label>
        <div class="col-md-10">
          <textarea name="comment" class="form-control">{{ $order->comment }}</textarea>
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
  $('#select-province').provinces($('#select-country').val(), '{{ $order->province }}')
  $('#select-country').on('change', function() {
    $('#select-province').provinces(this.value)
  })
})
</script>
