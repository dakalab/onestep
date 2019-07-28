<template>
    <a :href="url" @click.prevent="confirm"><slot></slot></a>
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
    msg: {
      type: String,
      required: false,
      default: null
    },
    redirect: {
      type: String,
      required: false,
      default: null
    }
  },
  methods: {
    confirm: function() {
      let that = this

      if (this.msg !== null) {
        this.show_confirm(this.msg, function(result) {
          if (result) {
            that.ajax_get(that.url)
          }
        })
      } else {
        that.ajax_get(that.url)
      }
    }
  }
}
</script>
