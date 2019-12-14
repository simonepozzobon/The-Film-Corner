<template>
  <tbody id="new-teacher">
    <tr
      id="new"
      ref="new"
    >
      <td
        colspan="4"
        class="text-center"
      >
        <button
          class="btn btn-green"
          @click="newPanel"
        >
          <i class="fa fa-plus"/> New Teacher
        </button>
      </td>
    </tr>
    <tr
      id="new-panel"
      ref="new_panel"
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
          name="students_slots"
          v-model="students_slots"
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
  name: 'NewTeacher',
  data: () => ({
    name: '',
    email: '',
    students_slots: 0,
    password: ''
  }),
  methods: {
    newPanel: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.new, .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
        .staggerTo([this.$refs.new_panel, this.$refs.save_edit], .4, {
          opacity: 1,
          display: 'table-row',
          ease: Power4.easeInOut
        }, .1)
    },
    undoEdit: function()
    {
      var t1 = new TimelineMax()
      t1.to([this.$refs.new_panel, this.$refs.save_edit], .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
        .to(this.$refs.new, .4, {
          opacity: 1,
          display: 'table-row',
          ease: Power4.easeInOut
        })
    },
    saveEdit: function()
    {
      var data = new FormData()
      data.append('name', this.name)
      data.append('email', this.email)
      data.append('students_slots', this.students_slots)
      data.append('password', this.password)

      axios.post('/admin/teacher/new', data)
        .then(response => {
          this.undoEdit()
          EventBus.$emit('admin-teacher-saved', response.data)
        })
    }
  }
}
</script>
<style lang="scss" scoped>

  #new-teacher {
    #new-panel, #save-edit {
      display: none;
      opacity: 0;
    }
  }

</style>
