<template>
  <div id="sessions">
    <div class="box blue">
      <div class="box-header">
        Sessions
      </div>
      <div class="box-body">
        <div class="row align-items-center notification">
          <div class="col">
            <span class="display-2 align-middle"><i class="fa fa-exclamation text-danger"></i></span>
            <div class="divider"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'Sessions',
  data: () => ({

  })
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  .notification {
    padding-bottom: $spacer / 4;
    border-bottom: 2px dashed $tfc-dark-blue;
  }

</style>
