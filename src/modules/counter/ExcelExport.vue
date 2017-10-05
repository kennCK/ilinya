<template>
  <div>
    <button @click="$emit('excel_export_clicked')"  class="btn btn-outline-success"><i class="fa fa-download" aria-hidden="true"></i> Download as Excel</button>
    <div ref="tableWrapper" style="display:none">
      <table >
        <thead>
          <tr>
            <th>Qcard</th>
            <th>
              Facebook User
            </th>
            <th v-for="(column, index) in columnSettings"
            >
              {{column['column_name']}}

            </th>
          </tr>
        </thead>
        <tbody>

          <tr v-for="(tableEntry, rowIndex) in tableEntries"
          >
            <td>{{tableEntry['id']}}</td>
            <td>{{tableEntry['facebook_user_full_name']}}</td>
            <td v-for="columnSetting in columnSettings">
              {{
                tableEntry['queue_form_' + columnSetting['queue_form_field_id']]
              }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
  import Vue from 'vue'
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.initColumnSetting()
    },
    data(){
      return {
        columnSettings: [],
        tableEntries: []
      }
    },
    props: {
    },
    watch: {
      tableEntries(val){

      }
    },
    methods: {
      exportTable(requestOption, callback){
        this.tableEntries = []
        this.columnSettings = []
        let formConditionKey = 0
        if(typeof requestOption['condition'] !== 'undefined' && requestOption['condition'].length){
          for(let x in requestOption['condition']){
            if(requestOption['condition'][x]['column'] === 'queue_form_id'){
              formConditionKey = x
            }else{
              console.log(requestOption['condition'][x]['column'])
            }
          }
        }else{
          console.log(requestOption)
        }
        if(!formConditionKey || requestOption['condition'][formConditionKey]['value'] * 1 < 1){
          $.alert({
            title: '<i class="fa fa-warning text-danger" aria-hidden="true"></i> <strong>Ooops!</strong>',
            content: 'Please filter the table by <em><strong>Form</strong></em> first before downloading it to excel'
          })
          return false
        }
        this.APIRequest('queue_form/retrieve', {id: requestOption['condition'][0]['value'], with_foreign_table: ['queue_form_fields']}, (response) => {
          if(response['data'] && response['data']['queue_form_fields']){
            let queueFormFields = response['data']['queue_form_fields']
            for(let x in queueFormFields){
              this.columnSettings.push({
                queue_form_field_id: queueFormFields[x]['id'],
                column_name: queueFormFields[x]['description']
              })
            }
            requestOption['with_foreign_table'] = ['queue_card_fields', 'facebook_user']
            this.APIRequest('queue_card/retrieve', requestOption, (queueCardResponse) => {
              console.log(requestOption)
              console.log(queueCardResponse['data'])
              if(queueCardResponse['data']){
                for(let y in queueCardResponse['data']){ // loop queue card
                  let entry = {}
                  entry['facebook_user_full_name'] = queueCardResponse['data'][y]['facebook_user'] ? queueCardResponse['data'][y]['facebook_user']['full_name'] : null
                  entry['id'] = queueCardResponse['data'][y]['id']
                  for(let z in this.columnSettings){ // loop column

                    for(let w in queueCardResponse['data'][y]['queue_card_fields']){
                      if(this.columnSettings[z]['queue_form_field_id'] * 1 === queueCardResponse['data'][y]['queue_card_fields'][w]['queue_form_field_id'] * 1){
                        entry['queue_form_' + this.columnSettings[z]['queue_form_field_id']] = queueCardResponse['data'][y]['queue_card_fields'][w]['value']
                      }
                    }
                  }
                  this.tableEntries.push(entry)
                }

              }
              this.$nextTick(() => {
                this.exportToExcel()
                if(callback){
                  callback(this.tableEntries)
                }
              })

            })
          }
        })

      },
      exportToExcel(){
        let dataType = 'data:application/vnd.ms-excel'
        let tableDiv = $(this.$refs.tableWrapper)[0]
        let tableHtml = tableDiv.outerHTML.replace(/ /g, '%20')
        let a = document.createElement('a')
        a.href = dataType + ', ' + tableHtml
        a.download = 'exported_table_' + Math.floor((Math.random() * 9999999) + 1000000) + '.xls'
        a.click()
      },
      initColumnSetting(){
        if(this.export_setting){
          for(let dbName in this.export_setting['column_setting']){
            let column = this.export_setting['column_setting'][dbName]
            Vue.set(column, 'db_name', dbName)
            Vue.set(column, 'column_name', typeof column['column_name'] === 'undefined' ? this.StringUnderscoreToPhrase(dbName) : column['column_name'])
            this.columnSettings.push(column)
          }
        }
      }
    }

  }
</script>
<style scoped>

</style>
