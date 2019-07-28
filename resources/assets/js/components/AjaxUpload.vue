<template>
<form role="form" method="POST" :action="url" enctype="multipart/form-data" @submit.prevent="confirm">
  <div class="input-group input-group-sm" style="width: 400px">
    <input type="file" :name="filename" class="form-control" />
    <div class="input-group-btn">
    <button type="submit" class="btn btn-default"><i class="fa fa-upload"></i></button>
    </div>
  </div>
</form>
</template>

<script>
import dialog from "./dialog"
import ajax from "./ajax"

export default {
  mixins: [dialog, ajax],
  props: {
    url: {
      type: String,
      required: true
    },
    filename: {
      type: String,
      required: true
    }
  },
  methods: {
    confirm: function() {
      let that = this

      var formData = new FormData()
      formData.append(this.filename, $(':file[name=' + this.filename + ']')[0].files[0])

      axios
        .post(this.url, formData)
        .then(function(response) {
          that.ajax_callback(response)
        })
        .catch(function(error) {
          that.ajax_callback(error)
        })
    }
  }
}
</script>
