<template>
  <div class="container">
    <common-form
      :api="api"
      :inputs="inputs"
    >
    </common-form>
  </div>
</template>
<script>
  export default{
    name: '',
    components: {
      'common-form': require('../../components/form/CommonForm.vue')
    },
    create(){
    },
    mounted(){
    },
    data(){
      return {
        api: 'department',
        inputs: {
          parent_id: {
            name: 'Parent',
            muted_text: 'The head',
            input_type: 'radio'
          },
          description: {
            input_type: 'select'
          }
        }
      }
    },
    props: {
    },
    methods: {
    }
  }
</script>
<style scoped>
</style>
