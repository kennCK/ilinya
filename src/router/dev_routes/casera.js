
export default{
  routes: [{
    path: '/casera',
    name: 'casera',
    component: resolve => require(['modules/test/Casera.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  }]
}
