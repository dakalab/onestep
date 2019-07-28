<form class="form-horizontal ajax validator" action="{{ url('/admin/page/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $page->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $page->id > 0 ? '修改' : '添加' }}页面</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        分类
        </label>
        <div class="col-md-10">
          <select name="page_category_id" class="form-control">
            @foreach ($categories as $category)
            <option value={{ $category->id }} {{ $page->page_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        标题
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="title" value="{{ $page->title }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        SEO URL
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="seo_url" value="{{ $page->seo_url }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        Meta关键字
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="keywords" value="{{ $page->keywords }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        Meta描述
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="meta_desc" value="{{ $page->meta_desc }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        排序
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="sort" value="{{ (int) $page->sort }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        内容
        </label>
        <div class="col-md-10">
        <textarea name="content" id="editor">
          {{ $page->content }}
        </textarea>
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
  CKEDITOR.replace('editor')
})
</script>
