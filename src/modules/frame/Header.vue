 <template>
  <div>
      <!---

              Header Brand

      -->
    <div class="system-header">
      <a class="navbar-brand" href="#">
        <label class="navbar-brand"><b>i</b>Linya</label>
      </a>
    </div>
    <nav class="header-navbar">
      <span class="navbar-menu-toggler-md" data-toggle="collapse" data-target="#iLinyaSidebar" aria-controls="iLinyaSidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </span>
      <!---

              Header Profile

      -->
      <div class="header-navbar-nav dropdown">
         <span data-toggle="dropdown" id="#account">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <label>Hi {{user.username}}!</label>
         </span>
         <span class="dropdown-menu" id="account">
          <span class="dropdown-item-profile">
            <span class="account-picture text-center">
              <img src="../../assets/img/sample.jpg" class="rounded-circle" height="125" width="125">
            </span>
            <span class="account-info text-center">{{user.username}}</span>
          </span>
          <span class="dropdown-item-button text-center"><button class="btn btn-danger-hallow" v-on:click="logOut()">Logout</button></span>
        </span>
      </div>
      <!---

              Header Menu Toggler

      -->
    </nav>
  </div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  created(){
  },
  data(){
    return{
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      branches: [],
      popover: ['myBranches', 'myMessages', 'myNotifications'],
      popoverValue: [
        ['Company Branches'],
        ['Messages'],
        ['Notifications']
      ]
    }
  },
  methods: {
    logOut(){
      AUTH.deaunthenticate()
      ROUTER.go('/')
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
    background: #006600;
    text-align: center;
  }
  .header-navbar{
    background: #009900;
    height: 50px;
    float: left;
    width: 82%;
  }/*-- navbar --*/
  .system-header .navbar-brand{
    color: #fff;
  }

/*---------------------------------------------
  HEADER ICONS
      Contents:
          *Branch Switcher
          *Messages
-----------------------------------------------*/
  .margin-in-full{
    width: 65%;
    float: left;
    height: 50px;
  }
  .header-navbar-icons{
    height: 50px;
    float: left;
    text-align: center;
    font-size: 16px;
    width: 5%;
    color: #fff;
    padding: 10px 0 15px 0;
  }
  .header-navbar-icons:hover{
    cursor: pointer;
    background: #006600;
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


        HEADER TOGGLER MENU


-----------------------------------------------*/
  .navbar-menu-toggler-md{
    height: 50px;
    float: left;
    text-align: center;
    font-size: 16px;
    color: #fff;
    padding: 10px 0 15px 0;
    display: none;
  }
  .navbar-menu-toggler-md:hover{
    cursor: pointer;
    background: #006600;
  }

.dropdown-menu{
  width: 300px;
  border-radius: 0px !important;
}
#account{
  height: 250px;
  right: 0;
  left: auto;
  background: #009900;
  border: 0px;
}
.dropdown-item{
  width: 100%;
  height: 40px;
  float: left;
  background: #fff;
}
.dropdown-header{
  padding: 5px 0 10px 0;
  width: 100%;
  text-align: center;
  border-bottom: solid 1px #ccc;
}
.dropdown-item-profile{
  height: 200px;
  width: 100%;
  float: left;
  top: 0;
}
.account-picture{
  height: 150px;
  width: 100%;
  float: left;
}
.account-info{
  height: 50px;
  width: 100%;
  float: left;
  color: #fff;
}
.dropdown-item-button{
  height: 50px;
  width: 100%;
  border-top:solid 1px #ccc;
  float: left;
  background: #fff;
  border: solid 1px #009900;
}
.dropdown-item-button button{
  height: 40px;
  border-radius: 0;
  width: 100px;
  margin-top: 5px;
}
.dropdown-item-button button:hover{
  background: #ff0000;
  color: #fff;
}





/*---------------------------------------------------------

                  RESPONSIVE HANDLER

-----------------------------------------------------------*/
/*-------------- Medium and Large Screens for Tablets and Desktop --------------*/

 @media screen (min-width: 992px), screen and (max-width: 1199px){
    .system-header{
      width: 23%;
    }
    .header-navbar{
      width: 77%;
    }
    .header-navbar-nav{
      width: 15%;
    }
    .navbar-menu-toggler-md{
      display: none;
    }
  }

@media screen (min-width: 768px), screen and (max-width: 991px){
   .system-header{
      width: 100%;
    }
    .header-navbar{
      width: 100%;
    }
   .margin-in-full{
      display: none;
   }
   .header-navbar-nav{
      width: 20%;
    }
    .navbar-menu-toggler-md{
      width: 6%;
      text-align: center;
      display: block;
    }
 }

/*-------------- Small Screen for Mobile Phones --------------*/
 @media (max-width: 767px){
    .system-header{
      width: 100%;
    }
    .header-navbar{
      width: 100%;
    }
    .margin-in-full{
      display: none;
   }
   .navbar-menu-toggler-md{
      width: 15%
    }
    .header-navbar-nav{
      text-align: center;
      width: 40%;
    }
  }
</style>
