<form class="form-horizontal ajax validator" action="{{ url('/admin/product/set') }}" method="post">
  <input type="hidden" name="id" value="{{ $product->id }}">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">
      <i class="fa fa-pencil"></i>
      <strong>{{ $product->id > 0 ? '修改' : '添加' }}商品</strong>
    </h4>
  </div>
  <div class="modal-body form">
    <div class="form-body">
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品分类
        </label>
        <div class="col-md-10">
          <select name="category_id" class="form-control">
            @foreach ($categories as $category)
            <option value={{ $category->id }} {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品名称
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="name" value="{{ $product->name }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        SKU
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="sku" value="{{ $product->sku }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        商品编号
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="spu" value="{{ $product->spu }}">
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
      <div class="form-group">
        <label class="col-md-2 control-label">
        状态
        </label>
        <div class="col-md-10">
          <select name="hidden" class="form-control">
            <option value=0 {{ $product->hidden ? '' : 'selected' }}>上架</option>
            <option value=1 {{ $product->hidden ? 'selected' : '' }}>下架</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        属性
        </label>
        <div class="col-md-10">
        <select name="attributes[]" style="width:100%" class="form-control select2" multiple="multiple">
          @foreach ($groups as $group)
          <optgroup label="{{ $group->name }}">
            @foreach ($group->attributes as $attribute)
            <option {{ in_array($attribute->id, $attributes) ? 'selected' : '' }} value="{{ $attribute->id }}">{{ $attribute->name }}</option>
            @endforeach
          </optgroup>
          @endforeach
        </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        SEO URL
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="seo_url" value="{{ $product->seo_url }}">
          <p class="help-block">注意：不要在url末尾填写.html，程序会自动填充</p>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        Meta关键字
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="keywords" value="{{ $product->keywords }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        Meta描述
        </label>
        <div class="col-md-10">
          <input type="text" class="form-control input-large" name="meta_desc" value="{{ $product->meta_desc }}">
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">
        描述
        </label>
        <div class="col-md-10">
        <textarea name="description" id="editor">
          {{ $product->description }}
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
