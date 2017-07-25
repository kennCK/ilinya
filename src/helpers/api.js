import CONFIG from '../config'
import Vue from 'vue'
import AUTH from '../services/auth'
import ROUTER from '../router'
Vue.mixin({
  mounted(){

  },
  methods: {
    APIRequest(link, parameter, callback, errorCallback){
      let tokenStringParam = (AUTH.tokenData.token) ? '?token=' + AUTH.tokenData.token + '&company_id=' + AUTH.user.company_id + '&company_branch_id=' + AUTH.user.company_branch_id : ''
      let request = jQuery.post(CONFIG.API_URL + link + tokenStringParam, parameter, (response) => {
        this.APISuccessRequestHandler(response, callback)
      }).fail((jqXHR) => {
        this.APIFailRequestHandler(link, jqXHR, errorCallback)
      })
      return request
    },
    APIFormRequest(link, formRef, callback, errorCallback){
      let tokenStringParam = (AUTH.tokenData.token) ? '?token=' + AUTH.tokenData.token + '&company_id=' + AUTH.user.company_id + '&company_branch_id=' + AUTH.user.company_branch_id : ''
      let formData = new FormData($(formRef)[0])
      $.ajax({
        url: CONFIG.API_URL + link + tokenStringParam,
        type: 'POST',
        data: formData,
        async: false,
        success: (response) => {
          this.APISuccessRequestHandler(response, callback)
        },
        error: (jqXHR) => {
          this.APIFailRequestHandler(link, jqXHR, errorCallback)
        },
        cache: false,
        contentType: false,
        processData: false
      })
    },
    APISuccessRequestHandler(response, callback){
      if(callback){
        callback(response)
      }
    },
    APIFailRequestHandler(link, jqXHR, errorCallback){
      switch(jqXHR.status){
        case 401: // Unauthorized
          if(link === 'authenticate' || 'authenticate/user'){ // if error occured during authentication request
            if(errorCallback){
              errorCallback(jqXHR.responseJSON, jqXHR.status * 1)
            }
          }else{
            ROUTER.push('login')
          }
          break
        default:
          if(errorCallback){
            errorCallback(jqXHR.responseJSON, jqXHR.status * 1)
          }
      }
    }
  }
})
