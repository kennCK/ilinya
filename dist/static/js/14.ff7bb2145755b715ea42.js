webpackJsonp([14],{260:function(n,e,r){r(443);var t=r(167)(r(377),r(475),null,null);n.exports=t.exports},377:function(n,e,r){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var t=r(8),a=r(16);e.default={mounted:function(){},data:function(){return{username:"",password:"",errorMessage:"",user:a.a.user,tokenData:a.a.tokenData,branchesEmployees:[],branches:[]}},methods:{logIn:function(){var n=this;a.a.authenticate(this.username,this.password,function(e){n.setCompanyAuth()},function(e,r){n.errorMessage=401===r?"Your Username and password didnot matched.":"Cannot log in? Contact us through email: support@ilinya.com"})},redirect:function(n){t.a.push(n)},setCompanyAuth:function(){var n=this,e={condition:[{column:"account_id",clause:"=",value:this.user.userID}]};this.APIRequest("company_branch_employee/retrieve",e).then(function(e){if(n.branchesEmployees=e.data,n.branchesEmployees.length>1)t.a.push("select");else{var r={condition:[{column:"id",clause:"=",value:n.branchesEmployees[0].company_branch_id}]};n.APIRequest("company_branch/retrieve",r).then(function(e){n.branches=e.data,1===n.branches.length&&(a.a.setCompany(n.branches[0].company_id,n.branchesEmployees[0].company_branch_id),t.a.push("admin_home"))})}})}}}},416:function(n,e,r){e=n.exports=r(246)(),e.push([n.i,'.app-img{float:left;width:30%;text-align:right}.app-title{float:left;width:70%;text-align:left}.app-img img{height:50px;width:50px}.app-title label{vertical-align:middle;font-size:30px;left:0}.login-header{height:40px;color:#060;width:100%;float:left}.login-message-holder{min-height:30px;font-size:12px;float:left;overflow:hidden}.login-spacer{margin-bottom:10px}.forgot-password a{color:#060!important}.forgot-password a:hover{cursor:pointer!important;text-decoration:underline!important;color:#090!important}.btn-login,.form-control-login{height:45px}.separator>*{display:inline-block;vertical-align:middle}.separator{text-align:center;border:0;white-space:nowrap;display:block;overflow:hidden;padding:0;margin:0}.separator:after,.separator:before{content:"";height:1px;width:50%;background-color:#ccc;margin:0 5px;display:inline-block;vertical-align:middle}.separator:before{margin-left:-100%}.separator:after{margin-right:-100%}@media (min-width:1200px){.login-wrapper{width:80%;margin:0 5% 0 15%}}@media screen (min-width:992px),screen and (max-width:1199px){.login-wrapper{width:80%;margin:0 5% 0 15%}}@media screen (min-width:768px),screen and (max-width:991px){.login-wrapper{width:98%;margin:0 2% 0 0}}@media (max-width:767px){.hide-this{display:none}.login-wrapper{width:80%;margin:0 10%}}',"",{version:3,sources:["C:/xampp/htdocs/ilinya/src/modules/home/LogIn.vue"],names:[],mappings:"AAsHA,SACE,WAAY,AACZ,UAAW,AACX,gBAAkB,CACnB,AACD,WACE,WAAY,AACZ,UAAW,AACX,eAAiB,CAClB,AACD,aACE,YAAa,AACb,UAAY,CACb,AACD,iBACE,sBAAuB,AACvB,eAAgB,AAChB,MAAQ,CACT,AACD,cACE,YAAa,AACb,WAAe,AACf,WAAY,AACZ,UAAY,CACb,AACD,sBACE,gBAAiB,AACjB,eAAgB,AAChB,WAAY,AACZ,eAAiB,CAClB,AACD,cACE,kBAAoB,CACrB,AACD,mBACE,oBAA0B,CAC3B,AACD,yBACE,yBAA2B,AAC3B,oCAAsC,AACtC,oBAA0B,CAC3B,AAiBD,+BACE,WAAa,CACd,AAGD,aACE,qBAAsB,AACtB,qBAAuB,CACxB,AACD,WACI,kBAAmB,AACnB,SAAU,AACV,mBAAoB,AACpB,cAAe,AACf,gBAAiB,AACjB,UAAW,AACX,QAAU,CACb,AACD,mCACI,WAAY,AACZ,WAAY,AACZ,UAAW,AACX,sBAAuB,AACvB,aAAoB,AACpB,qBAAsB,AACtB,qBAAuB,CAC1B,AACD,kBACI,iBAAmB,CACtB,AACD,iBACI,kBAAoB,CACvB,AASD,0BACA,eACI,UAAW,AACX,iBAAmB,CACtB,CACA,AAID,8DACA,eACI,UAAW,AACX,iBAAmB,CACtB,CACA,AAGD,6DACA,eACI,UAAW,AACX,eAAkB,CACrB,CACA,AAGD,yBACA,WACI,YAAc,CACjB,AACD,eACI,UAAW,AACX,YAAoB,CACvB,CACA",file:"LogIn.vue",sourcesContent:['\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\r\n/*\r\n  Designs Rules\r\n  1. Top to Bottom\r\n  2. Left to Right\r\n  3. Common\r\n  4. Screen Changes\r\n*/\n.app-img{\r\n  float: left;\r\n  width: 30%;\r\n  text-align: right;\n}\n.app-title{\r\n  float: left;\r\n  width: 70%;\r\n  text-align: left;\n}\n.app-img img{\r\n  height: 50px;\r\n  width: 50px;\n}\n.app-title label{\r\n  vertical-align: middle;\r\n  font-size: 30px;\r\n  left: 0;\n}\n.login-header{\r\n  height: 40px;\r\n  color: #006600;\r\n  width: 100%;\r\n  float: left;\n}/*-- login-header --*/\n.login-message-holder{\r\n  min-height: 30px;\r\n  font-size: 12px;\r\n  float: left;\r\n  overflow: hidden;\n}\n.login-spacer{\r\n  margin-bottom: 10px;\n}/*-- login-spacer --*/\n.forgot-password a{\r\n  color: #006600 !important;\n}\n.forgot-password a:hover{\r\n  cursor: pointer !important;\r\n  text-decoration: underline !important;\r\n  color: #009900 !important;\n}\r\n\r\n/*----------------------------------------\r\n\r\n            Forms\r\n\r\n------------------------------------------*/\n.form-control-login{\r\n  height: 45px;\n}\r\n\r\n\r\n/*----------------------------------------\r\n\r\n            Buttons\r\n\r\n------------------------------------------*/\n.btn-login{\r\n  height: 45px;\n}/*-- form-control --*/\r\n\r\n/*    Line with text on top  */\n.separator>*{\r\n  display: inline-block;\r\n  vertical-align: middle;\n}\n.separator {\r\n    text-align: center;\r\n    border: 0;\r\n    white-space: nowrap;\r\n    display: block;\r\n    overflow: hidden;\r\n    padding: 0;\r\n    margin: 0;\n}\n.separator:before, .separator:after {\r\n    content: "";\r\n    height: 1px;\r\n    width: 50%;\r\n    background-color: #ccc;\r\n    margin: 0 5px 0 5px;\r\n    display: inline-block;\r\n    vertical-align: middle;\n}\n.separator:before {\r\n    margin-left: -100%;\n}\n.separator:after {\r\n    margin-right: -100%;\n}\r\n\r\n/*---------------------------------------------------------\r\n\r\n                  RESPONSIVE HANDLER\r\n\r\n-----------------------------------------------------------*/\r\n\r\n/*-------------- Large Screens for Desktop --------------*/\n@media (min-width: 1200px){\n.login-wrapper{\r\n    width: 80%;\r\n    margin: 0 5% 0 15%;\n}\n}\r\n\r\n\r\n/*-------------- Medium Screen for Tablets  --------------*/\n@media screen (min-width: 992px), screen and (max-width: 1199px){\n.login-wrapper{\r\n    width: 80%;\r\n    margin: 0 5% 0 15%;\n}\n}\r\n\r\n/*-------------- Small Screen for Mobile Phones  --------------*/\n@media screen (min-width: 768px), screen and (max-width: 991px){\n.login-wrapper{\r\n    width: 98%;\r\n    margin: 0 2% 0 0%;\n}\n}\r\n\r\n/*-------------- Extra Small Screen for Mobile Phones --------------*/\n@media (max-width: 767px){\n.hide-this{\r\n    display: none;\n}\n.login-wrapper{\r\n    width: 80%;\r\n    margin: 0 10% 0 10%;\n}\n}\r\n'],sourceRoot:""}])},443:function(n,e,r){var t=r(416);"string"==typeof t&&(t=[[n.i,t,""]]),t.locals&&(n.exports=t.locals);r(247)("5117bde1",t,!0)},447:function(n,e,r){n.exports=r.p+"static/img/Top.cbcfc8c.png"},475:function(n,e,r){n.exports={render:function(){var n=this,e=n.$createElement,r=n._self._c||e;return n.tokenData.verifyingToken||n.tokenData.token?n._e():r("div",{staticClass:"container-fluid custom-container"},[r("div",{staticClass:"row"},[n._m(0),n._v(" "),r("div",{staticClass:"col-sm-12 col-md-4"},[r("div",{staticClass:"login-wrapper"},[n._m(1),n._v(" "),""!=n.errorMessage?r("div",{staticClass:"login-message-holder login-spacer"},[r("span",{staticClass:"text-danger"},[r("b",[n._v("Oops!")]),n._v(" "+n._s(n.errorMessage))])]):n._e(),n._v(" "),r("div",[r("div",{staticClass:"input-group login-spacer"},[n._m(2),n._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:n.username,expression:"username"}],staticClass:"form-control form-control-login",attrs:{type:"text",placeholder:"Username or Email","aria-describedby":"addon-1"},domProps:{value:n.username},on:{input:function(e){e.target.composing||(n.username=e.target.value)}}})]),n._v(" "),r("div",{staticClass:"input-group login-spacer"},[n._m(3),n._v(" "),r("input",{directives:[{name:"model",rawName:"v-model",value:n.password,expression:"password"}],staticClass:"form-control form-control-login",attrs:{type:"password",placeholder:"********","aria-describedby":"addon-2"},domProps:{value:n.password},on:{input:function(e){e.target.composing||(n.password=e.target.value)}}})]),n._v(" "),r("button",{staticClass:"btn btn-primary btn-block btn-login login-spacer",on:{click:function(e){n.logIn()}}},[n._v("Login")]),n._v(" "),n._m(4),n._v(" "),r("div",{staticClass:"container-fluid text-center forgot-password"},[r("a",{staticClass:"btn-link",on:{click:function(e){n.redirect("recover_account")}}},[n._v("Forgot Password?")])]),n._v(" "),r("br"),n._v(" "),r("div",{staticClass:"container-fluid separator"},[n._v("\n              or\n          ")]),n._v(" "),r("br"),n._v(" "),r("button",{staticClass:"btn btn-primary btn-block btn-login login-spacer",on:{click:function(e){n.redirect("registration")}}},[n._v("Register New Company")])])])])])])},staticRenderFns:[function(){var n=this,e=n.$createElement,t=n._self._c||e;return t("div",{staticClass:"col-sm-12 col-md-8 hide-this"},[t("div",{staticClass:"container-fluid banner"},[t("img",{attrs:{src:r(447),height:"100%",width:"100%"}})])])},function(){var n=this,e=n.$createElement,r=n._self._c||e;return r("div",{staticClass:"login-header"},[r("h1",{staticClass:"navbar-brand"},[n._v("\n            Log In\n          ")])])},function(){var n=this,e=n.$createElement,r=n._self._c||e;return r("span",{staticClass:"input-group-addon",attrs:{id:"addon-1"}},[r("i",{staticClass:"fa fa-user"})])},function(){var n=this,e=n.$createElement,r=n._self._c||e;return r("span",{staticClass:"input-group-addon",attrs:{id:"addon-2"}},[r("i",{staticClass:"fa fa-key"})])},function(){var n=this,e=n.$createElement,r=n._self._c||e;return r("div",{staticClass:"form-check"},[r("label",{staticClass:"form-check-label"},[r("input",{staticClass:"form-check-input",attrs:{type:"checkbox"}}),n._v("\n              Keep me logged in\n            ")])])}]}}});
//# sourceMappingURL=14.ff7bb2145755b715ea42.js.map