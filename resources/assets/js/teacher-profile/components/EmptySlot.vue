<template>
  <div id="empty-slot" @click="newUser">
    <i class="fa fa-user-plus"></i>
  </div>
</template>
<script>
export default {
  name: 'EmptySlot',
  data: () => ({

  }),
  methods: {
    newUser: function()
    {
      this.$parent.$emit('show-new-user-form')
    }
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/shared';

  #empty-slot {
    width: $spacer * 2;
    height: $spacer * 2;
    border: 2px dashed $tfc-dark-yellow;
    border-radius: 50%;
    position: relative;

    > i {
      color: $tfc-dark-yellow;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    &:hover {
      border-color: $black;

      > i {
        color: $black;
      }
    }
  }

</style>
