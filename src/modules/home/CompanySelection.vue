<template> 
    <div class="container-fluid">
      <br>
      <br>
      <div class="row">
        <div class="col-lg-6 offset-lg-3">
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
                <select class="form-control" v-model="selectedBranch">
                  <option value='' selected hidden>Select a Company or Branches</option>
                  <option v-for="(item, index) in branches" v-bind:value="item.company_branch_id">{{item.company_branch.name}}</option>
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
      branches: [],
      selectedBranch: ''
    }
  },
  methods: {
    getBranches (){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'value': this.user.userID,
          'clause': '='
        }],
        'with_foreign_table': [
          'company_branch'
        ]
      }
      this.APIRequest('company_branch_employee/retrieve', parameter).then(response => {
        this.branches = response.data
      })
    },
    loadSelectedBranch(){
      AUTH.setCompany(1, this.selectedBranch)
      ROUTER.push('/')
    }
  }
}
</script>
<style>
</style>
