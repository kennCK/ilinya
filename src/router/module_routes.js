import AUTH from 'services/auth'
let CONFIG = require('config.js')
let beforeEnter = (to, from, next) => {
  // TODO Redirect if no token when token is required in meta.tokenRequired
  AUTH.currentPath = to.path
  if(AUTH.user.userID || to.meta.tokenRequired !== true){
    next()
  }else{
    if(to.name !== 'login'){
      if(!AUTH.tokenData.verifyingToken){
        next({
          path: '/'
        })
      }
    }else{
      if(!AUTH.tokenData.verifyingToken){
        next()
      }
    }
  }
}
var devRoutes = []
let canales = require('./dev_routes/canales.js')
let casera = require('./dev_routes/casera.js')
let salise = require('./dev_routes/salise.js')
let plenos = require('./dev_routes/plenos.js')
devRoutes = devRoutes.concat(canales.default.routes)
devRoutes = devRoutes.concat(casera.default.routes)
devRoutes = devRoutes.concat(salise.default.routes)
devRoutes = devRoutes.concat(plenos.default.routes)
for(let x = 0; x < devRoutes.length; x++){
  devRoutes[x]['beforeEnter'] = beforeEnter
}
let routes = [
  {
    path: '/',
    name: 'home',
    component: resolve => require(['modules/home/LogIn.vue'], resolve),
    beforeEnter: beforeEnter

  },
  {
    path: '/admin',
    name: 'login',
    component: resolve => require(['modules/home/LogIn.vue'], resolve),
    beforeEnter: (to, from, next) => {
      AUTH.currentPath = to.path
      if(AUTH.user.userID){
        next({
          path: (AUTH.user.type === 1) ? '/product_management' : '/cashier'
        })
      }else{
        if(!AUTH.tokenData.verifyingToken){
          next()
        }
      }
    }
  }
]
if(CONFIG.default.IS_DEV){
  routes = routes.concat(devRoutes)
}
export default{
  routes: routes
}
