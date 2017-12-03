<template>
  <div :class="'box '+color">
    <div class="box-header">
        {{title}}
    </div>
    <div class="box-body">
      <slot></slot>
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
