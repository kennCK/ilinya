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
      first_name: {
        input_name: 'Name',
        input_type: 'select2'
      },
      position: {
        input_type: 'select2'
      },
      department: {
        input_type: 'select2'
      }
    }
    let columnSetting = {
      username: {},
      email: {},
      'account_information.first_name': {
        name: 'First Name'
      },
      'account_information.last_name': {
        name: 'Last Name'
      }
    }
    let tableSetting = {
      filterSetting: filterSetting,
      columnSetting: columnSetting,
      retrieveParameter: {
        'with_foreign_table': [
          'account_information'
        ]
        // 'condition': [{
        //   'column': 'company_branch_employees.company_branch_id',
        //   'value': AUTH.user.company_branch_id,
        //   'clause': '='
        // }]
      }
    }
    let formSetting = {
      inputs: {
        company_branch_id: {
          db_name: 'company_branch_employees[company_branch_id]',
          default_value: AUTH.user.company_branch_id,
          input_type: 'hidden'
        },
        identification_number: {
          input_name: 'Employee ID',
          db_name: 'company_branch_employees[identification_number]'
        },
        email: {},
        first_name: {
          input_name: 'First Name',
          db_name: 'account_information[first_name]'
        },
        last_name: {
          input_name: 'Last Name',
          db_name: 'account_information[last_name]'
        }
      }
    }
    return {
      api: 'account',
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
