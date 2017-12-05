<template>
  <div id="shared-session-single">
    <div class="shared-container">
      <div class="shared-content">
        <a :href="'/teacher/network/'+session.token">
          {{ session.title }} - {{ session.app.title }} made by {{ session.userable.name }}
        </a>
      </div>
      <div class="stats">
        <div class="stat mr">
          <div class="text">
            {{ session.comments_count }}
          </div>
          <div class="icon">
            <i class="fa fa-comment"></i>
          </div>
        </div>
        <div class="stat">
          <div class="text">
            {{ session.likes.length }}
          </div>
          <div class="icon">
            <i class="fa fa-heart"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'SharedSessionSingle',
  props: {
    session: {
      default: function() {},
      type: Object
    }
  },
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #shared-session-single {
    >.shared-container {
      display: flex;
      padding-bottom: $spacer * 2 / 3;

      >.shared-content {
        > a {
          text-transform: capitalize;
          color: $black;
        }
      }

      >.stats {
        margin-left: auto;
        display: flex;

        >.mr {
          margin-right: $spacer / 2;
        }

        >.stat {
          display: flex;

          >.text {
            margin-right: $spacer / 4;
          }

          >.icon {
            color: $gray-light;
          }
        }
      }
    }
  }

</style>
