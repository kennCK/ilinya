<template>
  <div id="app">
    <div v-bind:style="(globalVariables.showModal) ? 'overflow-y:hidden; height:'+deviceHeight+'px!important': ''">
      <div v-if="!tokenData.verifyingToken && tokenData.token">
       <system-header></system-header>
       <system-sidebar v-if="user.company_branch_id !== null"></system-sidebar>
       <system-content v-if="user.company_branch_id === null"></system-content>
      </div>
      <div v-else>
        <login-header></login-header>
      </div>
    </div>
    <system-footer></system-footer>
  </div>
</template>
<script>
import ROUTER from './router'
import AUTH from './services/auth'
import global from './helpers/global'
export default {
  name: 'app',
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      currentRoute: ROUTER.currentRoute.name,
      deviceHeight: document.documentElement.clientHeight,
      appGlobal: {
        showModal: false
      },
      globalVariables: global
    }
  },
  methods: {
    logOut(){
      AUTH.deaunthenticate()
      ROUTER.push({
        path: '/'
      })
    }
  },
  components: {
    'login-header': () => import('modules/frame/LoginHeader.vue'),
    'system-header': () => import('modules/frame/Header.vue'),
    'system-sidebar': () => import('modules/frame/Sidebar.vue'),
    'system-content': () => import('modules/frame/Content.vue'),
    'system-footer': () => import('modules/frame/Footer.vue')
  }
}
</script>

<style>
.half-width{
  width: 50%
}
.push-half-right{
  margin-left: 50%
}
.nav a{
  font-size: 15px
}
.dropdown-menu li a{
  padding: 10px;
}
.container {
   min-height:100%;
   position:relative;
}
</style>
