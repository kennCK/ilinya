<template>
  <div>
    <module :api="api" :table_setting="table_setting" :form_setting="form_setting"></module>
  </div>
</template>
<script>
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
        name: {
        },
        code: {
        }
      }
      let columnSetting = {
        name: {
        },
        code: {}
      }
      let tableSetting = {
        filterSetting: filterSetting,
        columnSetting: columnSetting
      }
      let formSetting = {
        modal_size: 'modal-lg',
        retrieveParameter: {
          with_foreign_table: [
            'department_head'
          ]
        },
        inputs: {
          logo_input_group: {
            input_type: 'group',
            col: 6,
            inputs: {
              logo_file: {
                label_colspan: 0,
                input_type: 'single_image'
              },
              department_account_id: {
                db_name: 'department_members[0][id]'
              },
              department_head_name: {
                value_function: (formData) => {
                  let name = formData['department_head']['account_information']['first_name'] + ' ' + formData['department_head']['account_information']['last_name']
                  return {
                    department_head_name: name
                  }
                },
                input_name: 'Department Head',
                input_type: 'static',
                label_colspan: 12
              },
              department_is_head: {
                db_name: 'department_members[0][is_head]',
                input_type: 'hidden'
              }
            }
          },
          detail_input_group: {
            input_type: 'group',
            col: 6,
            inputs: {
              company_branch_id: {
                default_value: 2
              },
              name: {
                colspan: 6
              },
              code: {
                input_type: 'checkbox',
                colspan: 6
              },
              location: {
                colspan: 6
              },
              contact_number: {
                colspan: 6
              },
              email: {
                colspan: 6
              },
              fax_number: {
                colspan: 6
              }
            }
          }
        }
      }
      return {
        api: 'department',
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
