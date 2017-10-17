<template>
  <div class="box container-fluid mb-4">
    <div class="row">
      <div :class="'col dark-'+color+' py-3 px-5'">
        <h3>{{title}}</h3>
      </div>
    </div>
    <div class="row">
      <div :class="'col '+color+' p-5'">
        <slot></slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['title', 'color'],
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
</style>
