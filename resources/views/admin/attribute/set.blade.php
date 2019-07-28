<form class="form-horizontal ajax validator" action="{{ url('/admin/attribute/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $model->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $model->id > 0 ? '修改' : '添加' }}属性</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
        属性名称
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="name" value="{{ $model->name }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        属性分类
        </label>
        <div class="col-md-9">
          <select name="attribute_group_id" class="form-control">
            @foreach ($groups as $group)
            <option value={{ $group->id }} {{ $model->attribute_group_id == $group->id ? 'selected' : '' }}>{{$group->name}}</option>
            @endforeach
          </select>
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
