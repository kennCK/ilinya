<template>
  <div class="form-group row" v-bind:class="[feedbackStatus ? 'has-feedback' :'', feedbackStatusClass]">
    <input v-if="inputType === 'hidden'" type="text"
    v-bind:name="inputName"
    v-on:change="valueChanged"
    v-bind:value="form_data|getFormDataFilter(db_name, default_value)"
    >
    <template v-else>
      <label v-if="labelColspan" class="col-form-label" v-bind:class="'col-sm-' + labelColspan">{{labelText}} :</label>
      <div v-bind:class="'col-sm-' + (12 - (labelColspan !== 12 ? labelColspan : 0))">
        <radio-button
          v-if="inputType === 'radio'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :default_value="default_value"
          :feedback_status_class="feedbackStatusClass"
          >
        </radio-button>
        <check-list
          v-else-if="inputType === 'checklist'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :feedback_status_class="feedbackStatusClass"

          >
        </check-list>
        <select-input
          v-else-if="inputType === 'select'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :default_value="default_value"
          v-on:change="valueChanged"
          :feedback_status_class="feedbackStatusClass"

          >
        </select-input>
        <date-picker
          v-else-if="inputType === 'date'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :default_value="default_value"
          v-on:change="valueChanged"
          :feedback_status_class="feedbackStatusClass"

          >
        </date-picker>
        <single-image
          v-else-if="inputType === 'single_image'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :form_data_updated="form_data_updated"
          v-on:change="valueChanged"

          >
        </single-image>
        <textarea-input
          v-else-if="inputType === 'textarea'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :placeholder="placeholder"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :form_data_updated="form_data_updated"
          v-on:change="valueChanged"
          :feedback_status_class="feedbackStatusClass"

          >
        </textarea-input>
        <check-box
          v-else-if="inputType === 'checkbox'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :default_value="default_value"
          v-on:change="valueChanged"
          :feedback_status_class="feedbackStatusClass"
          >
        </check-box>
        <select2
          v-else-if="inputType === 'select2'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :default_value="default_value"
          :placeholder="placeholder"
          v-on:change="valueChanged"
          :feedback_status_class="feedbackStatusClass"
          >
        </select2>
        <table-input
          v-else-if="inputType === 'table-input'"
          :input_setting="input_setting"
          :db_name="dbName"
          :input_name="inputName"
          :field_name="field_name"
          :form_data="form_data"
          :form_status="form_status"
          :default_value="default_value"
          :placeholder="placeholder"
          :form_data_updated="form_data_updated"
          v-on:change="valueChanged"
          >
        </table-input>
        <template
          v-else-if="inputType === 'static'"
        >
          {{form_data[db_name]}}
        </template>
        <template v-else>
          <input
            v-if="form_status !== 'view' && !read_only"
            v-bind:name="inputName"
            v-bind:placeholder="inputPlaceholder"
            v-bind:type="inputType"
            class="form-control"
            v-bind:class="feedbackStatusClass"
            v-on:change="valueChanged"
            v-bind:value="form_data|getFormDataFilter(db_name, default_value)"
            >
          <span v-else class="form-control">{{form_data|getFormDataFilter(db_name, default_value)}}&nbsp;</span>
        </template>
        <input class="form-control" v-bind:class="feedbackStatusClass" type="hidden">
        <div v-if="feedbackMessage" class="invalid-feedback">{{feedbackMessage}}</div>
        <small v-if="muted_text" class="form-text text-muted">{{muted_text}}</small>
      </div>
    </template>
  </div>
</template>
<script>
  // form_data[db_name] ? form_data[db_name] : default_value
  export default{
    name: '',
    components: {
      'radio-button': require('./RadioButton.vue'),
      'check-box': require('./Checkbox.vue'),
      'check-list': require('./CheckList.vue'),
      'select-input': require('./Select.vue'),
      'select2': require('./Select2.vue'),
      'textarea-input': require('./Textarea.vue'),
      'single-image': require('./SingleImage.vue'),
      'table-input': require('./TableInput.vue'),
      'date-picker': require('./DatePicker.vue')
    },
    create(){

    },
    mounted(){
      this.initSetting()
    },
    props: {
      input_name: String,
      db_name: String,
      field_name: String,
      label: String,
      label_style: Object,
      label_colspan: Number,
      form_data: {
        type: Object,
        default: () => {
          return {}
        }
      },
      input_type: String,
      input_setting: Object,
      input_style: Object,
      placeholder: String,
      muted_text: String,
      form_data_updated: Boolean,
      form_status: String,
      default_value: [String, Number],
      error_list: Object,
      read_only: Boolean
    },
    data(){
      return {
        dbName: null,
        inputName: '',
        labelText: null,
        labelStyle: {},
        labelColspan: 3,
        inputType: 'text',
        inputSetting: {},
        inputStyle: {},
        inputPlaceholder: null,
        feedbackStatusClass: '',
        feedbackStatus: 0, // 0 - none, 1 - success, 2 - danger, 3 - warning
        feedbackMessage: '',
        value: null

      }
    },
    watch: {
      form_status(value){
      },
      form_data_updated(value){
        this.feedbackStatus = 0
        this.feedbackMessage = ''
      },
      error_list(value){
        if(typeof this.error_list[this.db_name] !== 'undefined'){
          this.feedbackStatus = 2
          this.feedbackMessage = this.error_list[this.db_name][0]
        }
      },
      feedbackStatus(value){
        this.feedbackMessage = this.feedbackMessage
        switch(value * 1){
          case 1:
            this.feedbackStatusClass = 'is-valid'
            break
          case 2:
            this.feedbackStatusClass = 'is-invalid'
            break
          case 3:
            this.feedbackStatusClass = 'has-warning'
            break
          default:
            this.feedbackStatusClass = ''
            break
        }
      }
    },
    methods: {
      initSetting(){
        this.dbName = this.db_name
        this.inputName = this.inputName ? this.input_name : this.dbName
        this.labelText = this.label ? this.label : this.input_name
        this.labelStyle = this.label_style
        this.labelColspan = typeof this.label_colspan !== 'undefined' ? this.label_colspan : 4
        this.inputType = this.input_type ? this.input_type : 'text'
        this.inputStyle = this.input_style
        this.inputPlaceholder = this.placeholder ? this.placeholder : this.labelText

        let dbNameTemp = this.inputName.split('.')
        if(dbNameTemp.length > 1){
          this.inputName = dbNameTemp[0]
          for(let x = 1; x < dbNameTemp.length; x++){
            this.inputName += (dbNameTemp[x] === '*' ? '[]' : '[' + dbNameTemp[x] + ']')
          }
        }
        console.log(this.inputName)
      },
      formDataUpdated(){
      },
      valueChanged(e, customName){
        this.feedbackStatus = 0
        this.feedbackMessage = ''
        $(e.target).attr('field_name', this.field_name)
        this.$emit('value_changed', e, customName)
      }
    }

  }
</script>
<style scoped>

</style>
