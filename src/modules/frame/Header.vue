 <template>
  <div>
    
    <div class="system-header">
      <a class="navbar-brand" v-on:click="redirect('dashboard')">
        <label class="navbar-brand"><b>i</b>Linya</label>
      </a>
    </div>


    <nav class="header-navbar">
      <span class="navbar-menu-toggler-md" data-toggle="collapse" data-target="#iLinyaSidebar" aria-controls="iLinyaSidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </span>


      <div class="dropdown">
        <div class="header-navbar-nav" data-toggle="dropdown" id="account" aria-haspopup="true" aria-expanded="false">
           <span>
              <i class="fa fa-user-circle" aria-hidden="true"></i>
              <label>Hi {{user.username}}!</label>
           </span>
           <span class="dropdown-menu" aria-labelledby="account" id="account-holder">
            <span class="dropdown-item-profile">
              <span class="account-picture text-center">
                <img v-bind:src="'file/account_profiles/' + profilePicture" style="margin-top:20px;" class="rounded-circle" height="125" width="125" v-if="profilePicture !== ''">
                <i class="fa fa-user-circle-o" style="font-size:100px;color:#eee;margin-top:20px" v-else></i>
              </span>
              <span class="account-info text-center">{{user.username}}</span>
            </span>
            <span class="dropdown-item-button text-center">
              <button class="btn btn-default pull-left" v-on:click="accountProfile()" id="account-profile-btn">Account Profile</button>
              <button class="btn btn-danger pull-right" v-on:click="logOut()" id="logout-btn">Logout</button>
            </span>
          </span>
        </div>
      </div>
    </nav>
  </div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  mounted(){
    this.getProfilePicture()
  },
  created(){
    this.getProfilePicture()
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
      ],
      profilePicture: ''
    }
  },
  methods: {
    logOut(){
      AUTH.deaunthenticate()
      ROUTER.push('/')
      ROUTER.go('/')
    },
    accountProfile(){
      ROUTER.push('my_profile')
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    getProfilePicture(){
      let parameter = {
        'condition': [{
          'column': 'account_id',
          'clause': '=',
          'value': this.user.userID
        }]
      }
      this.APIRequest('account_profile_picture/retrieve', parameter).then(response => {
        if(response.data.length >= 1){
          this.profilePicture = response.data[0].source
        }else{
          this.profilePicture = ''
        }
      })
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
  margin: 0 !important;
  padding: 0 !important;
  right: 0;
  border: 0 !important;
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
  background: #009900;
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
  border-bottom:solid 1px #eee;
  border-left:solid 1px #eee;
  border-right:solid 1px #eee;
  float: left;
  background: #fff;
}
.dropdown-item-button button{
  height: 40px;
  width: 100px;
  margin: 5px;
}

#account-profile-btn:hover{
  background: #009900;
  color: #fff;
  cursor: pointer;
}

#logout-btn:hover{
  background: #ff0000;
  cursor: pointer;
}




/*---------------------------------------------------------

                  RESPONSIVE HANDLER

-----------------------------------------------------------*/
/*-------------- Medium and Large Screens for Tablets and Desktop --------------*/
 @media screen (min-width: 1200px){
    .system-header{
      width: 23%;
    }
    .login-header-navbar{
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
