export default {
  methods: {
    show_success(message, callback) {
      return bootbox.alert({
        title: '<i class="fa fa-check-circle text-green"></i> Success!',
        message: message,
        callback: callback
      })
    },
    show_error(message, callback) {
      return bootbox.alert({
        title: '<i class="fa fa-times-circle text-red"></i> Error!',
        message: message,
        callback: callback
      })
    },
    show_confirm(message, callback) {
      return bootbox.confirm({
        title: '<i class="fa fa-info-circle text-blue"></i> Confirm?',
        message: message,
        callback: callback
      })
    },
  }
}
