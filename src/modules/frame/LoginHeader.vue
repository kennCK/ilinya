 <template>
  <div v-if="!tokenData.verifyingToken && !tokenData.token">
    <div>
      <div class="login-system-header">
        <a class="login-navbar-brand" href="#">
          <label class="navbar-brand"><b>i</b>Linya</label>
        </a>
      </div>
      <nav class="login-header-navbar">
 <!--        <div class="header-margin"></div>
        <div class="nav-item" id="book-now">
          <span>
            <i class="fa fa-user-plus"></i>
            <label>Register</label>
          </span>
        </div> -->
      </nav>
    </div>
    <div class="login-content">
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
body{
  font-size: 13px;
  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;
  font-weight: 400;
}

/*      Colors           */
.primary-color{
  color: #006600;
}
/*------------------------------------

          FORMS

--------------------------------------*/

.form-control{
  height: 35px;
  font-size: 12px;
}

/*------------------------------------

          TABLES

--------------------------------------*/

.table{
  font-size: 12px;
}
  /*
        CUSTOMIZE BUTTON
*/
.btn{
  font-size: 12px;
}
.btn:hover{
  cursor: pointer;
}
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
  .login-system-header{
    float: left;
    height: 50px;
    font-size: 24px;
    width: 18%;
    background: #fff;
    text-align: center;
    border-bottom: solid 1px #eee;
    margin-bottom: 20px;
  }
  .login-header-navbar{
    background: #fff;
    height: 50px;
    float: left;
    width: 82%;
    border-bottom: solid 1px #eee;
    margin-bottom: 20px;
  }/*-- navbar --*/
  .login-system-header .login-navbar-brand{
    color: #006600;
  }
  

  .login-content{
    width: 100%;
    min-height: 84.5vh;
    float: left;
  }
/*---------------------------------------------
 

        HEADER ACCOUNT PROFILE


-----------------------------------------------*/
  .login-header-navbar-nav{
      height: 50px;
      float: right;
      color: #fff;
      width: 20%;
  }
  .login-header-navbar-nav label{
    font-size: 13px;
    font-weight: 500;
    vertical-align: middle;
    padding-left: 10px;
  }
  .login-header-navbar-nav i{
    font-size: 24px;
     padding: 10px 0 0 5%;
  }

  .login-header-navbar-nav:hover{
    cursor: pointer;
    background: #006600;
  }


/*---------------------------------------------
 
 
        ICONS


-----------------------------------------------*/

.login-nav-item{
  width: 15%;
  height: 50px;
  text-align: center;
  float: left;
  color: #006600;
  display: inline;
}
.login-header-margin{
  height: 50px;
  float: left;
  width: 85%;
}

.login-nav-item span i{
  padding: 12px 0 15px 0;
  font-size: 16px;
}

.login-nav-item .label{
  z-index: 1000;
  background: #ff0000;
  padding: 5px;
  font-size: 8px;
  margin: -10px 0 0 -10px;
  border-radius: 2px;
  border-color: solid 1px #009900;
}

.login-nav-item:hover{
  background: #006600;
  cursor: pointer;
  color: #fff;
}

#book-now{
  border-right: solid 1px #eee;
  border-left: solid 1px #eee;
}


/*---------------------------------------------------------          

                  RESPONSIVE HANDLER

-----------------------------------------------------------*/
/*-------------- Medium and Large Screens for Tablets and Desktop --------------*/

 @media screen (min-width: 1200px){
    .login-system-header{
      width: 23%;
    }
    .login-header-navbar{
      width: 77%;
    }
    .login-header-margin{
      width: 85%;
    }
    .login-nav-item{
      width: 15%;
    }
  }

 @media screen (min-width: 992px), screen and (max-width: 1199px){
    .login-system-header{
      width: 23%;
    }
    .login-header-navbar{
      width: 77%;
    }
    .login-header-margin{
      width: 80%;
    }
    .login-nav-item{
      width: 20%;
    }
  }

@media screen (min-width: 768px), screen and (max-width: 991px){
   .login-system-header{
      width: 100%;
    }
    .login-header-navbar{
      display: none;
    }
    .login-header-margin{
      width: 70%;
    }
    .login-nav-item{
      width: 30%;
    }
 }

/*-------------- Small Screen for Mobile Phones --------------*/
 @media (max-width: 767px){
    .login-header-margin{
     width: 50%;
    }
    .login-system-header{
      width: 100%;
    }
    .login-header-navbar{
      display: none;
    }
    .login-nav-item{
      width: 50%;
    }
  } 

</style>
