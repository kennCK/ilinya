<template>
  <div>
     <div class="personal-info profile-cover text-center">
        <img v-bind:src="accountProfileDirectory + profilePicture" height="150" width="150" class="profile-picture rounded-circle" v-if="profilePicture !== ''">
        <i v-else class="fa fa-user-circle-o"></i>
        <h4>{{username}}</h4>
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
import CONFIG from '../../config'
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
      accountInfoValue: [],
      accountProfileDirectory: CONFIG.BACKEND_URL + '/file/account_profiles/',
      profilePicture: '',
      username: ''
    }
  },
  props: {
  },
  methods: {
    getAccountInformations(){
      let parameter = {
        'condition': [{
          'column': 'id',
          'value': this.user.userID,
          'clause': '='
        }],
        'with_foreign_table': [
          'account_information',
          'account_profile_picture'
        ]
      }
      this.APIRequest('account/retrieve', parameter).then(response => {
        this.userInfo = response.data
        this.username = this.userInfo[0].username
        this.manageData()
        if(this.userInfo[0].account_profile_picture !== null){
          this.profilePicture = this.userInfo[0].account_profile_picture.source
        }
      })
    },
    manageData(){
      this.userInfoTitle.push('Name', 'Birth Date', 'Sex', 'Marital Status', 'Telephone Number', 'Cellular Number', 'Current Address', 'Home Address')
      let info = this.userInfo[0].account_information
      let account = this.userInfo[0]
      let name = this.setName(info)
      this.userInfoValue.push(name, this.setText(info.birth_date), this.setText(info.sex), this.setText(info.marital_status), this.setText(info.telephone_number), this.setText(info.cellular_number), this.setText(info.current_address), this.setText(info.home_address))
      this.accountInfoTitle.push('Username', 'Email Address', 'Date Started')
      this.accountInfoValue.push(account.username, account.email, account.created_at)
    },
    setText(parameter){
      return (parameter === null) ? 'Update your Account Information' : parameter
    },
    setName(parameter){
      if(parameter.first_name === null && parameter.middle_name === null && parameter.last_name === null){
        return 'Update your Account Information'
      }else if(parameter.middle_name === null){
        return parameter.first_name + ' ' + parameter.last_name
      }else{
        return parameter.first_name + ' ' + parameter.middle_name + ' ' + parameter.last_name
      }
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
