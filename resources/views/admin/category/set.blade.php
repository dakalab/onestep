<form class="form-horizontal ajax validator" action="{{ url('/admin/category/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $category->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $category->id > 0 ? '修改' : '添加' }}分类</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
        分类名称
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="name" value="{{ $category->name }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        排序（越大越前）
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="sort" value="{{ $category->sort }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        显示状态
        </label>
        <div class="col-md-9">
          <select name="hidden" class="form-control">
            <option value=0 {{ $category->hidden ? '' : 'selected' }}>显示</option>
            <option value=1 {{ $category->hidden ? 'selected' : '' }}>隐藏</option>
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
