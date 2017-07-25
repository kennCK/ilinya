<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
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

  },
  data(){
    let filterSetting = {
      description: {}
    }
    let columnSetting = {
      description: {},
      days: {},
      time_start: {},
      time_end: {}
    }
    let tableSetting = {
      filterSetting: filterSetting,
      columnSetting: columnSetting
    }
    let formSetting = {
      inputs: {
        description: {},
        days: {},
        time_start: {},
        time_end: {}
      }
    }
    return {
      api: 'schedule',
      table_setting: tableSetting,
      form_setting: formSetting
    }
  },
  props: {
  },
  methods: {
  }
}
</script>
<style scoped>

</style>
