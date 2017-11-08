<template>
  <div>
    <select class="form-control"
      v-if="form_status !== 'view'"
      v-bind:name="input_name"
      v-bind:field_name="field_name"
      v-bind:value="form_data[db_name] ? form_data[db_name] : defaultValue"
      v-bind:class="feedback_status_class"
      @change="valueChanged"
    >
      <option v-for="option in options" v-bind:value="option['value']"
        v-bind:selected="option['value'] == form_data[db_name] ? 'selected' : false"
      >
        {{option['label']}}
      </option>
    </select>
    <span v-else class="form-control">{{this.option_lookup[form_data[db_name]]}} &nbsp;</span>

  </div>
</template>
<script>
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.initInputSetting()
    },
    data(){
      return {
        options: [],
        option_lookup: {},
        defaultValue: null
      }
    },
    props: {
      input_setting: Object,
      default_value: [String, Number],
      db_name: String,
      input_name: String,
      field_name: String,
      form_data: Object,
      form_status: String,
      feedback_status_class: String
    },
    watch: {
      form_status(value){
        if(value === 'create' || value === 'editing' || value === 'view'){
          if(typeof this.input_setting['option_function'] !== 'undefined'){
            this.input_setting['option_function'](this)
          }
        }
      },
      options(value){
      }
    },
    methods: {
      initInputSetting(){
        typeof this.input_setting['options'] !== 'undefined' ? this.setOption(this.input_setting['options']) : null
        this.defaultValue = this.default_value ? this.default_value : null
        if(typeof this.input_setting['option_function'] !== 'undefined'){
          this.input_setting['option_function'](this)
        }
      },
      setOption(options){
        this.options = options
        this.option_lookup = {}
        for(let x in this.options){
          this.option_lookup[this.options[x]['value']] = this.options[x]['label']
        }
      },
      valueChanged(e){

        this.$emit('change', e)
      }
    }

  }
</script>
<style scoped>

</style>
