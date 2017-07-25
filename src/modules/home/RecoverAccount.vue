<template>
    <div class="col-sm-4 offset-sm-4 custom-container">
      <div class="header-title">
        <i class="fa fa-home" aria-hidden="true" v-on:click="redirect()"></i>
        <span>Account Recovery</span>
      </div>
      <input-group :inputs="inputs" :form_status="'create'" :error_list="errorList"></input-group>
      <button class="btn btn-primary pull-right" v-on:click="send()">Send</button>
    </div>
</template>
<script>
import ROUTER from '../../router'
export default {
  name: '',
  components: {
    'input-group': require('components/input_field/InputGroup.vue')
  },
  mounted(){
  },
  data(){
    return{
      inputs: {
        email: {
          placeholder: 'Email Address'
        }
      }
    }
  },
  methods: {
    send(){
    },
    redirect(){
      ROUTER.push('/')
    }
  }
}
</script>
<style>
</style>
