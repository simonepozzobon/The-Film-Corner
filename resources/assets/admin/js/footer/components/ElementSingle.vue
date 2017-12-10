<template>
  <tbody id="element-single">
    <tr @click="editRow">
      <td>{{ col_1 }}</td>
      <td>{{ col_2 }}</td>
    </tr>
    <tr
      id="edit-row"
      ref="edit_row"
      class="align-middle"
    >
      <td v-if="type=='filmography'">
        <label>{{ this.field_1 }}</label>
        <input
          type="text"
          class="form-control"
          v-model="film.title"
        >
      </td>
      <td v-else>
        <label>{{ this.field_1 }}</label>
        <input
          type="text"
          class="form-control"
          v-model="credit.name"
        >
      </td>
      <td v-if="type=='filmography'">
        <label>{{ this.field_2 }}</label>
        <textarea
          rows="8"
          class="form-control"
          v-model="film.description"
        />
      </td>
      <td v-else>
        <label>{{ this.field_2 }}</label>
        <input
          type="text"
          class="form-control"
          v-model="credit.role"
        >
      </td>
      <td class="savebtn">
        <button
          class="btn btn-blue"
          @click="saveEdits"
        >
          <i class="fa fa-floppy-o"/> Save
        </button>
      </td>
    </tr>
  </tbody>
</template>
<script>
import {TweenMax, Power4} from 'gsap'
import axios from 'axios'

export default {
  name: 'ElementSingle',
  props: {
    field_1: {
      default: '',
      type: String
    },
    field_2: {
      default: '',
      type: String
    },
    col_1: {
      default: '',
      type: String
    },
    col_2: {
      default: '',
      type: String
    },
    element: {
      default: function() {},
      type: Object
    },
    type: {
      default: '',
      type: String
    }
  },
  data: () => ({
    film: {
      title: '',
      description: ''
    },
    credit: {
      name: '',
      role: ''
    },
    status: false
  }),
  methods: {
    editRow: function()
    {
      if (!this.status) {
        this.openEdit()
      } else {
        this.closeEdit()
      }
    },
    saveEdits: function()
    {
      var data = new FormData()
      data.append('id', this.element.id)

      if (this.type == 'filmography') {
        // edit filmography
        data.append('title', this.film.title)
        data.append('description', this.film.description)

        axios.post('/admin/footer/update_filmography', data)
          .then(response => {
            this.closeEdit()
            this.$parent.$emit('filmography-updated', response.data)
          })
      } else {
        // edit credit
        data.append('name', this.credit.name)
        data.append('role', this.credit.role)

        axios.post('/admin/footer/update_credit', data)
          .then(response => {
            this.closeEdit()
            this.$parent.$emit('credit-updated', response.data)
          })
      }
    },
    openEdit: function()
    {
      TweenMax.to(this.$refs.edit_row, .4, {
        opacity: 1,
        display: 'table-row',
        easing: Power4.easeInOut
      })
      this.status = true
    },
    closeEdit: function()
    {
      TweenMax.to(this.$refs.edit_row, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })
      this.status = false
    }
  },
  created()
  {
    if (this.type == 'filmography') {
      this.film.title = this.col_1
      this.film.description = this.col_2
    } else {
      this.credit.name = this.col_1
      this.credit.role = this.col_2
    }
  }
}
</script>
<style lang="scss" scoped>

  #edit-row {
    display: none;
    opacity: 0;
  }

</style>
