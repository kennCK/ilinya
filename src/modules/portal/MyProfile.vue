<template>
  <div>
     <div class="personal-info profile-cover text-center">
        <img src="../../assets/img/sample.jpg" height="150" width="150" class="profile-picture rounded-circle">
        <h4>{{userInfo[0].first_name + ' ' + userInfo[0].last_name}}</h4>
      </div>
      <div class="personal-info common">
        <span class="header">
          Basic and Contact Information
          <span>
            <i class="fa fa-pencil pull-right" aria-hidden="true"></i>
          </span>
        </span>
        <span class="content row" v-for="(item,index) in userInfoTitle">
          <label class="title col-xs-6 col-sm-3">{{item}}</label>
          <label class="value col-xs-6 col-sm-9">{{userInfoValue[index]}}</label>
        </span>
      </div>
      <div class="personal-info common">
        <span class="header">
          Work
        </span>
        <span class="row company-info" v-for="item in userCompany">
          <span class="col-sm-12 col-md-3 text-center">
            <img src="../../assets/img/sample.jpg" height="80" width="80" class="company-logo rounded">
          </span>
          <span class="col-sm-12 col-md-9">
            <span class="company-more-info">
              <i class="fa fa-info-circle pull-right"></i>
            </span>
            <label>{{item.company_branch.name}}</label>
            <p>Employee ID: {{item.employee_id}} <br />
            Date Started: {{item.created_at}}</p>
          </span>
        </span>
        <span class="content">
        </span>
      </div>
      <div class="personal-info common">
        <span class="header">
          Account Information
          <span>
            <i class="fa fa-pencil pull-right" aria-hidden="true"></i>
          </span>
        </span>
        <span class="content row" v-for="(item,index) in accountInfoTitle">
          <label class="title col-xs-6 col-sm-3">{{item}}</label>
          <label class="value col-xs-6 col-sm-9">{{accountInfoValue[index]}}</label>
        </span>
      </div>
    </div>
  </div>
</template>
<script>
import AUTH from '../../services/auth'
export default{
  name: '',
  components: {
    'module': require('components/common_module/CommonModule.vue')
  },
  create(){
  },
  mounted(){
    this.getAccountInformations()
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      userInfo: [],
      userInfoTitle: [],
      userInfoValue: [],
      userCompany: [],
      accountInfoTitle: [],
      accountInfoValue: []
    }
  },
  props: {
  },
  methods: {
    getAccountInformations(){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'value': this.user.userID,
          'clause': '='
        }],
        'with_foreign_table': [
          'account'
        ]
      }
      this.APIRequest('account_information/retrieve', parameter).then(response => {
        this.userInfo = response.data
        this.getAccountCompanies(response.data)
        this.manageData(response.data)
      })
    },
    getAccountCompanies(data){
      let parameter = {
        'condition': [{
          'column': 'account_information_id',
          'value': data[0].id,
          'clause': '='
        }],
        'with_foreign_table': [
          'company_branch'
        ]
      }
      this.APIRequest('company_branch_employee/retrieve', parameter).then(response => {
        this.userCompany = response.data
        console.log(response.data)
      })
    },
    manageData(data){
      this.userInfoTitle.push('Name', 'Birth Date', 'Sex', 'Marital Status', 'Telephone Number', 'Cellular Number', 'Current Address', 'Home Address')
      let name = data[0].first_name + ' ' + data[0].middle_name + ' ' + data[0].last_name
      this.userInfoValue.push(name, data[0].birth_date, data[0].sex, data[0].marital_status, data[0].telephone_number, data[0].cellular_number, data[0].current_address, data[0].home_address)
      this.accountInfoTitle.push('Username', 'Email Address', 'Date Started')
      this.accountInfoValue.push(data[0].account.username, data[0].account.email, data[0].created_at)
    }
  }
}
</script>
<style scoped>
.personal-info{
  min-height: 250px;
  width: 100%;
  float: left;
  overflow: hidden; 
}
.profile-cover{
  border-top-left-radius:5px;
  border-top-right-radius:5px;  
  color: #fff;
  background: #006600;
}
.profile-picture{
  margin: 25px 0 5px 0;
  border-color: solid 2px #000;
}
.common{
 margin: 20px 5% 20px 5%; 
 width: 90%;
}

.common .header{
  font-size: 24px;
  font-weight: 600;
  float: left;
  width: 100%;
}

.common .content, .company-info{
  float: left;
  width: 90%;
  margin:0 5% 0 5%;
  min-height: 50px;
  overflow: hidden;
  border-bottom: solid 1px #ddd;
}
.content label{
  padding: 15px 0 10px 0;
  vertical-align: middle;
  float: left;
}
.content .title{
  color: #777;
}
.content .value{
  font-weight: 400;
}
.company-more-info i{
  font-size: 24px;
  color: #006600;
}
.company-more-info i:hover{
  cursor: pointer;
  color: #009900;
}
</style>
