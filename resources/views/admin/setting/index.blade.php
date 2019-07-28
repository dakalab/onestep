@extends('layouts.app')

@section('htmlheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_title')
{{ $pageTitle }}
@endsection

@section('contentheader_here')
{{ $pageTitle }}
@endsection

@section('main-content')
<div class="row"><div class="col-xs-12">

<form class="form-horizontal ajax validator" action="{{ url('/admin/setting/index') }}" method="post">
    <div class="modal-body form">
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">
                Site Name
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="site_name" value="{{ array_get($data, 'site_name') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Address
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="address" value="{{ array_get($data, 'address') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Phone
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="phone" value="{{ array_get($data, 'phone') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Email
                </label>
                <div class="col-md-10">
                <input type="text" class="form-control input-large" name="email" value="{{ array_get($data, 'email') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Logo
                </label>
                <div class="col-md-10">
                    <p class="form-control-static">
                        <img id="img-preview" src="{{ $logo }}" width=300 height=40>
                    </p>
                    <input type="hidden" name="logo" id="input-photo-id" value="{{ array_get($data, 'logo') }}">
                    <input type="file" class="form-control input-large" id="input-photo-file" name="photo">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Logo Style
                </label>
                <div class="col-md-10">
                    <input type="text" class="form-control input-large" name="logo_style" value="{{ array_get($data, 'logo_style') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">
                Navbar Color
                </label>
                <div class="col-md-10">
                    <select class="form-control input-large" name="navbar_color">
                        <option value=1 {{ array_get($data, 'navbar_color') ? 'selected' : '' }}>Black</option>
                        <option value=0 {{ array_get($data, 'navbar_color') ? '' : 'selected' }}>White</option>
                    </select>
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

@endsection

@section('script-init')
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
@endsection
