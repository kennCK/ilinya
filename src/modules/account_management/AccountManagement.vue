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
        first_name: {
          db_name: 'account_information.first_name'
        }
      }
      let tableSetting = {
        retrieveParameter: {
          with_foreign_table: [
            'account_information',
            'company_branch_employee'
          ],
          condition: [{
            column: 'company.company_id',
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
          first_name: {
            db_name: 'account_information.first_name'
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
