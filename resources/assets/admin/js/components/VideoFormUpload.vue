<template>
    <div class="video-form-upload">
      <!-- Button -->
      <div class="d-flex justify-content-around">
        <button @click="showModal" type="button" name="button" class="btn btn-lg btn-secondary btn-blue" ref="show-modal-btn">
            Carica Video
        </button>
      </div>

      <div @click="closeModal" class="d-flex justify-content-end close-btn" ref="close-form-btn">
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
        <div class="row">
          <div class="col">
            <h6>Libreria</h6>
            <div class="form-group">
              <select class="form-control" name="sub_category" v-model="sub_category">
                <option v-for="sub_cat in sub_cats" :value="sub_cat.id">
                  {{ sub_cat.name }}
                </option>
              </select>
            </div>
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
  import _ from 'lodash';
  import axios from 'axios';
  import MojsPlayer from 'mojs-player';

  export default {
      props: ['token', 'method', 'action', 'options', 'sections', 'app_categories', 'apps'],

      data ()
      {
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
              app_name: '',
              sub_category: '',
              sub_cats: '',
          }
      },

      mounted ()
      {

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

        this._top = this.getOffsetTop(this.form);

        this.dot_opts = {
          shape: 'circle',
          radius: 10,
          y: {[this._top] : this._top - 20},
          fill: 'grey',
          isYoyo: true,
          duration: 500,
          easing: 'sin.in.out',
        }

        this.dot = new mojs.Shape({
            ...this.dot_opts,
            x: -40,
        })
        .then({
            y: {[this._top - 20] : this._top},
            onComplete(isForward, isYoyo) {
                this.replay();
            }
        });

        this.dot2 = new mojs.Shape({
            ...this.dot_opts,
            delay: 50,
        })
        .then({
            y: {[this._top - 20] : this._top},
            onComplete(isForward, isYoyo) {
                this.replay();
            }
        });

        this.dot3 = new mojs.Shape({
            ...this.dot_opts,
            x: 40,
            delay: 100,
        })
        .then({
            y: {[this._top - 20] : this._top},
            onComplete(isForward, isYoyo) {
                this.replay();
            }
        });

        class Check extends mojs.CustomShape {
          getShape() {
            return '<g><polyline points="30.8022923 48.799683 45.3869007 62.9078069 85.1630931 23.5523084"></polyline></g>';
          }
          getLength() { return 76.5; }

        }

        mojs.addShape( 'check', Check );

        this.circle = new mojs.Shape({
          shape: 'circle',
          className: 'success-circle',
          fill: 'grey',
          radius: {0 : 40},
          easing: 'sin.in',
          duration: 350
        });

        this.check = new mojs.Shape({
          shape: 'check',
          parent: '.success-circle',
          radius: {0 : 20},
          opacity: {0 : 1},
          stroke: 'white',
          strokeWidth: 6,
          strokeLinecap: 'round',
          fill: 'none',
          easing: 'sin.in',
          delay: 100
        });

        this.burst = new mojs.Burst({
          parent: '.success-circle',
          radius: { 20 : 80 },
          count: 10,
          duration: 200,
          children: {
            shape: 'line',
            stroke: 'grey',
            delay: 50
          },
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

          showModal ()
          {
            var vue = this;

            let showForm = new mojs.Html({
                el: this.form,
                height: {0 : vue.formOriginalHeight},
                opacity: {0 : 1},
                y: {'-100' : 0},
                easing: 'sin.in.out',
                delay: 100,
                onStart() {
                  vue.form.style.display = 'inherit';
                }
            });

            let showCloseFormBtn = new mojs.Html({
                el: this.closeFormBtn,
                opacity: {0 : 1},
                y: {'-40' : 0},
                angleZ: {90 : 0},
                easing: 'sin.out',
                delay: 200,
            });

            let showFormTimeline = new mojs.Timeline().add(showForm).append(showCloseFormBtn);


            new mojs.Html({
                el: this.showFormBtn,
                opacity: {1 : 0},
                duration: 150,
                easing: 'sin.in.out',
                onComplete () {
                  showFormTimeline.play();
                }
            })
            .then({
                height: {[this.showFormBtn.offsetHeight] : 0},
            })
            .play();

          },

          closeModal()
          {
              var vue = this;
              let showSendBtn = new mojs.Html({
                  el: this.showFormBtn,
                  opacity: {0 : 1},
                  height: {[vue.showFormBtn.offsetHeight] : vue.showFormOriginalHeight},
                  easing: 'sin.out',
              });

              let hideForm = new mojs.Html({
                  el: this.form,
                  opacity: {1 : 0, duration: 350},
                  y: {0 : '-100'},
                  easing: 'sin.in.out',
                  duration: 500,
                  onComplete () {
                      showSendBtn.play();
                      vue.form.style.display = 'none';
                  }
              }).then({
                  height: {[vue.showFormOriginalHeight] : 0},
              });

              let hideCloseFormBtn = new mojs.Html({
                  el: this.closeFormBtn,
                  opacity: {1 : 0},
                  y: {0 : '-40'},
                  angleZ: {0 : 90},
                  easing: 'sin.in',
                  duration: 100,
              });

              let hideFormTimeline = new mojs.Timeline().add(hideCloseFormBtn).append(hideForm).play();

              // new MojsPlayer({add:hideFormTimeline});
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
              formData.append('sub_category', this.sub_category);

              this.animationBeforeSend();

              axios.post('/api/apps/video', formData)
              .then(function(response){
                console.log(response);
                vue.title = '';
                vue.video = '';
                vue.category = '';
                vue.section = '';
                vue.app_category = '';
                vue.app_name = '';
                vue.sub_category = '';

                vue.animationHideDots();
                alert('uploaded');
                vue.animationShowSuccess();
                _.delay(() => {
                  vue.closeModal();
                  vue.$parent.$emit('newVideoLoaded', response.data);
                }, 1000);

              })
              .catch(function (error) {
                console.log(error);
                _.delay(() => {
                  vue.animationHideDots();
                  vue.showModal()
                }, 250);
              });

          },

          animationBeforeSend()
          {
              var vue = this;
              this.dot.play();
              this.dot2.play();
              this.dot3.play();

              let hideFormBtnClose = new mojs.Html({
                  el: this.closeFormBtn,
                  opacity: {1 : 0},
                  easing: 'sin.out',
              });

              let hideForm = new mojs.Html({
                  el: this.form,
                  opacity: {1 : 0},
                  easing: 'sin.out',
                  onComplete() {
                    vue.dot.play();
                    vue.dot2.play();
                    vue.dot3.play();
                  }
              }).play();

              let hide = new mojs.Timeline().add(hideFormBtnClose, hideForm).play();

          },

          animationHideDots ()
          {
            var vue = this;
            this.dot.tune({
                opacity: {1 : 0},
            }).play().stop();

            this.dot2.tune({
                opacity: {1 : 0},
            }).play().stop();

            this.dot3.tune({
                opacity: {1 : 0},
            }).play().stop();

            // let hide_dots_Timeline = new mojs.Timeline().add(this.dot, this.dots2, this.dot3).play();
          },

          animationShowSuccess()
          {
            let successTimeline = new mojs.Timeline().add(this.circle, this.check, this.burst).play();
            _.delay(() => {
              this.circle.tune({
                radius: {40 : 0},
              });

              this.check.tune({
                radius: {20 : 0},
              });

              let close = new mojs.Timeline().add(this.circle, this.check).play();
            }, 800);


          },

          pavilionRelations(id)
          {
            var vue = this;
                axios.get('/api/apps/relations/pavilion/'+id)
                .then(function(response) {
                    vue.a_cats = response.data.categories;
                    vue.a_names = response.data.apps;
                });
          },

          categoryRelations(id)
          {
              var vue = this;
              axios.get('/api/apps/relations/category/'+id)
              .then(function(response) {
                console.log(response);
                  vue.secs = [response.data.pavilion];
                  vue.section = response.data.pavilion.id;
                  vue.a_names = response.data.apps;
              });
          },

          appRelations(id)
          {
              var vue = this;
              axios.get('/api/apps/relations/app/'+id)
              .then(function(response) {
                  vue.a_cats = [response.data.category];
                  vue.app_category = response.data.category.id;
                  vue.a_names = [response.data.pavilion];
                  vue.section = response.data.pavilion.id
              });
          },

          subCategories(id)
          {
              var vue = this;
              axios.get('/api/apps/relations/media-sub-categories/'+id)
              .then((response) => {
                vue.sub_cats = response.data;
              });
          },

          getOffsetLeft (elem)
          {
              var offsetLeft = 0;
              do {
                if ( !isNaN( elem.offsetLeft ) )
                {
                    offsetLeft += elem.offsetLeft;
                }
              } while( elem = elem.offsetParent );
              return offsetLeft;
          },

          getOffsetTop (elem)
          {
              var offsetTop = 0;
              do {
                if ( !isNaN( elem.offsetTop ) )
                {
                    offsetTop += elem.offsetTop;
                }
              } while( elem = elem.offsetParent );
              return offsetTop;
          },

          deleteEl(el)
          {
              if (el) {
                   el.parentNode.removeChild(el);
              }
          },
      },

      watch: {
        section: function(id)
        {
            this.pavilionRelations(id);
        },

        app_category: function(id)
        {
            this.categoryRelations(id);
        },

        app_name: function(id)
        {
            if (this.app_category == '' || this.section == '')
            {
                this.appRelations(id);
            }
            this.subCategories(id);
        }
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
