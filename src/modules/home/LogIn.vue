<template>
  <div class="container-fluid custom-container" v-if="!tokenData.verifyingToken && !tokenData.token">
    <div class="row">
      <div class="col-sm-12 col-md-8 hide-this">
        <div class="container-fluid banner">
          <img src="../../assets/img/Top.png"  height="100%" width="100%">
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="login-wrapper">
          <div class="login-header">
            <h1 class="navbar-brand">
              Log In
            </h1>
          </div>
          <div class="login-message-holder login-spacer" v-if="errorMessage != ''">
            <span class="text-danger"><b>Oops!</b> {{errorMessage}}</span>
          </div>
          <div>
            <div class="input-group login-spacer">
              <span class="input-group-addon" id="addon-1"><i class="fa fa-user"></i></span>
              <input type="text" class="form-control form-control-login" placeholder="Username or Email" aria-describedby="addon-1" v-model="username">
            </div>
            <div class="input-group login-spacer">
              <span class="input-group-addon" id="addon-2"><i class="fa fa-key"></i></span>
              <input type="password" class="form-control form-control-login" placeholder="********" aria-describedby="addon-2" v-model="password">
            </div>
            <button class="btn btn-primary btn-block btn-login login-spacer" v-on:click="logIn()">Login</button>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input">
                Keep me logged in
              </label>
            </div>
            <div class="container-fluid text-center forgot-password">
                <a class="btn-link" v-on:click="redirect('recover_account')">Forgot Password?</a>
            </div>
            <br>
            <div class="container-fluid separator">
                or
            </div>
            <br>
            <button class="btn btn-primary btn-block btn-login login-spacer" v-on:click="redirect('registration')">Register New Company</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  mounted(){
  },
  data(){
    return {
      username: '',
      password: '',
      errorMessage: '',
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      branchesEmployees: [],
      branches: []
    }
  },
  methods: {
    logIn(){
      AUTH.authenticate(this.username, this.password, (response) => {
        this.setCompanyAuth()
      }, (response, status) => {
        this.errorMessage = (status === 401) ? 'Your Username and password didnot matched.' : 'Cannot log in? Contact us through email: support@ilinya.com'
      })
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    setCompanyAuth(){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'clause': '=',
          'value': this.user.userID
        }]
      }
      this.APIRequest('company_branch_employee/retrieve', parameter).then(response => {
        this.branchesEmployees = response.data
        if(this.branchesEmployees.length > 1){
          ROUTER.push('select')
        }else{
          let parameter1 = {
            'condition': [{
              'column': 'id',
              'clause': '=',
              'value': this.branchesEmployees[0].company_branch_id
            }]
          }
          this.APIRequest('company_branch/retrieve', parameter1).then(response => {
            this.branches = response.data
            if(this.branches.length === 1){
              AUTH.setCompany(this.branches[0].company_id, this.branchesEmployees[0].company_branch_id)
              ROUTER.push('admin_home')
            }
          })
        }
      })
    }
  }
}
</script>
<style>
/*
  Designs Rules
  1. Top to Bottom
  2. Left to Right
  3. Common
  4. Screen Changes
*/

.app-img{
  float: left;
  width: 30%;
  text-align: right;
}
.app-title{
  float: left;
  width: 70%;
  text-align: left;
}
.app-img img{
  height: 50px;
  width: 50px;
}

.app-title label{
  vertical-align: middle;
  font-size: 30px;
  left: 0;
}
.login-header{
  height: 40px;
  color: #006600;
  width: 100%;
  float: left;
}/*-- login-header --*/

.login-message-holder{
  min-height: 30px;
  font-size: 12px;
  float: left;
  overflow: hidden;
}

.login-spacer{
  margin-bottom: 10px;
}/*-- login-spacer --*/

.forgot-password a{
  color: #006600 !important;
}
.forgot-password a:hover{
  cursor: pointer !important;
  text-decoration: underline !important;
  color: #009900 !important;
}

/*----------------------------------------

            Forms

------------------------------------------*/
.form-control-login{
  height: 45px;
}


/*----------------------------------------

            Buttons

------------------------------------------*/
.btn-login{
  height: 45px;
}/*-- form-control --*/

/*    Line with text on top  */
.separator>*{
  display: inline-block;
  vertical-align: middle;
}
.separator {
    text-align: center;
    border: 0;
    white-space: nowrap;
    display: block;
    overflow: hidden;
    padding: 0;
    margin: 0;
}
.separator:before, .separator:after {
    content: "";
    height: 1px;
    width: 50%;
    background-color: #ccc;
    margin: 0 5px 0 5px;
    display: inline-block;
    vertical-align: middle;
}
.separator:before {
    margin-left: -100%;
}
.separator:after {
    margin-right: -100%;
}

/*---------------------------------------------------------

                  RESPONSIVE HANDLER

-----------------------------------------------------------*/

/*-------------- Large Screens for Desktop --------------*/
@media (min-width: 1200px){
  .login-wrapper{
    width: 80%;
    margin: 0 5% 0 15%;
  }
}


/*-------------- Medium Screen for Tablets  --------------*/
@media screen (min-width: 992px), screen and (max-width: 1199px){
  .login-wrapper{
    width: 80%;
    margin: 0 5% 0 15%;
  }
}

/*-------------- Small Screen for Mobile Phones  --------------*/
@media screen (min-width: 768px), screen and (max-width: 991px){
  .login-wrapper{
    width: 98%;
    margin: 0 2% 0 0%;
  }
}

/*-------------- Extra Small Screen for Mobile Phones --------------*/
@media (max-width: 767px){
  .hide-this{
    display: none;
  }
  .login-wrapper{
    width: 80%;
    margin: 0 10% 0 10%;
  }
}
</style>
