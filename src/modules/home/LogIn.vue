<template>
  <div class="container-fluid custom-container" v-if="!tokenData.verifyingToken && !tokenData.token">
    <div class="row">
      <div class="col-sm-12 col-md-8 hide-this">
        <div class="container-fluid banner">
          <h2 class="primary-color">
            Stay connected with your Employees.
          </h2>
          <p class="banner-content">

          </p>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="login-wrapper">
          <div class="text-center app-logo">
            <span class="app-img">
              <img src="../../assets/img/godigit.png" height="100%" width="100%">
            </span>
            <span class="app-title primary-color">
              <label>Go<b>Digit</b></label>
            </span>
          </div>
          <div class="login-header">
            <h1 class="navbar-brand">
              Log In
            </h1>
          </div>
          <div class="login-message-holder login-spacer" v-if="errorMessage != ''">
            <span class="text-danger"><b>Oops!</b> {{errorMessage}}</span>
          </div>
          <div>
            <form>
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
              <button class="btn btn-primary btn-block btn-login login-spacer">Create Account</button>
              <button class="btn btn-primary btn-block btn-login login-spacer" v-on:click="redirect('registration')">Register New Company</button>
            </form>
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
  name: 'LogIn',
  mounted(){
  },
  data(){
    return {
      username: '',
      password: '',
      isLoading: false,
      errorMessage: '',
      user: AUTH.user,
      tokenData: AUTH.tokenData
    }
  },
  methods: {
    logIn(){
      this.isLoading = true
      AUTH.authenticate(this.username, this.password, (response) => {
        this.isLoading = false
        this.checkBranch()
      }, (response, status) => {
        this.errorMessage = (status === 401) ? 'Your Username and password didnot matched.' : 'Cannot log in? Contact us through email: official@godigit.ph'
        this.isLoading = false
      })
    },
    checkBranch(){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'value': this.user.userID,
          'clause': '='
        }],
        'with_foreign_table': [
          'company_branch'
        ]
      }
      this.APIRequest('company_branch_employee/retrieve', parameter).then(response => {
        let route = (response.data.length > 1) ? 'company_selection' : '/'
        if(response.data.length === 1){
          AUTH.setCompany(response.data[0].company_branch.company_id, response.data[0].company_branch_id)
        }
        ROUTER.push(route)
      })
    },
    redirect(parameter){
      ROUTER.push(parameter)
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

body{
  font-size: 13px;
  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
  font-weight: 400;
}
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
.form-control{
  height: 35px;
  font-size: 12px;
}
.form-control-login{
  height: 45px;
}


/*----------------------------------------

            Buttons

------------------------------------------*/
.btn-login{
  height: 45px;
}/*-- form-control --*/

.btn{
  font-size: 12px;
}
.btn:hover{
  cursor: pointer;
}


/*
        SOLID
*/
.btn-primary{
  background: #006600;
  border-color: #006600;
}

.btn-primary:hover{
  background: #009900;
  border-color: #009900;
}

.btn-danger{
  background: #aa0000;
}

.btn-danger:hover{
  background: #ff0000;
  border-color: #ff0000;
}

/*
      HALLOW
    
*/

.btn-primary-hallow{
  border-color: #006600;
  color: #006600;
  background: #fff;
}
.btn-primary-hallow:hover{
  color: #009900;
  border-color: #009900;
}
.btn-danger-hallow{
  border-color: #aa0000;
  background: #fff;
  color: #aa0000;
}
.btn-danger-hallow:hover{
  color: #ff0000;
  border-color: #ff0000;
}


/*------------------------------------
  
          TABLES

--------------------------------------*/

.table{
  font-size: 12px;
}

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

/*      Colors           */
.primary-color{
  color: #006600;
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
