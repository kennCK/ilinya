 <template>
  <div>
      <!--- 

              Header Brand 

      -->
    <div class="system-header">
      <a class="navbar-brand" href="#">
        <img src="../../assets/img/godigit-white.png" height="40" width="40">
        <label class="navbar-brand">Go<b>Digit</b></label>
      </a>
    </div>
    <nav class="header-navbar">
      <span class="navbar-menu-toggler-md" data-toggle="collapse" data-target="#godigitSidebar" aria-controls="godigitSidebar" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </span>
      <!--- 

              Header icons 

      -->
      <span class="margin-in-full"></span>
      <span class="nav-item dropdown">
        <span data-toggle="dropdown" id="#myBranches" v-on:click="getBranches()">
          <i class="fa fa-th-large"></i>
          <span class="label">{{branches.length}}</span>
        </span>
        <span class="dropdown-menu" id="myBranches">
          <span class="dropdown-header">Work In</span>
          <span class="dropdown-item" v-for="(item,index) in branches" v-on:click="loadBranch(index)">
              <img src="../../assets/img/godigit.png" height="20" width="20">
              {{item.company_branch.name}}
          </span>
        </span>
      </span>
      <span class="nav-item dropdown">
        <span data-toggle="dropdown" id="#messages">
          <i class="fa fa-envelope-o"></i>
          <span class="label">4</span>
        </span>
        <span class="dropdown-menu" id="messages">
          <span class="dropdown-item"></span>
        </span>
      </span>
      <span class="nav-item dropdown">
        <span data-toggle="dropdown" id="#notifications">
          <i class="fa fa-bell-o"></i>
          <span class="label">4</span>
        </span>
        <span class="dropdown-menu" id="notifications">
          <span class="dropdown-item"></span>
        </span>
      </span>

      <!--- 

              Header Profile 

      -->
      <div class="header-navbar-nav" data-toggle="modal" data-target="#logoutModal">
         <span>
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <label>Hi {{user.username}}!</label>
         </span>  
      </div>
      <!--- 

              Header Menu Toggler 

      -->
    </nav>
   <!--- 

              Header Modal

      -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Hi {{user.username}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Are you sure you want to logout?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger-hallow" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i> No</button>
            <button type="button" class="btn btn-primary-hallow" v-on:click="logOut()" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Yes</button>
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
  created(){
    this.getBranches()
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
      ROUTER.push('/')
    },
    loadBranch(index){
      AUTH.setCompany(this.branches[index].company_branch.company_id, this.branches[index].company_branch_id)
      ROUTER.push('/')
    },
    getBranches(){
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
        this.branches = response.data
      })
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
      float: left;
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

/*---------------------------------------------
 
 
        HEADER NAVBAR MENU


-----------------------------------------------*/

.nav-item{
  width: 5%;
  height: 50px;
  text-align: center;
  float: left;
  color: #fff;
  display: inline;
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
  border-color: solid 1px #ff0000;
}

.nav-item:hover{
  background: #006600;
  cursor: pointer;
}

.dropdown-menu{
  min-height: 250px;
  overflow: hidden;
  width: 250px;
  margin-top: -1px;
  border-radius: 0px !important;
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
    .nav-item{
      width: 5%
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
    .nav-item{
      width: 6%
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
    .nav-item,.navbar-menu-toggler-md{
      width: 15%
    }
    .header-navbar-nav{
      text-align: center;
      width: 40%;
    }
  }
</style>
