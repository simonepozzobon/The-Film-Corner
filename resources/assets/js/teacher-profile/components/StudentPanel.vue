<template>
  <div id="student-panel">
    <div class="box yellow">
      <div class="box-header">
        <div class="content">
          {{ title }}
        </div>
        <div class="tools">
          <i id="close" ref="close_btn" class="fa fa-times" @click="closePanel"></i>
        </div>
      </div>
      <div class="box-body">
        <div ref="students_grid" class="students">
          <single-student v-for="student in studentsArr" :key="student.key" :student="student" class="student"/>
          <empty-slot class="student" v-for="slot in slots" :key="slot.key"/>
        </div>
        <div id="student-detail" class="student-detail" ref="student_detail">
          <div class="content">
            <h4>{{obj.name}}</h4>
            <p>
              {{obj.email}}
            </p>
            <div class="d-flex justify-content-center">
              <button class="btn btn-yellow mr-2" @click="showEditPanel"><i class="fa fa-edit"></i></button>
              <button class="btn btn-yellow" @click="askConfirmation"><i class="fa fa-trash-o"></i></button>
            </div>
          </div>
        </div>
        <div id="edit-student" ref="edit_student">
          <div class="content">
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" v-model="user.name" class="form-control">
            </div>
            <div class="form-group">
              <label for="">E-mail</label>
              <input type="text" v-model="user.email" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="text" v-model="user.password" class="form-control">
            </div>
            <div class="d-flex justify-content-center">
              <button class="btn btn-yellow" @click="editStudent">
                <i class="fa fa-floppy-o"></i> Save
              </button>
            </div>
          </div>
        </div>
        <div id="confirmation" ref="confirmation">
          <div class="content">
            <h4>Pay Attention!</h4>
            <p>This operation can't be undone</p>
            <div class="d-flex justify-content-center mt">
              <button class="btn btn-yellow mr-2" @click="deleteStudent"><i class="fa fa-trash-o"></i> Yes</button>
              <button class="btn btn-yellow" @click="undoDelete"><i class="fa fa-undo"></i> No</button>
            </div>
          </div>
        </div>
        <div id="new-student" ref="new_student">
          <div class="content">
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" v-model="user.name" class="form-control">
            </div>
            <div class="form-group">
              <label for="">E-mail</label>
              <input type="text" v-model="user.email" class="form-control">
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="text" v-model="user.password" class="form-control">
            </div>
            <div class="d-flex justify-content-center">
              <button class="btn btn-yellow" @click="saveStudent">
                <i class="fa fa-floppy-o"></i> Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import SingleStudent from './SingleStudent.vue'
import EmptySlot from './EmptySlot.vue'

import axios from 'axios'
import {TweenMax, TimelineMax, Power4} from 'gsap'

export default {
  name: 'StudentPanel',
  props: {
    title: {
      type: String,
      default: 'Students',
    },
    students: {
      type: Array,
      default: function() {}
    }
  },
  data: () => ({
    slots: 0,
    panel: {
      status: false,
      target: ''
    },
    obj: [],
    user: {
      name: '',
      email: '',
      password: ''
    },
    studentsArr: []
  }),
  created()
  {
    this.get_slots()
    this.studentsArr = this.students
  },
  mounted()
  {
    this.$on('show-user-detail', student => {
      this.obj = student
      this.showUserDetail()
      this.showCloseBtn(this.$refs.student_detail)
    })

    this.$on('show-new-user-form', () => {
      this.showNewUserForm()
      this.showCloseBtn(this.$refs.new_student)
    })
  },
  methods: {
    get_slots: function()
    {
      var vue = this
      axios.get('/teacher/settings/get-slots')
        .then((response) => {
          vue.slots = response.data.slots_available
        })
    },

    showUserDetail: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.students_grid, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.student_detail, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)
      master.play()
    },

    showNewUserForm: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.students_grid, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.new_student, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)
      master.play()

      this.user = { name: '', email: '', password: '' }
    },

    showCloseBtn: function(el)
    {
      TweenMax.to(this.$refs.close_btn, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      this.panel = { obj: el, status: true }
    },

    closePanel: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.panel.obj, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.close_btn, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t3 = new TimelineMax()
      t3.to(this.$refs.students_grid, .4, {
        opacity: 1,
        display: 'flex',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2)
      master.add(t3, .4)
      master.play()

      this.panel = { obj: [], status: false }
    },

    saveStudent: function()
    {
      var vue = this
      var data = new FormData()
      data.append('name', this.user.name)
      data.append('email', this.user.email)
      data.append('password', this.user.password)

      axios.post('/teacher/settings/save-student', data)
        .then(response => {
          vue.studentsArr.push(response.data)
          vue.slots--
          vue.closePanel()
          vue.user = { name: '', email: '', password: '' }
        })
    },

    askConfirmation: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.student_detail, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.confirmation, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()

      this.panel = { obj: this.$refs.confirmation, status: true }
    },

    undoDelete: function()
    {
      this.closePanel()
    },

    deleteStudent: function()
    {
      var vue = this
      var data = new FormData()
      data.append('id', this.obj.id)
      axios.post('/teacher/settings/destroy-student', data)
        .then(response => {
          vue.studentsArr = vue.studentsArr.filter((value) => {
            return value.id != response.data.id
          })
          vue.slots++
          vue.closePanel()
        })
    },

    showEditPanel: function()
    {
      var t1 = new TimelineMax()
      t1.to(this.$refs.student_detail, .4, {
        opacity: 0,
        display: 'none',
        easing: Power4.easeInOut
      })

      var t2 = new TimelineMax()
      t2.to(this.$refs.edit_student, .4, {
        opacity: 1,
        display: 'inherit',
        easing: Power4.easeInOut
      })

      var master = new TimelineMax()
      master.add(t1)
      master.add(t2, .4)
      master.play()

      this.panel = { obj: this.$refs.edit_student, status:true }
      this.user = { name: this.obj.name, email: this.obj.email, password: '' }
    },

    editStudent: function()
    {
      var vue = this
      var data = new FormData()
      data.append('name', this.user.name)
      data.append('email', this.user.email)
      data.append('password', this.user.password)

      axios.post('/teacher/settings/update-student', data)
        .then(response => {
          var foundIndex = vue.studentsArr.findIndex(x => x.id == response.data.id)
          vue.studentsArr[foundIndex] = response.data
          vue.closePanel()
        })
    },

  },
  components: {
    SingleStudent,
    EmptySlot
  }
}
</script>
<style lang="scss" scoped>
  @import '~styles/variables';

  .box-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .box-body {
    padding-left: 0;
    padding-right: 0;
    padding-bottom: 0;
  }

  .students {
    padding-left: $spacer / 2;
    padding-right: $spacer / 2;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;

    > .student {
      margin-right: $spacer / 2;
      margin-left: $spacer / 2;
      margin-bottom: $spacer;
    }
  }

  #student-detail {
    > .content {
      > h4 {
        text-transform: capitalize;
      }
    }
  }

  #student-detail,
  #new-student,
  #confirmation,
  #edit-student {
    opacity: 0;
    display: none;

    > .content {
      padding-left: $spacer;
      padding-right: $spacer;
      padding-bottom: $spacer;
      text-align: left;
    }
  }

  #close {
    opacity: 0;
    display: none;
  }

</style>
