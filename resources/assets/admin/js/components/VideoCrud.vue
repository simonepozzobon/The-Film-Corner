<template>
  <table class="table table-hover">
    <thead>
      <th>Id</th>
      <th>Title</th>
      <th>Image</th>
      <th>Percorso</th>
      <th>Tools</th>
    </thead>
    <tbody>
      <tr v-for="video in videos">
        <td class="align-middle">{{video.id}}</td>
        <td class="align-middle">{{video.title}}</td>
        <td class="align-middle">
            <img :src="video.img" class="img-fluid" width="57">
        </td>
        <td class="align-middle">Path</td>
        <td  class="align-middle">
          <button href="#" class="btn btn-secondary btn-orange"><i class="fa fa-trash-o"></i></button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import axios from 'axios';

export default {
    props: ['items', 'msg'],
    data () {
        return {
          videos: '',
          // msg: '',
        }
    },
    mounted () {
      var vue = this;

      this.$parent.$on('newVideoLoaded', function(response) {
        vue.addVideo(response);
      });

      this.videos = JSON.parse(this.items);
    },
    methods: {
      addVideo (response)
      {
          console.log('triggered method inside');
          console.log(response);
          var newVideo = {
            id: response.video.id,
            title: response.video.title,
            img: response.video.img
          }
          this.videos.unshift(newVideo);
      }
    }
}
</script>

<style scoped>
</style>
