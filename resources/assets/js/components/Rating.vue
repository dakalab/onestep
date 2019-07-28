<template>
  <div class="rating">
    <span class="fa fa-stack" v-for="n in 5" :key="n">
      <i v-if="n <= score" class="fa fa-star fa-stack-2x"></i>
      <i v-esle class="fa fa-star-o fa-stack-2x"></i>
    </span>
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    score: {
      type: Number,
      required: false,
      default: 5
    }
  }
}
</script>
