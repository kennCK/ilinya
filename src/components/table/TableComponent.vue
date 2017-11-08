<template>
  <div>
    <div v-if="table_export_setting" class="row">
      <div  class="col-sm-12 text-right">
        <table-excel-export ref="tableExcelExport"
          v-on:export_excel="exportExcel"
          :export_setting="table_export_setting"
          :api="api"
        ></table-excel-export>
      </div>
    </div>
    <table-filter v-if="filter_setting" v-on:filter="retrieveData('filter', true)" :filter_setting="filter_setting" ref="tableFilter" class="mb-2"></table-filter>
    <table class="table table-bordered table-condensed table-hover table-responsive-sm" >
      <thead>
        <tr>
          <th v-for="(column, index) in columnSetting[0]"
            v-bind:rowspan="(column['sub_columns']) ? 1:2"
            v-bind:colspan="column['sub_columns'] ? column['sub_column_count']  : 1"
            v-on:click="changeSort(0, index)"
          >
            {{column['name']}}
            <span class="pull-right">
              <i v-if="column['sort'] === 0" class="fa fa-sort" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 1" class="fa fa-sort-asc" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 2" class="fa fa-sort-desc" aria-hidden="true"></i>
            </span>
          </th>
        </tr>
        <tr>
          <th v-for="(column, index) in columnSetting[1]"
            v-bind:rowspan="(column['sub_columns']) ? 1:2"
            v-bind:colspan="column['sub_columns'] ? column['sub_column_count']  : 1"
            v-on:click="changeSort(1, index)"
          >
            {{column['name']}}
            <span v-if="column['sort'] !== false" class="pull-right">
              <i v-if="column['sort'] === 0" class="fa fa-sort" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 1" class="fa fa-sort-asc" aria-hidden="true"></i>
              <i v-else-if="column['sort'] === 2" class="fa fa-sort-desc" aria-hidden="true"></i>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(tableEntry, index) in tableEntries"
          @click="$emit('row_clicked', index, tableEntry['id'])"
        >
          <td v-for="columnSetting in linearColumnSetting">
            <table-cell :type="columnSetting['type']"
              :value="columnSetting['value_function'](tableEntry, columnSetting['db_name'])"
              :setting="columnSetting['setting']"
              :row_data="tableEntry"
              :row_index="index"
              :if_condition="columnSetting['if_condition']"
              >
            </table-cell>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-sm-6  mb-2">
        <strong>Results: {{totalResult}}</strong>
      </div>
      <div class="col-sm-6">
        <nav >
          <ul class="pagination justify-content-end ">

            <li v-if="isLoadingData" class="page-item" v-bind:class="currentPage === 1 ? 'disabled' : ''">
              <i class="fa fa-hourglass-2" aria-hidden="true"></i> Loading Table...
            </li>
            <template v-else>
              <li class="page-item" v-bind:class="currentPage * 1 === 1 ? 'disabled' : ''">
                <button @click="currentPage--" class="page-link" type="button" tabindex="-1">
                  <i class="fa fa-chevron-left" aria-hidden="true"></i>
                  Previous
                </button>
              </li>
              <li class="page-item ml-1">
                <!-- <input class="form-control text-right" size="5"> -->
                <select v-model="currentPage" class="form-control select-rtl">
                  <option v-for="x in this.totalPage" >{{x}}</option>
                </select>
              </li>
              <li class="page-item"></li>
              <li class="page-item"><label class="col-form-label">&nbsp; of <span style="font-weight:bold">{{totalPage}}&nbsp;&nbsp;</span></label></li>
              <li class="page-item">
                <button class="page-link" @click="currentPage++">Next <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
              </li>
            </template>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</template>
<script>
  import Vue from 'vue'
  export default{
    components: {
      'table-filter': require('./Filter.vue'),
      'table-excel-export': require('./ExcelExport.vue'),
      'table-cell': require('./Cell.vue')
    },
    mounted(){

      this.initColumnSetting()
      if(this.$refs.tableFilter){
        this.$refs.tableFilter.filterForm()
      }else{
        this.retrieveData('filter')
      }
    },
    data(){
      return {
        columnSetting: [
          [],
          []
        ],
        linearColumnSetting: [],
        tableEntries: [],
        currentSort: null,
        currentPage: 1,
        totalPage: 1,
        totalResult: 0,
        prevRetrieveType: null,
        exportTableSetting: Object,
        isLoadingData: false
      }
    },
    props: {
      api: String,
      filter_setting: Object,
      column_setting: Object,
      table_export_setting: Object,
      retrieve_parameter: {
        type: Object,
        default(){
          return {}
        }
      },
      entry_per_page: {
        default: 5,
        type: Number
      }
    },
    watch: {
      currentPage(value){
        if(value === 0){
          this.currentPage = 1
        }
        this.retrieveData(this.prevRetrieveType)
      }
    },
    methods: {

      changeSort(rowIndex, columnIndex){
        if(this.columnSetting[rowIndex][columnIndex]['sort'] === false){
          return false
        }
        (this.currentSort !== null && this.currentSort['db_name'] !== this.columnSetting[rowIndex][columnIndex]['db_name']) ? this.currentSort['sort'] = 0 : null
        this.columnSetting[rowIndex][columnIndex]['sort'] = (this.columnSetting[rowIndex][columnIndex]['sort'] < 2)
          ? this.columnSetting[rowIndex][columnIndex]['sort'] + 1 : 0
        this.currentSort = this.columnSetting[rowIndex][columnIndex]
        this.retrieveData(this.prevRetrieveType)
      },
      exportExcel(){
        this.isLoadingData = true
        let requestOption = {} // this.retrieve_parameter
        let retrieveParameter = this.cloneObject(this.retrieve_parameter)
        for(let x in retrieveParameter){
          requestOption[x] = retrieveParameter[x]
        }
        if(this.currentSort && this.currentSort['sort']){
          let orderLookUp = ['', 'asc', 'desc']
          requestOption['sort'] = {}
          requestOption['sort'][this.currentSort['db_name']] = orderLookUp[this.currentSort['sort']]
        }
        $.merge(requestOption.condition, this.$refs.tableFilter.getFilter())

        this.$refs.tableExcelExport.exportTable(requestOption, () => {
          this.isLoadingData = false
        })
      },
      getFiter(){
        let requestOption = {} // this.retrieve_parameter
        let retrieveParameter = this.cloneObject(this.retrieve_parameter)
        for(let x in retrieveParameter){
          requestOption[x] = retrieveParameter[x]
        }
        if(this.currentSort && this.currentSort['sort']){
          let orderLookUp = ['', 'asc', 'desc']
          requestOption['sort'] = {}
          requestOption['sort'][this.currentSort['db_name']] = orderLookUp[this.currentSort['sort']]
        }
        typeof requestOption.condition === 'undefined' ? requestOption.condition = [] : null
        $.merge(requestOption.condition, this.$refs.tableFilter.getFilter())
        return requestOption
      },
      retrieveData(retrieveType, resetPage){
        this.isLoadingData = true
        let requestOption = {} // this.retrieve_parameter
        let retrieveParameter = this.cloneObject(this.retrieve_parameter)
        for(let x in retrieveParameter){
          requestOption[x] = retrieveParameter[x]
        }
        if(this.currentSort && this.currentSort['sort']){
          let orderLookUp = ['', 'asc', 'desc']
          requestOption['sort'] = {}
          requestOption['sort'][this.currentSort['db_name']] = orderLookUp[this.currentSort['sort']]
        }
        if(resetPage){
          this.currentPage = 1
        }
        if(retrieveType === 'filter' && this.$refs.tableFilter){
          typeof requestOption.condition === 'undefined' ? requestOption.condition = [] : null
          $.merge(requestOption.condition, this.$refs.tableFilter.getFilter())
        }
        requestOption['limit'] = this.entry_per_page
        requestOption['offset'] = this.entry_per_page * (this.currentPage - 1)
        this.prevRetrieveType = retrieveType
        this.APIRequest(this.api + '/retrieve', requestOption, (response) => {
          this.tableEntries = []
          if(response['data']){
            this.tableEntries = response['data']
          }else if(!response['data'] && response['total_entries'] > 0){
            this.currentPage--
          }
          this.totalResult = response['total_entries']
          this.totalPage = Math.ceil(response['total_entries'] / this.entry_per_page)
          this.isLoadingData = false
        })
      },
      updateRow(rowIndex, entryID){
        let requestOption = {
          id: rowIndex !== -1 ? this.tableEntries[rowIndex]['id'] : entryID
        }
        let retrieveParameter = this.cloneObject(this.retrieve_parameter)
        for(let x in retrieveParameter){
          requestOption[x] = retrieveParameter[x]
        }
        this.APIRequest(this.api + '/retrieve', requestOption, (response) => {
          if(response['data']){
            if(rowIndex !== -1){
              Vue.set(this.tableEntries, rowIndex, response['data'])
            }else{
              this.tableEntries.push(response['data'])
            }
          }
        })
      },
      deleteRow(rowIndex){
        this.tableEntries.splice(rowIndex, 1)
      },
      initColumnSetting(){
        for(let dbName in this.column_setting){
          let column = this.column_setting[dbName]
          Vue.set(column, 'db_name', typeof this.column_setting[dbName]['db_name'] === 'undefined' ? dbName : this.column_setting[dbName]['db_name'])

          this.initColumn(column)
          this.columnSetting[0].push(column)
          if(!column['sub_columns']){
            this.linearColumnSetting.push(column)
          }else{
            let subCount = 0
            for(let subColDBName in column['sub_columns']){
              subCount++
              let subColumn = column['sub_columns'][subColDBName]
              Vue.set(subColumn, 'db_name', subColDBName)
              this.initColumn(subColumn)
              this.columnSetting[1].push(subColumn)
              this.linearColumnSetting.push(subColumn)
            }
            Vue.set(column, 'sub_column_count', subCount)
          }
        }
      },
      initColumn(column){
        typeof column['name'] === 'undefined' ? Vue.set(column, 'name', this.StringUnderscoreToPhrase(column['db_name'])) : null
        typeof column['type'] === 'undefined' ? Vue.set(column, 'type', 'text') : null
        typeof column['sort'] === 'undefined' ? Vue.set(column, 'sort', 0) : null
        if(column['type'] === 'button'){
          column['sort'] = false
        }
        typeof column['if_condition'] === 'undefined' ? Vue.set(column, 'if_condition', (row) => {
          return true
        }) : null
        typeof column['value_function'] === 'undefined' ? Vue.set(column, 'value_function', (row, dbName) => {

          let dbNameSegment = dbName.split('.')
          let value
          if(dbNameSegment.length > 1){
            value = row
            for(let x = 0; x < dbNameSegment.length; x++){
              if(typeof value[dbNameSegment[x]] !== 'undefined'){
                value = value[dbNameSegment[x]]
              }else{
                break
              }
            }
          }else{
            value = row[dbName]
          }
          return value
        }) : null
        typeof column['sub_columns'] === 'undefined' ? Vue.set(column, 'sub_columns', null) : null
      }
    }
  }
</script>
<style scoped>
  .select-rtl{
    text-align-last: right;

  }
  .select-rtl option{
    direction: rtl;
  }
</style>
