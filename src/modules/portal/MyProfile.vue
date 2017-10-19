<template>
  <div>
<!--      <div class="personal-info profile-cover text-center">
        <img v-bind:src="accountProfileDirectory + profilePicture" height="150" width="150" class="profile-picture rounded-circle" v-if="profilePicture !== ''">
        <i v-else class="fa fa-user-circle-o"></i>
        <h4>{{username}}</h4>
      </div> -->
      <div class="personal-info common">
        <span class="header">
          Basic and Contact Information
          <span v-on:click="editInfo('account_information')">
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
          Company Information
          <span v-on:click="editInfo('company')">
            <i class="fa fa-pencil pull-right" aria-hidden="true"></i>
          </span>
        </span>
        <span class="content row" v-for="(item,index) in userCompanyTitle">
          <label class="title col-xs-6 col-sm-3">{{item}}</label>
          <label class="value col-xs-6 col-sm-9">{{userCompanyValue[index]}}</label>
        </span>
      </div>
      <div class="personal-info common">
        <span class="header">
          Account Information
<!--           <span>
            <i class="fa fa-pencil pull-right" aria-hidden="true"></i>
          </span> -->
        </span>
        <span class="content row" v-for="(item,index) in accountInfoTitle">
          <label class="title col-xs-6 col-sm-3">{{item}}</label>
          <label class="value col-xs-6 col-sm-9">{{accountInfoValue[index]}}</label>
        </span>
      </div>
      <modal :modal_size="modalSize" ref="modal" >
        <div slot="header">
          {{modalTitle}}
        </div>
        <div slot="body">
          <common-form ref="commonForm" :api="api_account_information" :inputs="form_setting_account_information.inputs" v-on:form_close="formClose" v-on:form_deleted="formDeleted" v-on:form_updated="formUpdated" :retrieve_parameter="form_setting_account_information.retrieveParameter" v-if="modalParameter === 'account_information'"></common-form>
          <common-form ref="commonForm" :api="api_company" :inputs="form_setting_company.inputs" v-on:form_close="formClose" v-on:form_deleted="formDeleted" v-on:form_updated="formUpdated" :retrieve_parameter="form_setting_company.retrieveParameter" v-if="modalParameter === 'company'"></common-form>
        </div>
      </modal>
    </div>
  </div>
</template>
<script>
import AUTH from '../../services/auth'
import CONFIG from '../../config'
export default{
  name: '',
  components: {
    'modal': require('components/modal/Modal.vue'),
    'common-form': require('components/form/CommonForm.vue')
  },
  create(){
  },
  mounted(){
    this.getAccountInformations()
  },
  data(){
    let formSettingAccountInformation = {
      modal_size: 'modal-md',
      inputs: {
        first_name: {},
        middle_name: {},
        last_name: {},
        birth_date: {},
        sex: {},
        contact_number: {
          db_name: 'cellular_number'
        },
        address: {}
      }
    }
    let formSettingCompany = {
      modal_size: 'modal-md',
      inputs: {
        name: {},
        address: {}
      }
    }
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      userInfo: [],
      userInfoTitle: [],
      userInfoValue: [],
      userCompanyTitle: [],
      userCompanyValue: [],
      accountInfoTitle: [],
      accountInfoValue: [],
      accountProfileDirectory: CONFIG.BACKEND_URL + '/file/account_profiles/',
      profilePicture: '',
      username: '',
      api_account_information: 'account_information',
      api_company: 'company',
      form_setting_account_information: formSettingAccountInformation,
      form_setting_company: formSettingCompany,
      modalTitle: '',
      modalSize: '',
      modalParameter: ''
    }
  },
  methods: {
    initSettings(){
      if(typeof this.form_setting.form_title === 'undefined'){
        this.modalTitle = this.StringUnderscoreToPhrase(this.api) + ' Details'
      }else{
        this.modalTitle = this.form_setting.form_title
      }
      this.modalSize = typeof this.form_setting.modal_size !== 'undefined' ? this.form_setting.modal_size : ''
    },
    formClose(){
      this.$refs.modal.closeModal()
    },
    formUpdated(){
    },
    formDeleted(){
    },
    editInfo(parameter){
      this.modalParameter = parameter
      this.modalTitle = this.StringUnderscoreToPhrase(parameter) + ' Details'
      this.$refs.commonForm.viewForm(this.user.userID)
      this.$refs.modal.showModal()
    },
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
        this.getCompany()
        if(this.userInfo[0].account_profile_picture !== null){
          this.profilePicture = this.userInfo[0].account_profile_picture.source
        }
      })
    },
    manageData(){
      this.userInfoTitle.push('Name', 'Birth Date', 'Sex', 'Contact Number', 'Address')
      let info = this.userInfo[0].account_information
      let account = this.userInfo[0]
      let name = this.setName(info)
      this.userInfoValue.push(name, this.setText(info.birth_date), this.setText(info.sex), this.setText(info.cellular_number), this.setText(info.address))
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
    },
    getCompany(){
      let parameter = {
        'condition': [{
          'column': 'id',
          'value': this.user.company_id,
          'clause': '='
        }]
      }
      this.APIRequest('company/retrieve', parameter).then(response => {
        this.userCompanyTitle.push('Name', 'Address')
        this.userCompanyValue.push(response.data[0].name, response.data[0].address)
      })
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
