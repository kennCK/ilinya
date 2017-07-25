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
      company_branch_id: {
        input_type: 'hidden',
        default_value: AUTH.user.company_branch_id
      },
      employee_id: {},
      employee: {
        input_name: 'Name',
        input_type: 'select2'
      }
    }
    let columnSetting = {
      employee_id: {},
      first_name: {},
      last_name: {},
      days: {},
      time_start: {},
      time_end: {}
    }
    let tableSetting = {
      filterSetting: filterSetting,
      columnSetting: columnSetting,
      retrieveParameter: {
        with_foreign_table: [
          'schedule'
        ]
      }
    }
    let formSetting = {
      inputs: {
        name: {
          input_name: 'Employee Name',
          input_type: 'select2'
        },
        description: {
          input_name: 'Schedule Description',
          input_type: 'select2'
        }
      }
    }
    return {
      api: 'account_schedule',
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
