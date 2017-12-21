<template>
  <tbody id="single-teacher">
    <tr
      ref="teacher"
      @click="editPanel"
    >
      <td>{{ teacher.name }}</td>
      <td>{{ teacher.email }}</td>
      <td>{{ teacher.students_slots }}</td>
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
          @click="deleteTeacher"
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
  name: 'SingleTeacher',
  props: {
    teacher: {
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
      this.name = this.teacher.name
      this.email = this.teacher.email
      this.students_slots = this.teacher.students_slots

      var t1 = new TimelineMax()
      t1.to(this.$refs.teacher, .4, {
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
      this.name = this.teacher.name
      this.email = this.teacher.email
      this.students_slots = this.teacher.students_slots

      var t1 = new TimelineMax()
      t1.to([this.$refs.edit, this.$refs.save_edit], .4, {
        opacity: 0,
        display: 'none',
        ease: Power4.easeInOut
      })
        .to(this.$refs.teacher, .4, {
          opacity: 1,
          display: 'table-row',
          ease: Power4.easeInOut
        })
    },
    saveEdit: function()
    {
      var data = new FormData()
      data.append('id', this.teacher.id)
      data.append('name', this.name)
      data.append('email', this.email)
      data.append('students_slots', this.students_slots)
      data.append('password', this.password)

      axios.post('/admin/teacher/save', data)
        .then(response => {
          this.undoEdit()
          EventBus.$emit('admin-teacher-saved', response.data)
        })
    },
    deleteTeacher: function()
    {
      var data = new FormData()
      data.append('id', this.teacher.id)

      axios.post('/admin/teacher/delete', data)
        .then(response => {
          this.undoEdit()
          EventBus.$emit('admin-teacher-saved', response.data)
        })
    }
  }
}
</script>
<style lang="scss" scoped>

#single-teacher {
  #edit, #save-edit {
    opacity: 0;
    display: none;
  }
}

</style>
