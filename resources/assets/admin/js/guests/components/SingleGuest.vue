<template>
  <tbody id="single-guest">
    <tr
      ref="guest"
      @click="editPanel"
    >
      <td>{{ guest.name }}</td>
      <td>{{ guest.email }}</td>
      <td>****</td>
    </tr>
    <tr
      id="edit"
      ref="edit"
    >
      <td>
        <input
          type="text"
          name="name"
          v-model="name"
          class="form-control"
        >
      </td>
      <td>
        <input
          type="email"
          name="email"
          v-model="email"
          class="form-control"
        >
      </td>
      <td>
        <input
          type="text"
          name="password"
          v-model="password"
          class="form-control"
        >
      </td>
    </tr>
    <tr
      id="save-edit"
      ref="save_edit"
    >
      <td
        colspan="4"
        class="text-center"
      >
        <button
          class="btn btn-green"
          @click="undoEdit"
        >
          <i class="fa fa-undo"/> Cancel
        </button>
        <button
          class="btn btn-green"
          @click="deleteGuest"
        >
          <i class="fa fa-trash-o"/> Delete
        </button>
        <button
          class="btn btn-green"
          @click="saveEdit"
        >
          <i class="fa fa-floppy-o"/> Save
        </button>
      </td>
    </tr>
  </tbody>
</template>
<script>
import {TimelineMax, Power4} from 'gsap'
import axios from 'axios'

import {EventBus} from '_js/EventBus'

export default {
  name: 'SingleGuest',
  props: {
    guest: {
      type: Object,
      default: function() {
        return {
          name: '',
          email: '',
          students_slots: 0
        }
      }
    }
  },
  data: () => ({
    name: '',
    email: '',
    students_slots: 0,
    password: ''
  }),
  methods: {
    editPanel: function()
    {
      this.name = this.guest.name
      this.email = this.guest.email
      this.students_slots = this.guest.students_slots

      var t1 = new TimelineMax()
      t1.to(this.$refs.guest, .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
        .staggerTo([this.$refs.edit, this.$refs.save_edit], .4, {
          opacity: 1,
          display: 'table-row',
          ease: Power4.easeInOut
        }, .1)
    },
    undoEdit: function()
    {
      this.name = this.guest.name
      this.email = this.guest.email
      this.students_slots = this.guest.students_slots

      var t1 = new TimelineMax()
      t1.to([this.$refs.edit, this.$refs.save_edit], .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
        .to(this.$refs.guest, .4, {
          opacity: 1,
          display: 'table-row',
          ease: Power4.easeInOut
        })
    },
    saveEdit: function()
    {
      var data = new FormData()
      data.append('id', this.guest.id)
      data.append('name', this.name)
      data.append('email', this.email)
      data.append('students_slots', this.students_slots)
      data.append('password', this.password)

      axios.post('/admin/guest/save', data)
        .then(response => {
          this.undoEdit()
          EventBus.$emit('admin-guest-saved', response.data)
        })
    },
    deleteGuest: function()
    {
      var data = new FormData()
      data.append('id', this.guest.id)

      axios.post('/admin/guest/delete', data)
        .then(response => {
          this.undoEdit()
          EventBus.$emit('admin-guest-saved', response.data)
        })
    }
  }
}
</script>
<style lang="scss" scoped>

#single-guest {
  #edit, #save-edit {
    opacity: 0;
    display: none;
  }
}

</style>
