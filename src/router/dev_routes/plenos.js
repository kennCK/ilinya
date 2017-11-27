
export default{
  routes: [{
    path: '/queue_form_management',
    name: 'queueFormManagement',
    component: resolve => require(['modules/queue_form/QueueFormManagement.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/counter',
    name: 'counter',
    component: resolve => require(['modules/counter/Counter.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/account_management',
    name: 'account_management',
    component: resolve => require(['modules/account_management/AccountManagement.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/auth',
    name: 'auth',
    component: resolve => require(['modules/test/Auth.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
    path: '/admin_home',
    name: 'admin_home',
    component: resolve => require(['modules/home/AdminHome.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/mockup',
    name: 'mockup',
    component: resolve => require(['modules/test/Mockup.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }]
}
