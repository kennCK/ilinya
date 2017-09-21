 <template>
  <div v-if="!tokenData.verifyingToken && !tokenData.token">
    <nav class="login-navbar">
      <div class="login-navbar-brand">
        <a class="navbar-brand" href="#">
          <label><b>i</b>Linya</label>
        </a>
      </div>
      <!--<div class="login-navbar-nav">
          <a class="login-navbar-link" data-toggle="modal" data-target="#goCentralApps"><i class="fa fa-sitemap"></i></a>
      </div>
    -->
    </nav>
    <div>
      <transition>
          <router-view ></router-view>
      </transition> 
    </div> 
  </div> 
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData
    }
  }
}
</script>
<style type="text/css">
  .login-navbar{
    border-bottom:solid 1px #eee;
    height: 50px;
  }/*-- navbar --*/
  .login-navbar .navbar-brand{
    color: #006600;
  }
  .navbar .navbar-brand:hover{
    color: #009900;
  }
  .login-navbar-brand label{
    font-size: 24px;
  }
  .login-navbar-brand{
    width: 69%;
    float: left;
    height: 50px;
    margin-left: 1%;
  }
  .login-navbar-nav{
    list-style: none;
    width: 28%;
    height: 50px;
    margin-right: 2%;
    float: right;
    text-align: right;
  }
  .login-navbar-brand i, .login-navbar-nav a, .login-navbar-nav i{
    color: #006600;
    vertical-align: middle;
    font-size: 30px;
  }
  .login-navbar-nav a:hover, .login-navbar-brand i:hover, .login-navbar-nav i:hover{
    color: #009900;
    cursor: pointer;
  }



  /*


        CUSTOM CONTAINER


  */
  .custom-container{
    min-height: 80vh;
    margin-top: 50px;
    width: 100%;
    float: left;
  }
  .header-title{
    height: 50px;
    width: 100%;
    vertical-align: middle;
  }
  .header-title i{
    height: 50px;
    width: 50px;
    float: left;
    font-size: 24px;
    padding: 5px 0 10px 0;
  }
  .header-title span{
    font-size: 24px;
    font-weight: 600;
    float: left;
  }
  .header-title i:hover{
    color: #009900;
    cursor: pointer;
  }
</style>
