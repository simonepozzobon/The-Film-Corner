<template>
  <div class="col">
    <div id="single-reply" class="row" ref="reply">
      <div class="col-md-1 h-100">
        <h3 class="text-center"><i class="fa fa-caret-right"></i></h3>
      </div>
      <div class="col-md-11">
        <h3>{{ reply.author.name }}</h3>
        <p>{{ reply.time }}</p>
        <p>{{ reply.comment }}</p>
        <button @click="confirmation" type="button" name="button" class="btn btn-secondary btn-orange"><i class="fa fa-trash-o"></i> Delete</button>
      </div>
    </div>
    <div id="confirmation" class="row" ref="confirmation">
      <div class="col pb-4">
        <div class="d-flex justify-content-center">
          <button @click="destroy(reply.id)" type="button" name="button" class="btn btn-secondary btn-orange mx-5">
            <i class="fa fa-trash-o"></i> Confirm
          </button>
          <button @click="undo" type="button" name="button" class="btn btn-secondary btn-orange mx-5">
            <i class="fa fa-undo"></i> Cancel
          </button>
        </div>
      </div>
    </div>
    <hr class="">
  </div>
</template>
<script>
export default {
  name: "reply-single",
  props: ['reply', 'user', 'user_type'],
  data: () => ({

  }),
  computed: {
    json_user: function()
    {
        return JSON.parse(this.user);
    }
  },
  methods: {
      confirmation()
      {
          var vue = this;

          var t1 = new TimelineMax();
          t1.to(this.$refs['reply'], .4, {
            opacity: 0,
            onComplete: function () {
              vue.$refs['confirmation'].style.display = 'flex';
              vue.$refs['reply'].style.display = 'none';
            }
          })
          .to(this.$refs['confirmation'], .4, {
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
          t1.to(this.$refs['confirmation'], .4, {
              opacity: 1,
              ease: Power4.easeInOut,
              onComplete: function () {
                  vue.$refs['confirmation'].style.display = 'none';
                  vue.$refs['reply'].style.display = 'flex';
              }
          })
          .to(this.$refs['reply'], .4, {
              opacity: 1,
              ease: Power4.easeInOut
          });
      },
  }
}
</script>
<style lang="scss" scoped>

  #confirmation {
    position: relative;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    display: none;
    opacity: 0;
  }

</style>
