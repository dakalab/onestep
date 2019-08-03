<form class="form-horizontal ajax validator" action="{{ url('/admin/setting/paypal') }}" method="post">
    <input type="hidden" name="env" value="{{ $env }}">
    <div class="modal-body form">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">
                Account
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="account" value="{{ object_get($setting, 'account') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Client ID
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="client_id" value="{{ object_get($setting, 'client_id') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Secret
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="secret" value="{{ object_get($setting, 'secret') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" role="submit" class="btn btn-primary">
        <i class="fa fa-check"></i> 保存
        </button>
    </div>
</form>
