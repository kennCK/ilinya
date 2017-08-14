<template>
  <div>
    <button @click="showAnnouncementModal" class="btn btn-lg btn-success mx-auto d-block"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Announcement</button>
    <modal ref="announcementModal">
      <div slot="header">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Announcement
      </div>
      <div slot="body">
        <div class="card card-outline-primary mb-5">
          <div class="card-header card-primary text-white">
            Make Announcement
          </div>
          <div class="card-block">
            <div class="col-sm-12">
              <div class="form-group">
                <textarea v-model="announcementMessage" class="form-control" placeholder="Type your announcement here..."></textarea>
              </div>
            </div>
            <div class="col-sm-12 text-right">
              <label v-if="announcementStatus === 'success'" class="text-success">Announcement Sent!</label>
              <label v-if="announcementStatus === 'error'" class="text-danger">Announcement Failed! Please refresh the page and try again.</label>
              <button v-bind:disabled="announcementStatus" @click="announce" class="btn btn-primary"><i class="fa fa-bullhorn" aria-hidden="true"></i> Announce</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div  class="col-sm-12  text-center mb-3">
            <strong>Announcements</strong>
          </div>
          <div  class="col-sm-12">

            <div v-for="latestAnnouncement in latestAnnouncements" class="card card-outline-secondary mb-3">
              <div class="card-block">
                <blockquote class="card-blockquote">
                  <p>{{latestAnnouncement['message']}}</p>
                  <small ><cite title="Date and Time Announced">{{latestAnnouncement['created_at'] | formatDate}}</cite></small>
                </blockquote>
              </div>
            </div>
          </div>
        </div>
      </div>
    </modal>
  </div>
</template>
<script>

  export default{
    name: '',
    components: {
      'modal': require('components/modal/Modal.vue')
    },
    beforeCreate() {
      this.$options.filters.formatDate = this.$options.filters.formatDate.bind(this)
    },
    mounted(){

    },
    data(){
      return {
        latestAnnouncements: {},
        announcementMessage: '',
        announcementStatus: false
      }
    },
    props: {
    },
    methods: {
      announce(){
        this.announcementStatus = 'loading'
        this.APIRequest('announcement/create', {message: this.announcementMessage}, (response) => {
          if(response['data']){
            this.announcementStatus = 'success'
            this.getLatestAnnouncement()
            setTimeout(() => {
              this.announcementMessage = ''
              this.announcementStatus = false
            }, 3000)
          }else{
            this.announcementStatus = 'error'
          }
        })
      },
      getLatestAnnouncement(){
        this.APIRequest('announcement/retrieve', {limit: 5, sort: {created_at: 'desc'}}, (response) => {
          if(response['data']){
            this.latestAnnouncements = response['data']
          }
        })
      },
      showAnnouncementModal(){
        this.getLatestAnnouncement()
        this.$refs.announcementModal.showModal()
      }
    },
    filters: {
      formatDate(value){
        let dateTime = new Date(value)
        return this.monthWord(dateTime.getMonth()) + ' ' + dateTime.getDate() + ', ' + dateTime.getFullYear() + ' ' + this.formatTime(dateTime)
      }
    }

  }
</script>
<style scoped>
</style>
