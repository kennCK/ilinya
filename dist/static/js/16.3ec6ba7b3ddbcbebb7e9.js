webpackJsonp([16],{254:function(n,r,e){e(446);var t=e(167)(e(371),e(479),null,null);n.exports=t.exports},371:function(n,r,e){"use strict";Object.defineProperty(r,"__esModule",{value:!0});var t=e(8),A=e(16),a=e(14),o=e(1),i=e.n(o),d=e(449),c=e.n(d);i.a.use(c.a,{AppId:"r3tkqvex"}),r.default={mounted:function(){this.getProfilePicture(),this.$intercom.boot({user_id:this.user.userID,name:this.user.username}),this.$intercom.show()},created:function(){},data:function(){return{user:A.a.user,tokenData:A.a.tokenData,branches:[],popover:["myBranches","myMessages","myNotifications"],popoverValue:[["Company Branches"],["Messages"],["Notifications"]],profilePicture:"",config:a.default,profileDirectory:a.default.BACKEND_URL+"/file/account_profiles/"}},methods:{logOut:function(){A.a.deaunthenticate(),t.a.push("/"),t.a.go("/")},accountProfile:function(){t.a.push("my_profile")},redirect:function(n){t.a.push(n)},getProfilePicture:function(){var n=this,r={condition:[{column:"account_id",clause:"=",value:this.user.userID}]};this.APIRequest("account_profile_picture/retrieve",r).then(function(r){r.data.length>=1?n.profilePicture=r.data[0].source:n.profilePicture=""})}}}},419:function(n,r,e){r=n.exports=e(246)(),r.push([n.i,"body{font-size:13px;font-family:Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:400}.primary-color{color:#060}.form-control{height:35px}.btn,.form-control,.table{font-size:12px}.btn:hover{cursor:pointer}.btn-primary{background:#060;border-color:#060}.btn-primary:hover{background:#090;border-color:#090}.btn-danger{background:#a00}.btn-danger:hover{background:red;border-color:red}.btn-primary-hallow{border-color:#060;color:#060;background:#fff}.btn-primary-hallow:hover{color:#090;border-color:#090}.btn-danger-hallow{border-color:#a00;background:#fff;color:#a00}.btn-danger-hallow:hover{color:red;border-color:red}.system-header{float:left;height:50px;font-size:24px;width:18%;background:#060;text-align:center}.header-navbar{background:#090;height:50px;float:left;width:82%}.system-header .navbar-brand{color:#fff}.margin-in-full{width:65%;float:left;height:50px}.header-navbar-icons{height:50px;float:left;text-align:center;font-size:16px;width:5%;color:#fff;padding:10px 0 15px}.header-navbar-icons:hover{cursor:pointer;background:#060}.header-navbar-nav{height:50px;float:right;color:#fff;width:20%}.header-navbar-nav label{font-size:13px;font-weight:500;vertical-align:middle;padding-left:10px}.header-navbar-nav i{font-size:24px;padding:10px 0 0 5%}.header-navbar-nav:hover{cursor:pointer;background:#060}.navbar-menu-toggler-md{height:50px;float:left;text-align:center;font-size:16px;color:#fff;padding:10px 0 15px;display:none}.navbar-menu-toggler-md:hover{cursor:pointer;background:#060}.dropdown-menu{width:300px;border-radius:0!important;margin:0!important;padding:0!important;right:0;border:0!important}.dropdown-item{width:100%;height:40px;float:left;background:#fff}.dropdown-header{padding:5px 0 10px;width:100%;text-align:center;border-bottom:1px solid #ccc}.dropdown-item-profile{height:200px;width:100%;float:left;top:0;background:#090}.account-picture{height:150px;width:100%;float:left}.account-info{height:50px;width:100%;float:left;color:#fff}.dropdown-item-button{height:50px;width:100%;border-bottom:1px solid #eee;border-left:1px solid #eee;border-right:1px solid #eee;float:left;background:#fff}.dropdown-item-button button{height:40px;width:100px;margin:5px}#account-profile-btn:hover{background:#090;color:#fff;cursor:pointer}#logout-btn:hover{background:red;cursor:pointer}@media screen (min-width:1200px){.system-header{width:23%}.login-header-navbar{width:77%}.header-margin{width:85%}.nav-item{width:15%}}@media screen (min-width:992px),screen and (max-width:1199px){.system-header{width:23%}.header-navbar{width:77%}.header-navbar-nav{width:15%}.navbar-menu-toggler-md{display:none}}@media screen (min-width:768px),screen and (max-width:991px){.header-navbar,.system-header{width:100%}.margin-in-full{display:none}.header-navbar-nav{width:20%}.navbar-menu-toggler-md{width:6%;text-align:center;display:block}}@media (max-width:767px){.header-navbar,.system-header{width:100%}.margin-in-full{display:none}.navbar-menu-toggler-md{width:15%}.header-navbar-nav{text-align:center;width:40%}}","",{version:3,sources:["C:/xampp/htdocs/ilinya/src/modules/frame/Header.vue"],names:[],mappings:"AACA,KACE,eAAgB,AAChB,sEAA2E,AAC3E,eAAiB,CAClB,AAGD,eACE,UAAe,CAChB,AAMD,cACE,WAAa,CAEd,AAaD,0BACE,cAAgB,CACjB,AACD,WACE,cAAgB,CACjB,AACD,aACE,gBAAoB,AACpB,iBAAsB,CACvB,AACD,mBACE,gBAAoB,AACpB,iBAAsB,CACvB,AACD,YACE,eAAoB,CACrB,AACD,kBACE,eAAoB,AACpB,gBAAsB,CACvB,AAMD,oBACE,kBAAsB,AACtB,WAAe,AACf,eAAiB,CAClB,AACD,0BACE,WAAe,AACf,iBAAsB,CACvB,AACD,mBACE,kBAAsB,AACtB,gBAAiB,AACjB,UAAe,CAChB,AACD,yBACE,UAAe,AACf,gBAAsB,CACvB,AACD,eACI,WAAY,AACZ,YAAa,AACb,eAAgB,AAChB,UAAW,AACX,gBAAoB,AACpB,iBAAmB,CACtB,AACD,eACI,gBAAoB,AACpB,YAAa,AACb,WAAY,AACZ,SAAW,CACd,AACD,6BACI,UAAY,CACf,AAQD,gBACI,UAAW,AACX,WAAY,AACZ,WAAa,CAChB,AACD,qBACI,YAAa,AACb,WAAY,AACZ,kBAAmB,AACnB,eAAgB,AAChB,SAAU,AACV,WAAY,AACZ,mBAAuB,CAC1B,AACD,2BACI,eAAgB,AAChB,eAAoB,CACvB,AASD,mBACM,YAAa,AACb,YAAa,AACb,WAAY,AACZ,SAAW,CAChB,AACD,yBACI,eAAgB,AAChB,gBAAiB,AACjB,sBAAuB,AACvB,iBAAmB,CACtB,AACD,qBACI,eAAgB,AACf,mBAAqB,CACzB,AACD,yBACI,eAAgB,AAChB,eAAoB,CACvB,AAQD,wBACI,YAAa,AACb,WAAY,AACZ,kBAAmB,AACnB,eAAgB,AAChB,WAAY,AACZ,oBAAuB,AACvB,YAAc,CACjB,AACD,8BACI,eAAgB,AAChB,eAAoB,CACvB,AACD,eACE,YAAa,AACb,0BAA8B,AAC9B,mBAAqB,AACrB,oBAAsB,AACtB,QAAS,AACT,kBAAqB,CACtB,AACD,eACE,WAAY,AACZ,YAAa,AACb,WAAY,AACZ,eAAiB,CAClB,AACD,iBACE,mBAAsB,AACtB,WAAY,AACZ,kBAAmB,AACnB,4BAA8B,CAC/B,AACD,uBACE,aAAc,AACd,WAAY,AACZ,WAAY,AACZ,MAAO,AACP,eAAoB,CACrB,AACD,iBACE,aAAc,AACd,WAAY,AACZ,UAAY,CACb,AACD,cACE,YAAa,AACb,WAAY,AACZ,WAAY,AACZ,UAAY,CACb,AACD,sBACE,YAAa,AACb,WAAY,AACZ,6BAA6B,AAC7B,2BAA2B,AAC3B,4BAA4B,AAC5B,WAAY,AACZ,eAAiB,CAClB,AACD,6BACE,YAAa,AACb,YAAa,AACb,UAAY,CACb,AACD,2BACE,gBAAoB,AACpB,WAAY,AACZ,cAAgB,CACjB,AACD,kBACE,eAAoB,AACpB,cAAgB,CACjB,AAWD,iCACA,eACM,SAAW,CAChB,AACD,qBACM,SAAW,CAChB,AACD,eACM,SAAW,CAChB,AACD,UACM,SAAW,CAChB,CACA,AACD,8DACA,eACM,SAAW,CAChB,AACD,eACM,SAAW,CAChB,AACD,mBACM,SAAW,CAChB,AACD,wBACM,YAAc,CACnB,CACA,AACD,6DAIA,8BACM,UAAY,CACjB,AACD,gBACM,YAAc,CACnB,AACD,mBACM,SAAW,CAChB,AACD,wBACM,SAAU,AACV,kBAAmB,AACnB,aAAe,CACpB,CACA,AAGD,yBAIA,8BACM,UAAY,CACjB,AACD,gBACM,YAAc,CACnB,AACD,wBACM,SAAU,CACf,AACD,mBACM,kBAAmB,AACnB,SAAW,CAChB,CACA",file:"Header.vue",sourcesContent:["\nbody{\r\n  font-size: 13px;\r\n  font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;\r\n  font-weight: 400;\n}\r\n\r\n/*      Colors           */\n.primary-color{\r\n  color: #006600;\n}\r\n/*------------------------------------\r\n\r\n          FORMS\r\n\r\n--------------------------------------*/\n.form-control{\r\n  height: 35px;\r\n  font-size: 12px;\n}\r\n\r\n/*------------------------------------\r\n\r\n          TABLES\r\n\r\n--------------------------------------*/\n.table{\r\n  font-size: 12px;\n}\r\n  /*\r\n        CUSTOMIZE BUTTON\r\n*/\n.btn{\r\n  font-size: 12px;\n}\n.btn:hover{\r\n  cursor: pointer;\n}\n.btn-primary{\r\n  background: #006600;\r\n  border-color: #006600;\n}\n.btn-primary:hover{\r\n  background: #009900;\r\n  border-color: #009900;\n}\n.btn-danger{\r\n  background: #aa0000;\n}\n.btn-danger:hover{\r\n  background: #ff0000;\r\n  border-color: #ff0000;\n}\r\n\r\n/*\r\n      HALLOW\r\n\r\n*/\n.btn-primary-hallow{\r\n  border-color: #006600;\r\n  color: #006600;\r\n  background: #fff;\n}\n.btn-primary-hallow:hover{\r\n  color: #009900;\r\n  border-color: #009900;\n}\n.btn-danger-hallow{\r\n  border-color: #aa0000;\r\n  background: #fff;\r\n  color: #aa0000;\n}\n.btn-danger-hallow:hover{\r\n  color: #ff0000;\r\n  border-color: #ff0000;\n}\n.system-header{\r\n    float: left;\r\n    height: 50px;\r\n    font-size: 24px;\r\n    width: 18%;\r\n    background: #006600;\r\n    text-align: center;\n}\n.header-navbar{\r\n    background: #009900;\r\n    height: 50px;\r\n    float: left;\r\n    width: 82%;\n}/*-- navbar --*/\n.system-header .navbar-brand{\r\n    color: #fff;\n}\r\n\r\n/*---------------------------------------------\r\n  HEADER ICONS\r\n      Contents:\r\n          *Branch Switcher\r\n          *Messages\r\n-----------------------------------------------*/\n.margin-in-full{\r\n    width: 65%;\r\n    float: left;\r\n    height: 50px;\n}\n.header-navbar-icons{\r\n    height: 50px;\r\n    float: left;\r\n    text-align: center;\r\n    font-size: 16px;\r\n    width: 5%;\r\n    color: #fff;\r\n    padding: 10px 0 15px 0;\n}\n.header-navbar-icons:hover{\r\n    cursor: pointer;\r\n    background: #006600;\n}\r\n\r\n/*---------------------------------------------\r\n\r\n\r\n        HEADER ACCOUNT PROFILE\r\n\r\n\r\n-----------------------------------------------*/\n.header-navbar-nav{\r\n      height: 50px;\r\n      float: right;\r\n      color: #fff;\r\n      width: 20%;\n}\n.header-navbar-nav label{\r\n    font-size: 13px;\r\n    font-weight: 500;\r\n    vertical-align: middle;\r\n    padding-left: 10px;\n}\n.header-navbar-nav i{\r\n    font-size: 24px;\r\n     padding: 10px 0 0 5%;\n}\n.header-navbar-nav:hover{\r\n    cursor: pointer;\r\n    background: #006600;\n}\r\n/*---------------------------------------------\r\n\r\n\r\n        HEADER TOGGLER MENU\r\n\r\n\r\n-----------------------------------------------*/\n.navbar-menu-toggler-md{\r\n    height: 50px;\r\n    float: left;\r\n    text-align: center;\r\n    font-size: 16px;\r\n    color: #fff;\r\n    padding: 10px 0 15px 0;\r\n    display: none;\n}\n.navbar-menu-toggler-md:hover{\r\n    cursor: pointer;\r\n    background: #006600;\n}\n.dropdown-menu{\r\n  width: 300px;\r\n  border-radius: 0px !important;\r\n  margin: 0 !important;\r\n  padding: 0 !important;\r\n  right: 0;\r\n  border: 0 !important;\n}\n.dropdown-item{\r\n  width: 100%;\r\n  height: 40px;\r\n  float: left;\r\n  background: #fff;\n}\n.dropdown-header{\r\n  padding: 5px 0 10px 0;\r\n  width: 100%;\r\n  text-align: center;\r\n  border-bottom: solid 1px #ccc;\n}\n.dropdown-item-profile{\r\n  height: 200px;\r\n  width: 100%;\r\n  float: left;\r\n  top: 0;\r\n  background: #009900;\n}\n.account-picture{\r\n  height: 150px;\r\n  width: 100%;\r\n  float: left;\n}\n.account-info{\r\n  height: 50px;\r\n  width: 100%;\r\n  float: left;\r\n  color: #fff;\n}\n.dropdown-item-button{\r\n  height: 50px;\r\n  width: 100%;\r\n  border-bottom:solid 1px #eee;\r\n  border-left:solid 1px #eee;\r\n  border-right:solid 1px #eee;\r\n  float: left;\r\n  background: #fff;\n}\n.dropdown-item-button button{\r\n  height: 40px;\r\n  width: 100px;\r\n  margin: 5px;\n}\n#account-profile-btn:hover{\r\n  background: #009900;\r\n  color: #fff;\r\n  cursor: pointer;\n}\n#logout-btn:hover{\r\n  background: #ff0000;\r\n  cursor: pointer;\n}\r\n\r\n\r\n\r\n\r\n/*---------------------------------------------------------\r\n\r\n                  RESPONSIVE HANDLER\r\n\r\n-----------------------------------------------------------*/\r\n/*-------------- Medium and Large Screens for Tablets and Desktop --------------*/\n@media screen (min-width: 1200px){\n.system-header{\r\n      width: 23%;\n}\n.login-header-navbar{\r\n      width: 77%;\n}\n.header-margin{\r\n      width: 85%;\n}\n.nav-item{\r\n      width: 15%;\n}\n}\n@media screen (min-width: 992px), screen and (max-width: 1199px){\n.system-header{\r\n      width: 23%;\n}\n.header-navbar{\r\n      width: 77%;\n}\n.header-navbar-nav{\r\n      width: 15%;\n}\n.navbar-menu-toggler-md{\r\n      display: none;\n}\n}\n@media screen (min-width: 768px), screen and (max-width: 991px){\n.system-header{\r\n      width: 100%;\n}\n.header-navbar{\r\n      width: 100%;\n}\n.margin-in-full{\r\n      display: none;\n}\n.header-navbar-nav{\r\n      width: 20%;\n}\n.navbar-menu-toggler-md{\r\n      width: 6%;\r\n      text-align: center;\r\n      display: block;\n}\n}\r\n\r\n/*-------------- Small Screen for Mobile Phones --------------*/\n@media (max-width: 767px){\n.system-header{\r\n      width: 100%;\n}\n.header-navbar{\r\n      width: 100%;\n}\n.margin-in-full{\r\n      display: none;\n}\n.navbar-menu-toggler-md{\r\n      width: 15%\n}\n.header-navbar-nav{\r\n      text-align: center;\r\n      width: 40%;\n}\n}\r\n"],sourceRoot:""}])},446:function(n,r,e){var t=e(419);"string"==typeof t&&(t=[[n.i,t,""]]),t.locals&&(n.exports=t.locals);e(247)("4d3e9373",t,!0)},449:function(n,r,e){!function(r,e){n.exports=e()}(0,function(){"use strict";var n,r,e=function(n,r){return n&&r()},t=function(n,r){return e(!n,function(){throw new Error("[vue-intercom] "+r)})},A=function(n,r){return r instanceof n||null!==r&&void 0!==r&&r.constructor===n},a=function(n,r){var e={};return r.forEach(function(r){return e[r]={get:function(){return n[r]}}}),e},o=function(r){var o=r.appId;t(n,"call Vue.use(VueIntercom) before creating an instance");var i=new n({data:function(){return{ready:!1,visible:!1,unreadCount:0}}}),d=function(){for(var n=[],r=arguments.length;r--;)n[r]=arguments[r];window.Intercom.apply(window,n)},c={_vm:i};return Object.defineProperties(c,a(i,["ready","visible","unreadCount"])),c._call=d,c._init=function(){i.ready=!0,d("onHide",function(){return i.visible=!1}),d("onShow",function(){return i.visible=!0}),d("onUnreadCountChange",function(n){return i.unreadCount=n})},c.boot=function(n){void 0===n&&(n={app_id:o}),e(!n.app_id,function(){return n.app_id=o}),d("boot",n)},c.shutdown=function(){return d("shutdown")},c.update=function(){for(var n=[],r=arguments.length;r--;)n[r]=arguments[r];return d.apply(void 0,["update"].concat(n))},c.show=function(){return d("show")},c.hide=function(){return d("hide")},c.showMessages=function(){return d("showMessages")},c.showNewMessage=function(n){return d.apply(void 0,["showNewMessage"].concat(A(String,n)?[n]:[]))},c.trackEvent=function(n){for(var r=[],e=arguments.length-1;e-- >0;)r[e]=arguments[e+1];return d.apply(void 0,["trackEvent"].concat([n].concat(r)))},c.getVisitorId=function(){return d("getVisitorId")},c};return o.install=function(A,a){var i=a.appId;t(!n,"already installed."),n=A;var d=o({appId:i});n.mixin({created:function(){var n=this;e(!r,function(){if("function"==typeof window.Intercom)n.$intercom._init(),n.$intercom._call("reattach_activator"),n.$intercom.update();else{var e=function(){for(var n=[],r=arguments.length;r--;)n[r]=arguments[r];return e.c(n)};e.q=[],e.c=function(n){return e.q.push(n)},window.Intercom=e,o.loadScript(i,function(){return n.$intercom._init()})}r=!0})}}),Object.defineProperty(n.prototype,"$intercom",{get:function(){return d}})},o.loadScript=function(n,r){var e=document.createElement("script");e.async=!0,e.src="https://widget.intercom.io/widget/"+n;var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t),e.onload=r},o})},479:function(n,r){n.exports={render:function(){var n=this,r=n.$createElement,e=n._self._c||r;return e("div",[e("div",{staticClass:"system-header"},[e("a",{staticClass:"navbar-brand",on:{click:function(r){n.redirect("admin_home")}}},[n._m(0)])]),n._v(" "),e("nav",{staticClass:"header-navbar"},[n._m(1),n._v(" "),e("div",{staticClass:"dropdown"},[e("div",{staticClass:"header-navbar-nav",attrs:{"data-toggle":"dropdown",id:"account","aria-haspopup":"true","aria-expanded":"false"}},[e("span",[e("i",{staticClass:"fa fa-user-circle",attrs:{"aria-hidden":"true"}}),n._v(" "),e("label",[n._v("Hi "+n._s(n.user.username)+"!")])]),n._v(" "),e("span",{staticClass:"dropdown-menu",attrs:{"aria-labelledby":"account",id:"account-holder"}},[e("span",{staticClass:"dropdown-item-profile"},[e("span",{staticClass:"account-picture text-center"},[""!==n.profilePicture?e("img",{staticClass:"rounded-circle",staticStyle:{"margin-top":"20px"},attrs:{src:n.profileDirectory+n.profilePicture,height:"125",width:"125"}}):e("i",{staticClass:"fa fa-user-circle-o",staticStyle:{"font-size":"100px",color:"#eee","margin-top":"20px"}})]),n._v(" "),e("span",{staticClass:"account-info text-center"},[n._v(n._s(n.user.username))])]),n._v(" "),e("span",{staticClass:"dropdown-item-button text-center"},[e("button",{staticClass:"btn btn-default pull-left",attrs:{id:"account-profile-btn"},on:{click:function(r){n.accountProfile()}}},[n._v("Account Profile")]),n._v(" "),e("button",{staticClass:"btn btn-danger pull-right",attrs:{id:"logout-btn"},on:{click:function(r){n.logOut()}}},[n._v("Logout")])])])])])])])},staticRenderFns:[function(){var n=this,r=n.$createElement,e=n._self._c||r;return e("label",{staticClass:"navbar-brand"},[e("b",[n._v("i")]),n._v("Linya")])},function(){var n=this,r=n.$createElement,e=n._self._c||r;return e("span",{staticClass:"navbar-menu-toggler-md",attrs:{"data-toggle":"collapse","data-target":"#iLinyaSidebar","aria-controls":"iLinyaSidebar","aria-expanded":"false","aria-label":"Toggle navigation"}},[e("i",{staticClass:"fa fa-bars",attrs:{"aria-hidden":"true"}})])}]}}});
//# sourceMappingURL=16.3ec6ba7b3ddbcbebb7e9.js.map