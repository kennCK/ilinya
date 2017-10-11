<template> 
    <div class="container-fluid">
      <br>
      <br>
      <div class="row">
        <div class="col-md-6 offset-md-4">
          <h4></h4>
          <p><b>Hi {{user.username}}</b>!

          <br/>
          <br/>
          <i>Greetings!</i>
          <br/>
          <br/>
          You have multiple Companies or Branches and you can only load one branch or company at a time. 

          <br/><br/>Please select options below and click load.</p>
        </div>
      </div>
      <div class="row">
          <div class="col-sm-6 offset-sm-3">
              <div class="input-group">
                <select class="form-control" v-model="selectCompany">
                  <option value='' selected hidden>Select a Company or Branches</option>
                  <option v-for="(item, index) in company" v-bind:value="item.id">{{item.name}}</option>
                </select>
              </div>
              <br>
              <div> 
                <button class="btn btn-primary btn-lg pull-right" v-on:click="loadSelectedBranch()">
                <i class="fa fa-spinner" aria-hidden="true"></i> Load
                </button>  
              </div>
          </div>
      </div>
    </div><!-- /row -->
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  mounted(){
    this.getBranches()
  },
  data(){
    return{
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      company: [],
      selectCompany: ''
    }
  },
  methods: {
    getBranches (){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'value': this.user.userID,
          'clause': '='
        }]
      }
      this.APIRequest('company/retrieve', parameter).then(response => {
        this.company = response.data
      })
    },
    loadSelectedBranch(){
      AUTH.setCompany(1, this.selectCompany)
      ROUTER.push('dashboard')
    }
  }
}
</script>
<style>
</style>
