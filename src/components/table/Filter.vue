<template>
  <div>
    <form v-if="filterInitialized" ref="form" enctype="multipart/form-data" role="form" method="POST">
      <div class="row">
        <div class="col-sm-10 float-right">
          <input-group
            :inputs="filterList"
            :form_data="formData"
            v-on:form_data_changed="valueChanged"
            :form_data_updated="formDataChanged"
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
        fieldNameLookUp: {},
        condition: [],
        formDataChanged: false
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
          typeof this.filterList[key]['clause'] === 'undefined' ? Vue.set(this.filterList[key], 'clause', '=') : ''
          typeof this.filterList[key]['is_dummy'] === 'undefined' ? Vue.set(this.filterList[key], 'is_dummy', false) : ''
          this.dbNameLookUp[key] = this.filterList[key]['db_name']
          Vue.set(this.formData, key, typeof this.filter_setting[key]['default_value'] !== 'undefined' ? this.filter_setting[key]['default_value'] : null)
          this.fieldNameLookUp[this.filterList[key]['db_name']] = key
        }
        this.filterInitialized = true
      },
      valueChanged(fieldName, value){
        if(this.filterList[fieldName]['is_dummy'] === 'undefined'){
          return false
        }
        console.log('filter ' + fieldName + ' : ' + value)
        Vue.set(this.formData, fieldName, value)
        // this.formDataChanged = !this.formDataChanged
      },
      getFilter(){
        return this.condition
      },
      filterForm(){
        let condition = []

        let formInputs = this.formData
        for(let x in formInputs){

          if(formInputs[x] !== '' && formInputs[x] !== null && !this.filterList[x]['is_dummy']){
            let value = formInputs[x]
            if(this.filterList[x]['clause'] === 'like'){
              value = '%' + value + '%'
            }
            condition.push({
              column: this.filterList[x]['db_name'],
              value: value,
              clause: this.filterList[x]['clause']
            })
          }
        }
        this.condition = condition
        this.$emit('filter')
      }
    }

  }
</script>
<style scoped>

</style>
