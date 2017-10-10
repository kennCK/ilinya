webpackJsonp([5],{144:function(s,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0});var t=e(1),o=e(2);a.default={name:"LogIn",mounted:function(){},data:function(){return{username:"ryan",password:"secret",isLoading:!1,errorMessage:""}},methods:{signIn:function(){var s=this;this.isLoading=!0,o.a.authenticate(this.username,this.password,function(a){s.isLoading=!1,t.a.go({path:"/"})},function(a,e){s.errorMessage=401===e?"Username and password mismatched":"Cannot log in. Contact developer if error persist.",s.isLoading=!1})}}}},152:function(s,a,e){a=s.exports=e(38)(),a.push([s.i,"","",{version:3,sources:[],names:[],mappings:"",file:"LogIn.vue",sourceRoot:""}])},158:function(s,a,e){var t=e(152);"string"==typeof t&&(t=[[s.i,t,""]]),t.locals&&(s.exports=t.locals);e(39)("1d44611e",t,!0)},164:function(s,a){s.exports={render:function(){var s=this,a=s.$createElement,e=s._self._c||a;return e("div",{staticClass:"container"},[e("div",{staticClass:"row"},[e("div",{staticClass:"col-sm-6 col-sm-offset-3"},[e("div",{staticClass:"panel panel-primary"},[e("div",{staticClass:"panel-heading"},[s._v("Welcome to Abacus Point of Sale System!")]),s._v(" "),e("div",{staticClass:"panel-body"},[""===s.errorMessage||s.isLoading?s._e():e("div",{staticClass:"alert alert-danger"},[e("strong",[s._v("Failed!")]),s._v(" "+s._s(s.errorMessage)+"\n          ")]),s._v(" "),e("form",{staticClass:"form-horizontal"},[e("div",{staticClass:"form-group "},[e("label",{staticClass:"col-md-2 control-label"},[s._v("Username")]),s._v(" "),e("div",{staticClass:"col-md-10"},[e("input",{directives:[{name:"model",rawName:"v-model",value:s.username,expression:"username"}],staticClass:"form-control",attrs:{disabled:s.isLoading,type:"text",placeholder:"Username"},domProps:{value:s.username},on:{input:function(a){a.target.composing||(s.username=a.target.value)}}})])]),s._v(" "),e("div",{staticClass:"form-group"},[e("label",{staticClass:"col-md-2 control-label"},[s._v("Password")]),s._v(" "),e("div",{staticClass:"col-md-10"},[e("input",{directives:[{name:"model",rawName:"v-model",value:s.password,expression:"password"}],staticClass:"form-control",attrs:{disabled:s.isLoading,type:"password",placeholder:"Password"},domProps:{value:s.password},on:{input:function(a){a.target.composing||(s.password=a.target.value)}}})])]),s._v(" "),e("div",{staticClass:"form-group"},[e("div",{staticClass:"col-sm-12"},[e("button",{staticClass:"btn btn-primary pull-right",attrs:{disabled:s.isLoading,type:"button"},on:{click:s.signIn}},[s._v("\n                  "+s._s(s.isLoading?"Signing in...":"Sign In")+"\n                ")])])])])])])])])])},staticRenderFns:[]}},42:function(s,a,e){e(158);var t=e(7)(e(144),e(164),null,null);s.exports=t.exports}});
//# sourceMappingURL=5.43bc0b705da4ccef275e.js.map