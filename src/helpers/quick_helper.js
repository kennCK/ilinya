import Vue from 'vue'
import global from './global'
import config from '../config'
/***
  Be sure to name the helper properly inroder to avoid conflicting on methods in Vue Modules and Components
*/
Vue.mixin({
  data(){
    return {
      IMAGE_URL: config.IMAGE_URL
    }
  },
  methods: {
    modal: function(action){
      if(action === 'show'){
        global.hasShownModal = true
      }else if(action === 'close'){
        global.hasShownModal = false
      }
    },
    sampleHelper(){
      return 'hello world'
    }
  }
})
