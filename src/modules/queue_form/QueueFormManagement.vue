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
        title: {},
        availability: {
          value_function: (data) => {
            let label = ['Not Specified', 'Open', 'Close', 'Busy']
            return label[data['availability']]
          }
        },
        is_private: {
          value_function: (data) => {
            let label = ['Yes', 'No']
            return label[data['is_private']]
          }
        },
        created_at: {}
      }
      let tableSetting = {
        retrieveParameter: {
          condition: [{
            column: 'company_id',
            value: AUTH.user.company_id
          }]
        },
        columnSetting: columnSetting
      }
      let formSetting = {
        modal_size: 'modal-lg',
        retrieveParameter: {
          with_foreign_table: [
            'queue_form_fields'
          ]
        },
        inputs: {
          code: {
            read_only: true,
            value_function: (formData) => {
              return {
                code: formData['company_id'] ? (this.padNumber((formData['company_id'] * 1).toString(16), 3).split('').reverse().join('') + '-' + this.padNumber((formData['id']).toString(16), 4)).toUpperCase() : null
              }
            }
          },
          title: {},
          detail: {
            placeholder: 'Describe the purpose, availability, important things about this form',
            input_type: 'textarea'
          },
          availability: {
            input_type: 'select',
            input_setting: {
              options: [{
                label: 'Select Availability',
                value: null
              }, {
                label: 'Open',
                value: 1
              }, {
                label: 'Close',
                value: 2
              }, {
                label: 'Busy',
                value: 3
              }]
            }
          },
          is_private: {
            input_type: 'select',
            default_value: 1,
            input_setting: {
              options: [{
                label: 'Yes',
                value: 1
              }, {
                label: 'No',
                value: 0
              }]
            }
          },
          queue_form_fields: {
            label_colspan: 12,
            input_name: 'Form Fields',
            input_type: 'table-input',
            input_setting: {
              column_setting: {
                description: {
                },
                type: {
                  input_type: 'select',
                  default_value: 'text',
                  input_setting: {
                    options: [
                      {label: 'text', value: 'text'},
                      {label: 'number', value: 'number'},
                      {label: 'email', value: 'email'}
                    ]
                  }
                },
                is_admin_only: {
                  name: 'Admin Only',
                  input_type: 'select',
                  default_value: '0',
                  input_setting: {
                    options: [
                      {label: 'No', value: 0},
                      {label: 'Yes', value: 1}
                    ]
                  }
                },
                sequence: {
                  name: 'Sequence',
                  input_type: 'number',
                  default_value: 1
                },
                additional_option: {
                  db_name: 'setting'
                }
                // main_field: {
                //   input_type: 'select',
                //   default_value: 1,
                //   select_option: [
                //     {
                //       value: 1,
                //       label: 'Yes'
                //     },
                //     {
                //       value: 2,
                //       label: 'No'
                //     }
                //   ]
                // }
              }
            }
          }
        }
      }
      return {
        api: 'queue_form',
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
