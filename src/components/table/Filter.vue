<template>
  <div>
    <form v-if="filterInitialized" ref="form" enctype="multipart/form-data" role="form" method="POST">
      <div class="row">
        <div class="col-sm-10 float-right">
          <input-group
            :inputs="filterList"
            :form_data="formData"
            v-on:form_data_changed="valueChanged"
          >
          </input-group>
        </div>
        <div class="col-sm-2">
          <button @click="filterForm" type="button" class="btn btn-outline-success" ><i class="fa fa-filter" aria-hidden="true"></i> Filter</button>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
  import Vue from 'vue'
  export default{
    name: '',
    components: {
      'input-cell': require('components/input_field/InputCell.vue'),
      'input-group': require('components/input_field/InputGroup.vue')
    },
    create(){

    },
    mounted(){
      this.initializeFilter()
    },
    data(){
      return {
        filterList: {},
        filterInitialized: false,
        formData: {
        },
        dbNameLookUp: {},
        fieldNameLookUp: {}
      }
    },
    props: {
      filter_setting: Object
    },
    methods: {
      initializeFilter(){
        this.filterList = {}
        for(let key in this.filter_setting){
          Vue.set(this.filterList, key, this.filter_setting[key])
          typeof this.filterList[key]['name'] === 'undefined' ? Vue.set(this.filterList[key], 'name', this.StringUnderscoreToPhrase(key)) : ''
          typeof this.filterList[key]['db_name'] === 'undefined' ? Vue.set(this.filterList[key], 'db_name', key) : null
          typeof this.filterList[key]['col'] === 'undefined' ? Vue.set(this.filterList[key], 'col', 4) : ''
          if(!this.filterList[key]['is_dummy']){
            this.formData[this.filterList[key]['db_name']] = typeof this.filter_setting[key]['default_value'] !== 'undefined' ? this.filter_setting[key]['default_value'] : null
            this.dbNameLookUp[key] = this.filterList[key]['db_name']
            this.fieldNameLookUp[this.filterList[key]['db_name']] = key
          }
        }
        this.filterInitialized = true
      },
      valueChanged(fieldName, value){
        if(typeof this.dbNameLookUp[fieldName] === 'undefined'){
          return false
        }
        if(typeof this.formData[fieldName] === 'undefined'){
          Vue.set(this.formData, this.dbNameLookUp[fieldName], null)
        }
        Vue.set(this.formData, this.dbNameLookUp[fieldName], value)
      },
      getFilter(){
        let condition = []
        let formInputs = this.formData
        for(let x in formInputs){
          if(formInputs[x] !== '' && formInputs[x] !== null){
            let value = formInputs[x]
            if(this.filterList[this.fieldNameLookUp[x]]['clause'] === 'like'){
              value = '%' + value + '%'
            }
            condition.push({
              column: x,
              value: value,
              clause: this.filterList[this.fieldNameLookUp[x]]['clause']
            })
          }
        }
        return condition
      },
      filterForm(){
        this.$emit('filter')
      }
    }

  }
</script>
<style scoped>

</style>
