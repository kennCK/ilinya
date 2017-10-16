<template>
  <div>
    <input type="hidden"
      ref="dateInput"
      v-bind:name="db_name"
      @change="valueChanged"
    >
    <input ref="datePickerInput" class="form-control date"
      v-if="form_status !== 'view'"
      type="text"
      v-bind:value="form_data[db_name] ? form_data[db_name] : defaultValue"
      v-bind:placeholder="defaultFormat"
    >
    <span v-else class="form-control"> &nbsp;</span>

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
        defaultValue: null,
        defaultFormat: 'MM/DD/YYYY',
        defaultTimeValue: '',
        dateInputTrueValue: null,
        changeTriggered: false
      }
    },
    props: {
      input_setting: Object,
      default_value: [String, Number],
      db_name: String,
      form_data: Object,
      form_status: String
    },
    watch: {
      form_status(value){
        if(value === 'create' || value === 'editing' || value === 'view'){
        }
      },
      options(value){
      }
    },
    methods: {
      initInputSetting(){
        this.defaultValue = this.default_value ? this.default_value : null
        $(this.$refs.datePickerInput).datetimepicker({
          format: 'MM/DD/YYYY',
          enabledHours: false,
          defaultDate: false,
          useCurrent: false,
          showClear: true,
          showClose: true
        })
        .on('dp.change', (e) => {
          this.changeTriggered = true
          if(e.date){
            $(this.$refs.dateInput).val(this.dateInputTrueValue = e.date.year() + '-' + this.padNumber(e.date.month() + 1, 2) + '-' + this.padNumber(e.date.date(), 2) + ' ' + this.defaultTimeValue)
          }else{
            $(this.$refs.dateInput).val(null)
          }
          $(this.$refs.dateInput).change()

        })
        .on('dp.show', (e) => {
          this.changeTriggered = false
        })
        .on('dp.hide', (e) => {
          if(this.changeTriggered === false && $(this.$refs.datePickerInput).val() === ''){
            $(this.$refs.dateInput).val(null)
            $(this.$refs.dateInput).change()
          }
        })
        $(this.$refs.dateInput).on('change', (e) => {
          this.valueChanged(e)
        })
        if(this.input_setting){
          if(this.input_setting['time_setting']){
            typeof this.input_setting['time_setting']['default_time'] !== 'undefined' ? this.defaultTimeValue = this.input_setting['time_setting']['default_time'] : ''
          }
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
