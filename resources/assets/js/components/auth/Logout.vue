<template>
    <a href="/logout" @click.prevent="logout">
        <slot></slot>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token">
        </form>
    </a>
</template>

<script>
export default {
  methods: {
    logout: function() {
        let form = $('#logout-form')
        $('input[name=_token]', form).val($('meta[name=csrf-token]').prop('content'))
        form.submit();
    }
  }
};
</script>