<template>
  <div id="student-panel">
    <div class="box yellow">
      <div class="box-header">
        <div class="content">
          Students
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
    opacity: 0;
    display: none;

    > .content {
      padding-left: $spacer;
      padding-right: $spacer;
      padding-bottom: $spacer;
      text-align: left;
    }
  }

  #new-student {
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
