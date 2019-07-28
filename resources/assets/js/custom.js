function show_success(message, callback) {
  return bootbox.alert({
    title: '<i class="fa fa-check-circle text-green"></i> Success!',
    message: message,
    callback: callback
  })
}
function show_error(message, callback) {
  return bootbox.alert({
    title: '<i class="fa fa-times-circle text-red"></i> Error!',
    message: message,
    callback: callback
  })
}
function show_confirm(message, callback) {
  return bootbox.confirm({
    title: '<i class="fa fa-info-circle text-blue"></i> Confirm?',
    message: message,
    callback: callback
  })
}
function ajax_callback(response, redirect) {

  let data = response.data

  if (response.status === 422) {
    message = '<div class="alert alert-danger"><ul>'
    for (var i in data.errors) {
      for (var j in data.errors[i]) {
        message += '<li>' + data.errors[i][j] + '</li>'
      }
    }
    message += '</ul></div>'
    return show_error(message)
  }

  if (response.status !== 200) {
    return show_error(response.statusText)
  }


  if (typeof data.code !== 'undefined' && data.code !== 200) {
    let message = 'There is something wrong!'
    if (typeof data.message === 'string') {
      message = data.message
    }
    return show_error(message)
  }

  var callback = function () {
    if (typeof redirect === 'string') {
      if (redirect !== 'off') {
        setTimeout(function () {
          document.location.href = redirect
        }, 100)
      }
    } else {
      setTimeout(function () {
        document.location.reload()
      }, 100)
    }
  }

  if (data.message) {
    return show_success(data.message, callback)
  }

  return callback()
}
function show_validation_error(form, error) {
  $('.form-group', form).removeClass('has-error')
  $('.form-control', form).nextAll('.help-block').remove()
  if (error.status === 422) {
    let data = error.data
    console.log(data)
    for (var i in data.errors) {
      console.log(i)
      $('input[name=' + i + ']', form).closest('.form-group').addClass('has-error')
      $('select[name=' + i + ']', form).closest('.form-group').addClass('has-error')
      var message = ''
      for (var j in data.errors[i]) {
        message += data.errors[i][j] + '<br>'
      }
      $('input[name=' + i + ']', form).after('<span class="help-block">' + message + '</span>')
      $('select[name=' + i + ']', form).after('<span class="help-block">' + message + '</span>')
    }
  }
}

(function ($) {

  $.fn.provinces = function (country, province) {
    let sel = $(this)

    sel.empty() // remove all options

    axios.get('/api/provinces?country=' + country)
      .then(function (response) {
        let data = response.data

        if (typeof data.code !== 'undefined' && data.code !== 200) {
          let message = 'There is something wrong!'
          if (typeof data.message === 'string') {
            message = data.message
          }
          return show_error(message)
        }

        for (i in data.data) {
          let v = data.data[i]
          let s = ''
          if (province == v) {
            s = ' selected '
          }
          sel.append("<option value='" + v + "'" + s + ">" + v + "</option>")
        }

      })
      .catch(function (error) {
        ajax_callback(error)
      })
    return this
  }

}(jQuery))

$(function () {

  $('form.ajax').on('submit', function (e) {
    e.preventDefault()

    for (instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement()
    }

    let form = this
    var formData = $(this).serialize()

    axios.post(this.action, formData)
      .then(function (response) {
        // console.log(response)
        ajax_callback(response, $(form).data('redirect'))
      })
      .catch(function (error) {
        // console.log(error)
        if ($(form).hasClass('validator')) {
          show_validation_error(form, error)
        } else {
          ajax_callback(error)
        }
      })
  })

  $('.select2').select2({
    theme: "bootstrap"
  })

  $('.datepicker').datepicker({
    autoclose: true,
    format: "yyyy-mm-dd"
  })
})
