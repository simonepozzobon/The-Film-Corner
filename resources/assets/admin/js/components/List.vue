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
                <th>Languages</th>
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
  name: 'List',
  props: {
    'title': {
      default: '',
      type: String
    },
    'color': {
      default: '',
      type: String
    },
    'items': {
      default: '',
      type: [Array, Object]
    },
    'options': {
      default: '',
      type: Array
    },
    'languages': {
      default: '',
      type: [Array, String]
    }
  },
  data: () => ({
  }),
  components: {
    ListEl
  }
}
</script>
<style lang="scss" scoped>

  th {
    text-transform: capitalize;
  }

</style>
