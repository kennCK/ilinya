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
            :inputs="inputs" :form_status="'create'" :error_list="errorList"
          ></input-group>
        </form>
          <button class="btn btn-primary pull-right" v-on:click="register()">Next</button>
      </div>
    </div>
</template>
<script>
import ROUTER from '../../router'
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
        email: {
          label_colspan: 0,
          db_name: 'accounts[email]',
          placeholder: 'Email Address'
        },
        password: {
          label_colspan: 0,
          db_name: 'accounts[password]',
          placeholder: 'Password'
        },
        confirm_password: {
          label_colspan: 0,
          placeholder: 'Confirm Password'
        },
        name: {
          label_colspan: 0,
          db_name: 'name',
          placeholder: 'Company Name'
        },
        address: {
          label_colspan: 0,
          db_name: 'address',
          placeholder: 'Address'
        }
      },
      errorList: {},
      errorStatus: ''
    }
  },
  methods: {
    register(){
      this.APIFormRequest('company/create', this.$refs.registration, response => {
        if(response.error.status === 100){
          this.errorStatus = ('email' in response.error.message && !('name' in response.error.message)) ? 'Email Address already taken.' : 'Please fill up the required informations.'
          console.log(response.error.message['name'])
        }else if(response.error.status !== 'undefined'){
          this.redirect()
        }
      })
    },
    redirect(){
      ROUTER.push('/')
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
