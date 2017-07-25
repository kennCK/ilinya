
export default{
  routes: [{
    path: '/canales',
    name: 'canales',
    component: resolve => require(['modules/test/Canales.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/employee_management',
    name: 'employee',
    component: resolve => require(['modules/employee/EmployeeManagement.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/company_selection',
    name: 'companySelection',
    component: resolve => require(['modules/home/CompanySelection.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/registration',
    name: 'registration',
    component: resolve => require(['modules/home/CompanyRegistration.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
    path: '/recover_account',
    name: 'recoverAccount',
    component: resolve => require(['modules/home/RecoverAccount.vue'], resolve),
    meta: {
      tokenRequired: false
    }
  },
  {
    path: '/my_profile',
    name: 'myProfile',
    component: resolve => require(['modules/portal/MyProfile.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/schedule_management',
    name: 'scheduleManagement',
    component: resolve => require(['modules/schedule/ScheduleManagement.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/company_schedule',
    name: 'companySchedule',
    component: resolve => require(['modules/schedule/CompanySchedule.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  },
  {
    path: '/employee_schedule',
    name: 'employeeSchedule',
    component: resolve => require(['modules/schedule/EmployeeSchedule.vue'], resolve),
    meta: {
      tokenRequired: true
    }
  }
  ]
}
