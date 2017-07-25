<template>
  <div>
    <select class="form-control"
      v-if="form_status !== 'view'"
      v-bind:name="db_name"
      v-bind:value="form_data[db_name] ? form_data[db_name] : defaultValue"
      @change="$emit('change', $event)"
    >
      <option v-for="option in options" v-bind:value="option['value']">
        {{option['label']}}
      </option>
    </select>
    <span v-else class="form-control">{{this.option_lookup[form_data[db_name]]}}</span>
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
      default_value: String,
      db_name: String,
      form_data: Object,
      form_status: String
    },
    methods: {
      initInputSetting(){
        (typeof this.input_setting['options'] !== 'undefined') ? this.setOption(this.input_setting['options']) : null
        this.defaultValue = this.default_value ? this.default_value : null
      },
      setOption(options){
        this.options = options
        this.option_lookup = {}
        for(let x in this.options){
          this.option_lookup[this.options[x]['value']] = this.options[x]['label']
        }
      },
      valueChanged(e){
        this.$emit('value_changed', e)
      }
    }

  }
</script>
<style scoped>

</style>
