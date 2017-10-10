 <template>
  <div v-if="!tokenData.verifyingToken && !tokenData.token">
    <div>
      <div class="system-header">
        <a class="navbar-brand" href="#">
          <label class="navbar-brand"><b>i</b>Linya</label>
        </a>
      </div>
      <nav class="header-navbar">
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
  .system-header{
    float: left;
    height: 50px;
    font-size: 24px;
    width: 18%;
    background: #fff;
    text-align: center;
    border-bottom: solid 1px #eee;
    margin-bottom: 20px;
  }
  .header-navbar{
    background: #fff;
    height: 50px;
    float: left;
    width: 82%;
    border-bottom: solid 1px #eee;
    margin-bottom: 20px;
  }/*-- navbar --*/
  .system-header .navbar-brand{
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
  .header-navbar-nav{
      height: 50px;
      float: right;
      color: #fff;
      width: 20%;
  }
  .header-navbar-nav label{
    font-size: 13px;
    font-weight: 500;
    vertical-align: middle;
    padding-left: 10px;
  }
  .header-navbar-nav i{
    font-size: 24px;
     padding: 10px 0 0 5%;
  }

  .header-navbar-nav:hover{
    cursor: pointer;
    background: #006600;
  }


/*---------------------------------------------
 
 
        ICONS


-----------------------------------------------*/

.nav-item{
  width: 15%;
  height: 50px;
  text-align: center;
  float: left;
  color: #006600;
  display: inline;
}
.header-margin{
  height: 50px;
  float: left;
  width: 85%;
}

.nav-item span i{
  padding: 12px 0 15px 0;
  font-size: 16px;
}

.nav-item .label{
  z-index: 1000;
  background: #ff0000;
  padding: 5px;
  font-size: 8px;
  margin: -10px 0 0 -10px;
  border-radius: 2px;
  border-color: solid 1px #009900;
}

.nav-item:hover{
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
    .system-header{
      width: 23%;
    }
    .header-navbar{
      width: 77%;
    }
    .header-margin{
      width: 85%;
    }
    .nav-item{
      width: 15%;
    }
  }

 @media screen (min-width: 992px), screen and (max-width: 1199px){
    .system-header{
      width: 23%;
    }
    .header-navbar{
      width: 77%;
    }
    .header-margin{
      width: 80%;
    }
    .nav-item{
      width: 20%;
    }
  }

@media screen (min-width: 768px), screen and (max-width: 991px){
   .system-header{
      width: 100%;
    }
    .header-navbar{
      width: 100%;
      display: none;
    }
    .header-margin{
      width: 70%;
    }
    .nav-item{
      width: 30%;
    }
 }

/*-------------- Small Screen for Mobile Phones --------------*/
 @media (max-width: 767px){
    .header-margin{
     width: 50%;
    }
    .system-header{
      width: 100%;
    }
    .header-navbar{
      display: none;
    }
    .nav-item{
      width: 50%;
    }
  } 

</style>
