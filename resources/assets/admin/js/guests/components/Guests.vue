<template>
  <div id="guests">
    <div class="box green">
      <div class="box-header">
        Guests
      </div>
      <div class="box-body">
        <table class="table table-hover">
          <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
          </thead>
          <new-guest />
          <single-guest
            v-for="guest in guests"
            :key="guest.key"
            :guest="guest"
          />
          <new-guest />
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import NewGuest from './NewGuest.vue'
import SingleGuest from './SingleGuest.vue'
import axios from 'axios'

import {EventBus} from '_js/EventBus'

export default {
  name: 'Guests',
  components: {
    NewGuest,
    SingleGuest
  },
  data: () => ({
    guests: []
  }),
  methods: {
    getGuests: function()
    {
      axios.get('/admin/guest/get-guests')
        .then(response => {
          this.guests = response.data
        })
    },
  },
  mounted()
  {
    this.getGuests()

    EventBus.$on('admin-guest-saved', () => {
      this.getGuests()
    })
  }
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

  #guests {
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
