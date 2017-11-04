<template>
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4 custom-container">
        <div class="header-title">
          <i class="fa fa-home" aria-hidden="true" v-on:click="redirect()"></i>
          <span>Registration</span>
        </div>
        <span class="text-danger error-holder text-center" v-if="errorStatus !== ''">
          <label>{{errorStatus}}</label>
        </span>
         <form ref="registration">
          <input-group
            :inputs="inputs" :form_status="'create'" :error_list="errorList" v-on:form_data_changed="valueChange"
          ></input-group>
        </form>
          <button class="btn btn-primary pull-right" v-on:click="register()">Next</button>
      </div>
    </div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  name: '',
  components: {
    'input-group': require('components/input_field/InputGroup.vue')
  },
  mounted(){
  },
  data(){
    return{
      inputs: {
        business_type_id: {
          label_colspan: 0,
          input_type: 'select',
          db_name: 'business_type_id',
          input_setting: {
            option_function: (instance) => {
              let parameter = {
                'sort': {
                  'sub_category': 'asc'
                }
              }
              this.APIRequest('business_type/retrieve', parameter, (response) => {
                if(response['data']){
                  let options = []
                  options.push({
                    value: null,
                    label: 'Select Categories:'
                  })
                  for (let i = 0; i < response['data'].length; i++) {
                    options.push({
                      value: response['data'][i]['id'],
                      label: response['data'][i]['sub_category']
                    })
                  }
                  instance.setOption(options)
                }
              })
            }
          }
        },
        username: {
          label_colspan: 0,
          db_name: 'account[username]',
          placeholder: 'Username'
        },
        email: {
          label_colspan: 0,
          db_name: 'account[email]',
          placeholder: 'Email Address'
        },
        password: {
          label_colspan: 0,
          db_name: 'account[password]',
          placeholder: 'Password',
          input_type: 'password'
        },
        confirm_password: {
          label_colspan: 0,
          placeholder: 'Confirm Password',
          input_type: 'password'
        },
        name: {
          label_colspan: 0,
          db_name: 'name',
          placeholder: 'Company or Organization Name'
        },
        address: {
          label_colspan: 0,
          db_name: 'address',
          placeholder: 'Address'
        }
      },
      errorList: {},
      errorStatus: '',
      myData: {},
      passwordFlag: false,
      usernameFlag: false,
      result: []
    }
  },
  methods: {
    valueChange(fieldName, value){
      if(value !== null){
        this.myData[fieldName] = value
        this.validate()
      }
    },
    validate(){
      if('password' in this.myData || 'confirm_password' in this.myData){
        if(this.myData.password.localeCompare(this.myData.confirm_password) === 0){
          this.errorStatus = ''
          this.passwordFlag = true
        }else{
          this.errorStatus = 'Please confirm your password.'
          this.passwordFlag = false
        }
      }
      if('username' in this.myData){
        if(this.myData.username.length < 6){
          this.errorStatus = 'Username must be atleast 6 characters.'
          this.usernameFlag = false
        }else{
          this.errorStatus = ''
          this.usernameFlag = true
        }

      }
    },
    register(){
      if(this.passwordFlag === true && this.usernameFlag === true){
        this.APIFormRequest('company/create', this.$refs.registration, response => {
          console.log(response)
          this.result = response
          if(this.result.error.status !== null){
            if('email' in this.result.error.message && ('username' in this.result.error.message)){
              this.errorStatus = 'Username and Email Address are already taken.'
            }else if('email' in this.result.error.message){
              this.errorStatus = 'Email Address is already taken.'
            }else if('username' in this.result.error.message){
              this.errorStatus = 'Username is already taken.'
            }
          }else if('flag' in this.result.data){
            if(this.result.data.flag === true){
              this.login()
            }
          }
        })
      }else{
        this.errorStatus = 'Please fill up the required informations.'
      }
    },
    login(){
      AUTH.authenticate(this.myData.username, this.myData.password, (response) => {
        AUTH.setCompany(this.result.data.company_id, this.result.data.company_branch_id)
        ROUTER.push('dashboard')
      }, (response, status) => {
        this.errorStatus = (status === 401) ? 'Your Username and password didnot matched.' : 'Cannot log in? Contact us through email: support@ilinya.com'
      })
    }
  }
}
</script>
<style>
  .error-holder label{
    padding: 5px 0 5px 0;
  }
  .row{
    margin-left: 0 !important;
    margin-right: 0 !important;
  }
</style>
