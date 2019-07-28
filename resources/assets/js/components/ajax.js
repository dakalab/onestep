export default {
    methods: {
        ajax_get(url) {
            let that = this
            axios
                .get(url)
                .then(function (response) {
                    that.ajax_callback(response, that.redirect)
                })
                .catch(function (error) {
                    console.log(error)
                    that.ajax_callback(error, that.redirect)
                })
        },
        ajax_callback(response, redirect) {

            let data = response.data

            if (response.status === 422) {
                let message = '<div class="alert alert-danger"><ul>'
                for (var i in data.errors) {
                    for (var j in data.errors[i]) {
                        message += '<li>' + data.errors[i][j] + '</li>'
                    }
                }
                message += '</ul></div>'
                return this.show_error(message)
            }

            if (response.status !== 200) {
                return this.show_error(response.statusText)
            }

            if (typeof data.code !== 'undefined' && data.code !== 200) {
                let message = 'There is something wrong!'
                if (typeof data.message === 'string') {
                    message = data.message
                }
                return this.show_error(message)
            }

            var callback = function () {
                if (typeof redirect === 'string') {
                    if (redirect !== 'off') {
                        setTimeout(function () {
                            document.location.href = redirect
                        }, 1000)
                    }
                } else {
                    setTimeout(function () {
                        document.location.reload()
                    }, 1000)
                }
            }

            if (data.message) {
                return this.show_success(data.message, callback)
            }

            return callback()
        },
    }
}
