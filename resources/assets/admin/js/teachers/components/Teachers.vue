<template>
  <div id="teachers">
    <div class="box green">
      <div class="box-header">
        Teachers
      </div>
      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Students slots</th>
            <th>Password</th>
          </thead>
          <new-teacher />
          <single-teacher
            v-for="teacher in teachers"
            :key="teacher.key"
            :teacher="teacher"
          />
          <new-teacher />
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import NewTeacher from './NewTeacher.vue'
import SingleTeacher from './SingleTeacher.vue'
import axios from 'axios'

import {EventBus} from '_js/EventBus'

export default {
  name: 'Teachers',
  components: {
    NewTeacher,
    SingleTeacher
  },
  data: () => ({
    teachers: []
  }),
  methods: {
    getTeachers: function()
    {
      axios.get('/admin/teacher/get-teachers')
        .then(response => {
          this.teachers = response.data
        })
    },
  },
  mounted()
  {
    this.getTeachers()

    EventBus.$on('admin-teacher-saved', () => {
      this.getTeachers()
    })
  }
}
</script>
<style lang="scss" scoped>
@import '~styles/shared';

  #teachers {
    table.table {
      width: 100%;
      > thead {
        border-top: 2px solid $tfc-dark-green;

        > th {
          border-bottom: 2px solid $tfc-dark-green;
        }
      }

      > tbody {
        border-top: 2px solid $tfc-dark-green;
      }
      > tr {
        > td {
          border-top: 1px solid $tfc-dark-green;
        }
      }
    }
  }


</style>
