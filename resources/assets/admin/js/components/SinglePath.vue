<template>
  <tbody id="single-path">
    <tr>
      <td>Ciao</td>
    </tr>
  </tbody>
</template>
<script>
export default {
  name: 'SinglePath',
  props: {
    path: {
      default: function () {},
      type: [String, Array, Object]
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
