<template>
  <div id="single-field" class="from-group pb">
    <label>{{label}}</label>
    <input type="text" v-model="input" v-if="type == 'input'" class="form-control" :placeholder="value">
    <textarea name="name" rows="8" v-model="input" v-else-if="type == 'textarea'" class="form-control">{{this.value}}</textarea>
  </div>
</template>
<script>
export default {
  name: 'SingleField',
  props: {
    'label': {
      default: 'Label',
      type: String
    },
    'type': {
      default: 'input',
      type: String
    },
    value: {
      default: '',
      type: String
    }
  },
  data: () => ({
  }),
  computed: {
    input: {
      get: function()
      {
        return this.value
      },
      set: function(newval)
      {
        var obj = {
          'option': this.label,
          'value': newval,
        }
        this.$parent.$emit('input-updated', obj)
      }
    }
  },
  mounted() {
    //do something after mounting vue instance
    this.input = this.value
  }
}
</script>
<style lang="scss" scoped>

  label {
    text-transform: capitalize;
  }

</style>
