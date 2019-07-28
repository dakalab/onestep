<form class="form-horizontal ajax validator" action="{{ url('/admin/user/profile') }}" method="post">
  <input type="hidden" name="uid" value="{{ $user->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>修改资料</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
          Email
        </label>
        <div class="col-md-9">
          <p class="form-control-static">
          {{ $user->email }}
          </p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        姓名
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" id="inputName" name="name" value="{{ $user->name }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        是否管理员
        </label>
        <div class="col-md-9">
          <input type="checkbox" id="inputIsAdmin" name="is_admin" {{ $user->is_admin ? 'checked' : '' }} value="1"> 是
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        新密码
        </label>
        <div class="col-md-9">
          <input type="password" class="form-control input-large" id="inputPassword" name="password">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        确认新密码
        </label>
        <div class="col-md-9">
          <input type="password" class="form-control input-large" id="inputPassword2" name="password_confirmation">
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
