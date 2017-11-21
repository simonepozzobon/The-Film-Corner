<template>
  <div id="keywords-list" >
    <div class="box green">
      <div class="box-header">
        Glossary
      </div>
      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <th>Category</th>
            <th>Name</th>
            <th>Description</th>
          </thead>
          <tbody v-for="word in wordsParsed" :key="word.key">
            <tr>
              <td>{{category(this, word)}}</td>
              <td>{{word.name}}</td>
              <td v-html="word.description"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="box-btns">
        <a href="#" class="btn btn-green" @click="add_word"><i class="fa fa-plus"></i> Add Keyword</a>
      </div>
    </div>
    <div ref="create" id="create" class="box orange mt">
      <div class="box-header">
        Add new Keyword
        <div class="close">
          <button class="btn bnt-secondary" @click="close_panel"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Didactical Path:</label>
              <select class="form-control" v-model="key_category">
                <option value="0">No categorie</option>
                <option v-for="category in categoriesParsed" :key="category.key" :value="category.id">{{category.name}}</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="">Word:</label>
              <input class="form-control" type="text" v-model="key_word">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="">Description:</label>
            <textarea class="form-control" v-model="key_description"></textarea>
          </div>
        </div>
      </div>
      <div class="box-btns">
        <button class="btn btn-orange" @click="save"><i class="fa fa-floppy-o"></i> Save</button>
      </div>
    </div>
  </div>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'
import _ from 'lodash'
import axios from 'axios'

export default {
  name: "keywords-list",
  props: ['words', 'categories'],
  computed: {
    wordsParsed: function()
    {
        return JSON.parse(this.words);
    },

    categoriesParsed: function()
    {
        return JSON.parse(this.categories);
    },
  },
  data: () => ({
    keywords: [],
    key_category: 0,
    key_description: '',
    key_word: '',
  }),
  created()
  {
      this.init();
  },
  methods: {
    init()
    {
        this.keywords = this.wordsParsed;
    },

    category(e, word)
    {
        var id = word.app_category_id;
        var category = _.find(this.categoriesParsed, (cat) => {
            return cat.id == id;
        })
        if (typeof(category) != 'undefined') {
          return category.name
        } else {
          return null
        }
    },

    add_word(e)
    {
        e.preventDefault();
        this.show_panel()
    },

    show_panel()
    {
        var t1 = new TimelineMax();
        t1.to(this.$refs.create, .4, {
          opacity: 1,
          display: 'inherit'
        });
    },

    close_panel()
    {
        var t1 = new TimelineMax();
        t1.to(this.$refs.create, .4, {
          opacity: 0,
          display: 'none'
        });
    },

    save()
    {
        var vue = this;
        var data = new FormData();
        data.append('category', this.key_category);
        data.append('name', this.key_word);
        data.append('description', this.key_description);

        axios.post('/admin/apps/glossary', data)
        .then(response => {
          console.log(response);
          var keyword = response.data;
          vue.keywords.push(keyword);
          vue.key_description = '';
          vue.key_category = 0;
          vue.key_word = '';
        })
        .catch(errors => {
          console.log(errors);
        });
    }


  }
}
</script>
<style lang="scss" scoped>

  #create {
    display: none;
    opacity: 0;
  }

</style>
