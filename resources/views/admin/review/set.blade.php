<form class="form-horizontal ajax validator" action="{{ url('/admin/review/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $review->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $review->id > 0 ? '修改' : '添加' }}评论</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品ID
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="product_id" value="{{ $review->product_id }}">
          <p class="help-block">填0或者不填将会对所有商品进行批量评价</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        作者
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="author" value="{{ $review->author }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        分数
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="rating" value="{{ $review->rating }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        时间
        </label>
        <div class="col-md-10">
          <div class="input-group date">
            <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right datepicker" name="comment_time" value="{{ $review->created_at }}">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        显示状态
        </label>
        <div class="col-md-10">
          <select name="hidden" class="form-control">
            <option value=0 {{ $review->hidden ? '' : 'selected' }}>显示</option>
            <option value=1 {{ $review->hidden ? 'selected' : '' }}>隐藏</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        评论
        </label>
        <div class="col-md-10">
        <textarea name="comment" id="editor">
          {{ $review->comment }}
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
