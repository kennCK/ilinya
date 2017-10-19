<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
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
  },
  data(){
    let filterSetting = {
      question: {},
      answer: {},
      action_type: {},
      action: {}
    }
    let columnSetting = {
      question: {},
      answer: {},
      action_type: {},
      action: {}
    }
    let tableSetting = {
      filterSetting: filterSetting,
      columnSetting: columnSetting,
      retrieveParameter: {
        'sort': {
          'answer': 'asc'
        }
      }
    }
    let formSetting = {
      inputs: {
        question: {},
        answer: {},
        action_type: {},
        action: {}
      }
    }
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      api: 'ai',
      table_setting: tableSetting,
      form_setting: formSetting
    }
  },
  props: {
  },
  methods: {
    retrieve(){
      let parameter = {
        'sort': {
          'answer': 'asc'
        }
      }
      this.APIRequest('ai/retrieve', parameter).then(response => {
        this.aiData = response.data
        console.log(this.aiData)
      })
    }
  }
}
</script>
<style>
  
</style>
