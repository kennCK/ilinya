<template>
  <div>
    <button @click="$emit('export_excel')"  class="btn btn-outline-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel</button>
    <div ref="tableWrapper">
      <table >
        <thead>
          <tr>
            <th v-for="(column, index) in columnSettings"
            >
              {{column['column_name']}}

            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(tableEntry, rowIndex) in tableEntries"
          >
            <td v-for="columnSetting in columnSettings">
              {{
                (typeof columnSetting['value_function'] === 'undefined') ?
                tableEntry[columnSetting['db_name']]
                : columnSetting['value_function'](tableEntry, rowIndex)
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
      export_setting: Object,
      api: String
    },
    watch: {
      tableEntries(val){

      }
    },
    methods: {
      exportTable(requestOption, callback){
        this.APIRequest(this.api + '/retrieve', requestOption, (response) => {
          this.tableEntries = []
          if(response['data']){
            this.tableEntries = response['data']
          }
          this.$nextTick(() => {
            this.exportToExcel()
            if(callback){
              callback(this.tableEntries)
            }
          })

        })
      },
      exportToExcel(){
        let dataType = 'data:application/vnd.ms-excel'
        console.log($(this.$refs.tableWrapper))
        let tableDiv = $(this.$refs.tableWrapper)[0]
        let tableHtml = tableDiv.outerHTML.replace(/ /g, '%20')
        console.log(tableHtml)
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
