<template>
  <div id="welcome-form" class="box blue">
      <div class="box-header">
        Short Introduction
      </div>
      <div class="box-body">
        The Film Corner is the interactive web platform dedicated to cinema,
        a website where you can surf through different STUDIOS and the corresponding educational projects,
        discovering and exploring the many aspects that underpin cinematographic language and grammar.<br>
        <br>
        We all have a relationship with cinema. The word “cinema” means something to each one of us,
        it reminds us of other worlds and other aspects of our lives. What is cinema for you?
        <strong>Think of 3 key words to describe your own relationship with cinema and write them in the cloud below.</strong><br>

        <div class="row pt">
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="First word..." v-model="word_1">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Second word..." v-model="word_2">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Third word..." v-model="word_3">
            </div>
          </div>
        </div>

        <br>
        Cinema is something big, something that often characterizes and enters our lives and we can experience in different ways.<br>
        However, when we decided to create The Film Corner, we asked ourselves which of these many aspects we would have liked to talk about.
        The answer we came up with is that The Film Corner would talk about two specific aspects of cinema: the formal and the creative ones.<br>
        <br>
        The reason why we wanted to approach cinema from this point of view is to be found in a question that we’d like you to try and answer:
        when you are watching a film, what is it that really gets to you of what you are seeing?
        <strong>Try and answer this question, then write your answer in the grid below.</strong><br>

        <div class="row pt">
          <div class="col">
            <div class="form-group">
              <textarea rows="4" class="form-control" placeholder="Your answer..." v-model="answer"></textarea>
            </div>
          </div>
        </div>

        <br>
        Usually, the first piece of information that gets to us when watching a film is the emotion, which comes before we can even have the
        time to really start reflecting on what we see (the positioning of the camera, the editing choices, the selection of the soundtrack, etc.).
        Love, joy, hilarity, sadness, despair, detachment, coldness, or even concern, anguish, fear, are indeed emotions, sensations.
        But how does cinema do it? Behind each emotion we feel with cinema lays a conscious choice made by whoever made the film.
        In every picture there is a direct, and often very stark relationship between the emotions we feel and the visual, linguistic and grammatical
        choices made by the film creators. It may sound obvious, but there is a direct bond between creativity and critical reception of a film.
        That’s why we are interested in these two aspects!
      </div>
  </div>
</template>
<script>
import axios from 'axios'
export default {
  name: "welcome-form",
  props: ['user', 'user_type', 'form'],
  data: () => ({
      word_1: '',
      word_2: '',
      word_3: '',
      answer: ''
  }),
  computed: {

      userParsed: function()
      {
          return JSON.parse(this.user);
      },

      formParsed: function()
      {
          return JSON.parse(this.form);
      }
  },
  watch: {
      word_1: function(new_word)
      {
          this.save();
      },
      word_2: function(new_word)
      {
          this.save();
      },
      word_3: function(new_word)
      {
          this.save();
      },
      answer: function(new_answer)
      {
          this.save();
      }
  },
  created() {
      this.word_1 = this.properNull(this.formParsed.word_1);
      this.word_2 = this.properNull(this.formParsed.word_2);
      this.word_3 = this.properNull(this.formParsed.word_3);
      this.answer = this.properNull(this.formParsed.answer);
  },
  methods: {
      // save the form
      save: _.debounce(
          function()
          {
              var vue = this;
              var data = new FormData();
              data.append('user', this.user);
              data.append('user_type', this.user_type);
              data.append('word_1', this.word_1);
              data.append('word_2', this.word_2);
              data.append('word_3', this.word_3);
              data.append('answer', this.answer);

              //send the request
              axios.post('/api/v1/welcome/save', data)
              .then(response => {
                  console.log(response);
              })
              .catch(errors => {
                  console.log(errors);
              })
          }
      , 500),

      properNull(value)
      {
          if (value == 'null') {
            return value = null;
          } else {
            return value;
          }
      }
  }
}
</script>
<style lang="scss" scoped>
</style>
