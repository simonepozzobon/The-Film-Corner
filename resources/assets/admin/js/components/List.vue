<template>
  <div id="list">
    <div class="row mt">
      <div class="col">
        <div :class="'box '+color">
          <div class="box-header">
            {{title}}
          </div>
          <div class="box-body">
            <table class="table table-hover">
              <thead>
                <th v-for="option in options" :key="option.key">{{option.title}}</th>
              </thead>
              <list-el v-for="item in items" :key="item.key" :item="item" :options="options" :languages="languages" :color="color"></list-el>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ListEl from './ListEl.vue'

export default {
  name: "list",
  props: ['title', 'color', 'items', 'options', 'languages'],
  data: () => ({
  }),
  components: {
      ListEl
  }
}
</script>
<style lang="scss" scoped>
</style>
