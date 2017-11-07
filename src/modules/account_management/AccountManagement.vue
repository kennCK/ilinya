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
      let columnSetting = {
        username: {

        },
        last_name: {
          name: 'Full Name',
          value_function: (row) => {
            return row['account_information']['last_name'] + ', ' + row['account_information']['first_name']
          }
        }
      }
      let tableSetting = {
        retrieveParameter: {
          with_foreign_table: [
            'account_information',
            'company_branch_employee'
          ],
          condition: [{
            column: 'company_branch_employee.company_branch.company_id',
            value: AUTH.user.company_id
          }]
        },
        columnSetting: columnSetting
      }
      let formSetting = {
        modal_size: 'modal-lg',
        retrieveParameter: {
          with_foreign_table: [
            'account_information'
          ]
        },
        inputs: {
          username: {
            col: 6
          },
          email: {
            col: 6
          },
          password: {
            col: 6
          },
          'account_information.id': {
            input_type: 'hidden'
          },
          'account_information.account_type_id': {
            input_type: 'hidden',
            default_value: '1'
          },
          'account_information.first_name': {
            label: 'First Name'
          },
          'account_information.middle_name': {
            label: 'Middle Name'
          },
          'account_information.last_name': {
            label: 'Last Name'
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
