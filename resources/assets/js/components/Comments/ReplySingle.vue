<template>
  <div class="col">
    <div class="row">
      <div class="col-1">
        <h3 class="text-center"><i class="fa fa-caret-right"></i></h3>
      </div>
      <div class="col-11">
        <div :class="'box '+color">
            <div class="box-header">
              <div class="title">
                {{ reply.author.name }}
              </div>
              <div class="time">
                {{ reply.time }}
              </div>
            </div>
            <div id="single-reply" class="box-body" ref="reply">
                {{ reply.comment }}
            </div>
            <div id="confirmation" class="box-btns pt" ref="confirmation">
              <button @click="destroy(reply.id)" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-trash-o"></i> Confirm</button>
              <button @click="undo" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-undo"></i> Cancel</button>
            </div>
            <div class="box-btns">
              <button @click="confirmation" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-trash-o"></i> Delete</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "reply-single",
  props: ['reply', 'user', 'user_type'],
  data: () => ({
    color: '',
  }),
  computed: {
    json_user: function()
    {
        return JSON.parse(this.user);
    }
  },
  mounted() {
    //do something after mounting vue instance
    this.colors = ['green', 'yellow', 'orange', 'blue'];
    this.index = Math.floor(Math.random() * 4);
    this.color = this.colors[this.index];
  },
  methods: {
      confirmation()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs.reply, .4, {
            opacity: 0,
            onComplete: function () {
              vue.$refs.confirmation.style.display = 'flex';
              vue.$refs.reply.style.display = 'none';
            }
          })
          .to(this.$refs.confirmation, .4, {
            opacity: 1,
          })
      },
      destroy (id)
      {
          var vue = this;

          var formData = new FormData();
          formData.append('id', id);
          formData.append('user_id', this.json_user.id);
          formData.append('user_type', this.user_type);

          axios.post('/api/v1/destroy-comment', formData)
          .then(function(response){
              // console.log(response);
              if (response.data.success) {
                  vue.undo();
                  vue.$parent.$emit('replyDelete', id);
              }
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      undo ()
      {
          var vue = this;
          var t1 = new TimelineMax();
          t1.to(this.$refs.confirmation, .4, {
              opacity: 1,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs.confirmation.style.display = 'none';
                  vue.$refs.reply.style.display = 'flex';
              }
          })
          .to(this.$refs.reply, .4, {
              opacity: 1,
              ease: Power4.easeInOut
          });
      },
  }
}
</script>
<style lang="scss" scoped>

  #confirmation {
    display: none;
    opacity: 0;
  }

  .box-header {
      display: flex;
      flex-direction: row;
      justify-content: space-between;

      > .time {
        align-self: flex-end;
        font-size: 1rem;
        line-height: 1.62;
        font-weight: normal;
        text-transform: lowercase;
      }
  }

</style>
