<template>
  <div class="container">
    <div class="row ">
      <div class="col-sm-6">
        <h4>Product Management</h4>
      </div>
      <div class="col-sm-12 no-overlay">
        <common-module
          :form_setting="formSetting"
          :form_input_setting="formInputSetting"
          :table_setting="tableSetting"
          :column_setting="tableColumnSetting"
          :api="api">
        </common-module>
      </div>
    </div>
  </div>
</template>
<script>
  export default{
    name: 'ProductManagement',
    components: {
      'common-module': require('../../components/common_module/CommonModule.vue')
    },
    create(){
    },
    mounted(){

    },
    data(){
      let tableSetting = {
      }
      let tableColumnSetting = [
        {
          name: 'description'
        },
        {
          name: 'day',
          value_function: function(rowValue){
            let days = [
              'Sunday',
              'Monday',
              'Tuesday',
              'Wednesday',
              'Thursday',
              'Friday',
              'Saturday'
            ]
            return days[rowValue['day'] - 1]
          }
        }
      ]
      let formSetting = {
        title: 'Product'
      }
      let formInputSetting = {
        image: {
          placeholder: 'Image File Name',
          type: 'image'
        },
        description: {},
        day: {
          type: 'select',
          default_value: 1,
          select_option: {
            options: [
              {value: 1, text: 'Sunday'},
              {value: 2, text: 'Monday'},
              {value: 3, text: 'Tuesday'},
              {value: 4, text: 'Wednesday'},
              {value: 5, text: 'Thursday'},
              {value: 6, text: 'Friday'},
              {value: 7, text: 'Saturday'}
            ]
          }
        },
        details: {
          type: 'textarea',
          default_value: 0
        },
        rice: {
          type: 'Decimal',
          default_value: 0
        },
        barley: {
          type: 'Decimal',
          default_value: 0
        },
        basmati_rice: {
          type: 'Decimal'
        },
        status: {
          type: 'select',
          default_value: 1,
          select_option: {
            options: [
              {value: 1, text: 'Active'},
              {value: 2, text: 'Inactive'}
            ]
          }
        }
      }
      return {
        api: 'product',
        tableSetting: tableSetting,
        tableColumnSetting: tableColumnSetting,
        formSetting: formSetting,
        formInputSetting: formInputSetting
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
