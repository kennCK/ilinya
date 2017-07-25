<template>
  <div>
    <form v-if="filterInitialized" ref="form" enctype="multipart/form-data" role="form" method="POST">

        <input-group
          :inputs="filterList"
        >
        </input-group>
        <!-- <template v-for="input in filterList">
          <div class='col-sm-4 float-right'>
            <input-cell
              :input_name="input['input_name']"
              :db_name="input['db_name']"
              :input_setting="input['input_setting']"
              :input_type="input['input_type']"
              :input_style="input['input_style']"
              :label_colspan="input['label_colspan']"
              :placeholder="input['placeholder']"
              :feedback_message="input['feedback_message']"
              :feedback_status="input['feedback_status']"
              :muted_text="input['muted_text']"
            >
            </input-cell>
          </div>
        </template> -->
        <div class="col-sm-2">
          <button @click="filterForm" type="button" class="btn btn-default" >Filter</button>
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
        filterInitialized: false
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
          Vue.set(this.filterList[key], 'db_name', key)
          typeof this.filterList[key]['col'] === 'undefined' ? Vue.set(this.filterList[key], 'col', 4) : ''
        }
        this.filterInitialized = true
      },
      filterForm(){
        this.$emit('filter', this.$refs.form)
      }
    }

  }
</script>
<style scoped>

</style>
