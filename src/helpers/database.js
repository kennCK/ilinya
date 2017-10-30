import Vue from 'vue'
import global from './global'
import config from '../config'
/***
  Be sure to name the helper properly inroder to avoid conflicting on methods in Vue Modules and Components
*/
Vue.mixin({
  methods: {
    latestData: function(apiLink, latestData){
      this.APIRequest(apiLink, {}, (response) => {
        console.log(response)
        latestData['data'] = response['data']
        latestData['request_timestamp'] = response['request_timestamp']
      })
    }

  },
  filters: {
    getFormDataFilter(formData, dbName, defaultValue){
      let explodedDBName = dbName.split('.')
      if(explodedDBName.length === 1){
        return formData[dbName] ? formData[dbName] : defaultValue
      }else{ // nested form data
        let currentForm = formData
        for(let dbNameIndex = 0; dbNameIndex < explodedDBName.length; dbNameIndex++){
          if(typeof currentForm[explodedDBName[dbNameIndex]] === 'undefined'){
            return defaultValue
          }else{
            currentForm = currentForm[explodedDBName[dbNameIndex]]
          }
        }
        return currentForm
      }
    }
  }
})
