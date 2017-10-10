<template>
    <div class="video-form-upload">
      <!-- Button -->
      <div class="d-flex justify-content-around">
        <button @click="showModal" type="button" name="button" class="btn btn-lg btn-secondary btn-blue" ref="show-modal-btn">
            Carica video {{diocane}}
        </button>
      </div>

      <div @click="hideModal" class="d-flex justify-content-end close-btn" ref="close-form-btn">
        <h3><i class="fa fa-times-circle"></i></h3>
      </div>

      <!-- form -->
      <form  method="post" enctype="multipart/form-data" ref="this-form">
        <input type="hidden" name="_token" v-model="_token">
        <input type="hidden" name="_method" v-model="_method">

        <div class="form-group">
          <div class="row">
            <div class="col-md-6 form-group">
              <h6>Titolo</h6>
              <input type="text" name="title" class="form-control" v-model="title">
            </div>
            <div class="col-md-6 form-group">
              <h6>App</h6>
              <select class="form-control" name="category" v-model="categories">
                <option v-for="opt in opts" :value="opt.value">
                  {{ opt.text }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <h6>File</h6>
            <input type="file" name="file" class="form-control">
          </div>
          <div class="d-flex justify-content-around">
            <button @click="sendForm" type="button" name="button" class="btn btn-lg btn-secondary btn-blue" ref="send-btn">Aggiungi</button>
          </div>
        </div>
      </form>
    </div>
</template>

<script>

  export default {
      props: ['_token', '_method', 'diocane'],
      data () {
          return {
              title: '',
              file: '',
              categories: '',
              opts: [
                {text: 'ciao', value: 1},
                {text: 'Gianni', value: 2}
              ]
          }
      },
      mounted () {
        this.showFormBtn = this.$refs['show-modal-btn'];
        this.sendBtn = this.$refs['send-btn'];
        this.form = this.$refs['this-form'];
        this.closeFormBtn = this.$refs['close-form-btn'];

        // get the original heights
        this.formOriginalHeight = this.form.clientHeight;
        this.showFormOriginalHeight = this.showFormBtn.clientHeight;

        // Initialize style
        this.form.style.opacity = '0';
        this.form.style.height = '0';
        this.form.style.display = 'none';
        this.closeFormBtn.style.opacity = '0';


        console.log(this.form.style.opacity);

      },
      methods: {

          showModal (e)
          {
            let showForm = new mojs.Html({
                el: this.form,
                height: {0 : this.formOriginalHeight, delay: 150},
                opacity: {0 : 1, delay: 150},
                y: {'-100' : 0},
                easing: 'sin.out',
                delay: 100
            });

            let showCloseFormBtn = new mojs.Html({
                el: this.closeFormBtn,
                opacity: {0 : 1},
                y: {'-40' : 0},
                angleZ: {90 : 0},
                easing: 'sin.out',
                delay: 200,
            });

            let showFormTimeline = new mojs.Timeline().add(showForm, showCloseFormBtn);

            this.form.style.display = 'inherit';

            new mojs.Html({
                el: this.showFormBtn,
                opacity: {1 : 0},
                height: {55 : 0},
                onComplete () {
                  showFormTimeline.play();
                }
            }).play();
          },

          hideModal()
          {
              let showSendBtn = new mojs.Html({
                  el: this.showFormBtn,
                  opacity: {0 : 1},
                  height: {50 : this.showFormOriginalHeight},
                  easing: 'sin.out',
                  delay: 100
              });

              let hideForm = new mojs.Html({
                  el: this.form,
                  height: {100 : 0},
                  opacity: {1 : 0},
                  y: {0 : '-100'},
                  easing: 'sin.in',
                  onComplete () {
                      showSendBtn.play();
                  }
              });

              let hideCloseFormBtn = new mojs.Html({
                  el: this.closeFormBtn,
                  opacity: {1 : 0},
                  y: {0 : '-40'},
                  angleZ: {0 : 90},
                  easing: 'sin.in',
                  duration: 100,
              });

              let hideFormTimeline = new mojs.Timeline().add(hideCloseFormBtn, hideForm).play();
              this.form.style.display = 'none';

          },

          sendForm (e)
          {
              e.preventDefault();

              let button = new mojs.Html({
                  el: this.sendBtn,
                  opacity: {1 : 0},
                  scale: {1 : 0},
                  height: {'100%' : 0}
              });

              let element = new mojs.Html({
                  el: this.form,
                  opacity: {1 : 0},
                  scale: {1 : 0},
                  height: {'100%' : 0}
              });

              let timeline = new mojs.Timeline().add(button, element).play();
          }
      }
  }
</script>

<style scope>
  .close-btn {
    position: absolute;
    right: 1.5rem;
    top: 1.5rem;
  }
</style>
