<template>
  <div>
    <textarea class="form-control" rows="3"
      v-bind:name="db_name"
      v-bind:placeholder="placeholder"
      v-bind:value="form_data[db_name] ? form_data[db_name] : defaultValue"
      v-bind:class="feedback_status_class"
    >

    </textarea>
  </div>
</template>
<script>
  export default{
    name: '',
    create(){

    },
    mounted(){
      this.init()
    },
    data(){
      return {
        defaultValue: null
      }
    },
    props: {
      db_name: String,
      field_name: String,
      placeholder: String,
      form_data: Object,
      form_status: String,
      default_value: [String, Number],
      feedback_status_class: String

    },
    methods: {
      init(){
        this.defaultValue = this.default_value ? this.default_value : null
      }
    }

  }
</script>
<style scoped>

</style>
