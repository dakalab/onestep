<form class="form-horizontal ajax" action="{{ url('/admin/banner/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $banner->id }}">
  <input type="hidden" name="photo_id" id="input-photo-id" value="{{ $banner->photo_id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $banner->id > 0 ? '修改' : '添加' }}广告</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-3 control-label">
        广告名称
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="name" value="{{ $banner->name }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        URL
        </label>
        <div class="col-md-9">
          <input type="text" class="form-control input-large" name="url" value="{{ $banner->url }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        显示状态
        </label>
        <div class="col-md-9">
          <select name="hidden" class="form-control">
            <option value=0 {{ $banner->hidden ? '' : 'selected' }}>显示</option>
            <option value=1 {{ $banner->hidden ? 'selected' : '' }}>隐藏</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label">
        图片
        </label>
        <div class="col-md-9">

          <p class="form-control-static">
            <img id="img-preview" src="{{ $banner->photo_id ? $banner->photo->url() : url('/img/boxed-bg.png') }}" height=200>
          </p>
          <input type="file" class="form-control input-large" id="input-photo-file" name="photo">
          <p class="help-block">建议图片大小为850x360</p>
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
  $('#input-photo-file').on('change', function(){
    var formData = new FormData()
    formData.append('photo', this.files[0])
    axios
        .post('/admin/photo/upload', formData)
        .then(function(response) {

          let data = response.data

          if (typeof data.code !== 'undefined' && data.code !== 200) {
            let message = 'There is something wrong!'
            if (typeof data.message === 'string') {
              message = data.message
            }
            return show_error(message)
          }

          $('#input-photo-id').val(data.data.id)
          $('#img-preview').prop('src', data.data.url)

        })
        .catch(function(error) {
          ajax_callback(error)
        })
  })
})
</script>
