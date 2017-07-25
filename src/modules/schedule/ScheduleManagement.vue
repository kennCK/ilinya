<template>
    <div class="container-fluid">
      <div class="row">
        <div class="menu-holder col-sm-12 col-md-4 col-lg-3" v-on:click="push('company_schedule')">
          <div class="header text-center">
           Company Schedule
          </div>
          <div class="content">
          </div>
        </div>
        <div class="menu-holder col-sm-12 col-md-4 col-lg-3 offset-1" v-on:click="push('employee_schedule')">
          <div class="header text-center">
           Employee Schedule
          </div>
          <div class="content">
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import ROUTER from '../../router'
export default {
  mounted(){
  },
  data(){
    return{
    }
  },
  methods: {
    push(url){
      ROUTER.push(url)
    }
  }
}
</script>
<style scoped>
  .menu-holder{
    height: 350px;
    background: #006600;
    color: #fff;
    float: left;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
  }
  .menu-holder:hover{
    cursor: pointer;
    background: #009900;
  }
  .menu-holder .header{
    height: 50px;
    font-weight: 400px;
    padding: 15px 0 15px 0;
  }
  .menu-holder .content{
    height: 300px;
    border-top: solid 1px #fff;
  }
</style>
