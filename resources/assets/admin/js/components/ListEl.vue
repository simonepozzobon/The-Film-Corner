<template>
  <tbody>
    <tr id="list-el">
      <td ref="items" v-for="(option, key, index) in options" :key="option.key" @click="edit" :data-property="option.title">{{get_property(option.title)}}</td>
    </tr>
    <tr>
      <td id="tools" ref="tools"  colspan="42">
        <div class="form-group">
          <label for="">Language:</label>
          <select class="form-control" v-model="language">
            <option v-for="language in languages" :key="language.key" :value="language.id">{{language.short}}</option>
          </select>
        </div>
        <div class="form-group">
          <label for="">Translation:</label>
          <textarea name="name" rows="8" cols="80" class="form-control" v-model="translation"></textarea>
        </div>
        <div class="d-flex justify-content-center">
          <a href="#" :class="'btn btn-'+color" @click="save"><i class="fa fa-floppy-o"></i> Save</a>
        </div>
      </td>
    </tr>
  </tbody>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'
import _ from 'lodash'
import axios from 'axios'

export default {
  name: "list-el",
  props: ['item', 'options', 'languages', 'color'],
  data: () => ({
    toolbar: {
      status: false,
      obj: '',
    },
    language: '',
    translation: '',
    property: '',
  }),
  computed: {
    opt_lenght: function ()
    {
      return this.options.length;
    }
  },
  methods: {
    get_property(val)
    {
        var property = _.pick(this.item, val);
        return Object.values(property)[0];
    },

    edit(e)
    {
        if (this.toolbar.status == false) {
          this.show_tools(e);
          this.property = e.target.dataset.property;
        } else {

        }
    },

    show_tools(e)
    {
        this.toolbar.status = true;
        this.toolbar.obj = e.target;

        var t1 = new TimelineMax();
        t1.to(e.target, .4, {
          background: 'rgba(255, 255, 255, 0.4)',
          easing: Power4.easeInOut
        });

        var t2 = new TimelineMax();
        t2.to(this.$refs.tools, .4, {
          opacity: 1,
          display: 'table-cell',
          easing: Power4.easeInOut
        });

        var master = new TimelineMax();
        master.add(t1);
        master.add(t2, .4);
        master.play();
    },

    save()
    {
        var vue = this;
        var data = new FormData();
        data.append('translation', this.translation);
        data.append('language', this.language);
        data.append('property', this.property);
        data.append('translable_id', this.item.id);
        data.append('translable_type', this.item.model);

        axios.post('/admin/translate/save', data)
        .then(response => {
          console.log(response);
        }).catch(errors => {
          console.log(errors);
        })
    }

  }
}
</script>
<style lang="scss" scoped>

  #tools {
    display: none;
    opacity: 0;
  }

</style>
