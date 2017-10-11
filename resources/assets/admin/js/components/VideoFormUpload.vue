<template>
    <div class="video-form-upload">
      <!-- Button -->
      <div class="d-flex justify-content-around">
        <button @click="showModal" type="button" name="button" class="btn btn-lg btn-secondary btn-blue" ref="show-modal-btn">
            Carica Video
        </button>
      </div>

      <div @click="hideModal" class="d-flex justify-content-end close-btn" ref="close-form-btn">
        <h3><i class="fa fa-times"></i></h3>
      </div>

      <!-- form -->
      <form :action="action" method="post" enctype="multipart/form-data" ref="this-form">
        <input type="hidden" name="_token" :value="token">
        <input type="hidden" name="_method" :value="method">

        <div class="row">
          <div class="col-md-6 form-group">
            <h6>Titolo</h6>
            <input type="text" name="title" class="form-control" v-model="title" required>
          </div>
          <div class="col-md-6 form-group">
            <h6>Categoria Video</h6>
            <select class="form-control" name="category" v-model="category" required>
              <option v-for="opt in opts" :value="opt.id">
                {{ opt.name }}
              </option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 form-group">
            <h6>Padiglione</h6>
            <select class="form-control" name="section" v-model="section" required>
              <option v-for="sec in secs" :value="sec.id">
                {{ sec.name }}
              </option>
            </select>
          </div>
          <div class="col-md-4 form-group">
            <h6>Categoria</h6>
            <select class="form-control" name="app_category" v-model="app_category">
              <option v-for="a_cat in a_cats" :value="a_cat.id">
                {{ a_cat.name }}
              </option>
            </select>
          </div>
          <div class="col-md-4 form-group">
            <h6>App</h6>
            <select class="form-control" name="app_name" v-model="app_name">
              <option v-for="a_name in a_names" :value="a_name.id">
                {{ a_name.title }}
              </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <h6>File</h6>
          <input type="file" name="file" class="form-control" @change="fileChange">
        </div>
        <div class="d-flex justify-content-around">
          <button @click="sendForm" type="button" name="button" class="btn btn-lg btn-secondary btn-blue" ref="send-btn">Aggiungi</button>
        </div>
      </form>
    </div>
</template>

<script>
  import axios from 'axios';

  export default {
      props: ['token', 'method', 'action', 'options', 'sections', 'app_categories', 'apps'],
      data () {
          return {
              title: '',
              category: '',
              opts: '',
              video: '',
              secs: '',
              section: '',
              a_cats: '',
              app_category: '',
              a_names: '',
              app_name: ''
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

        // var Settings
        this.opts = JSON.parse(this.options);
        this.secs = JSON.parse(this.sections);
        this.a_cats = JSON.parse(this.app_categories);
        this.a_names = JSON.parse(this.apps);

        this.dot_opts = {
          shape: 'circle',
          radius: 10,
          y: {20 : 0},
          fill: 'grey',
          isYoyo: true,
          repeat: 9999,
          duration: 300,
        }

        this.dot = new mojs.Shape({
            ...this.dot_opts,
        });

        this.dot2 = new mojs.Shape({
            ...this.dot_opts,
            x: -40,
            delay: 150
        });

        this.dot3 = new mojs.Shape({
            ...this.dot_opts,
            x: 40,
            delay: 100
        });

      },
      methods: {
          fileChange (e)
          {
            let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
            this.video = files[0];
          },

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
              var vue = this;
              e.preventDefault();

              var formData = new FormData();
              formData.append('_token', this.token);
              formData.append('title', this.title);
              formData.append('video', this.video);
              formData.append('category', this.category);
              formData.append('section', this.section);
              formData.append('app_category', this.app_category);
              formData.append('app_name', this.app_name);


              this.animationBeforeSend();


              axios.post('/api/apps/video', formData)

                  .then(function(response){
                    console.log(response);
                    vue.animationHideDots();
                    vue.showModal();
                  })

                  .catch(function (error) {
                    console.log(error);
                    vue.animationHideDots();
                    vue.showModal(e);
                  });

              return false;

          },

          animationBeforeSend()
          {


              let dotTimeline = new mojs.Timeline().add(this.dot,this.dot2,this.dot3);

              const hideFormBtnClose = new mojs.Html({
                  el: this.closeFormBtn,
                  opacity: {1 : 0},
                  easing: 'sin.out',
              });

              const hideForm = new mojs.Html({
                  el: this.form,
                  opacity: {1 : 0},
                  easing: 'sin.out',
                  onComplete() {
                    dotTimeline.play();
                  }
              }).play();

              const hide = new mojs.Timeline().add(hideFormBtnClose, hideForm).play();
          },

          animationHideDots ()
          {
            let hide_dots = {
                opacity: {1 : 0},
                y: {20 : 0},
                isYoyo: false,
                repeat: 0,
                duration: 300
            }
            this.dot.tune({
                ...hide_dots
            }).play();

            this.dot2.tune({
                ...hide_dots
            }).play();

            this.dot3.tune({
                ...hide_dots
            }).play();

            // let hide_dots_Timeline = new mojs.Timeline().add(this.dot, this.dots2, this.dot3).play();
          },
      }
  }
</script>

<style scoped>
  .close-btn {
    position: absolute;
    right: 1.5rem;
    top: 1.5rem;
  }
</style>
