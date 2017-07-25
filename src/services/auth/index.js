// src/auth/index.js
import {router} from '../../router/index'
import ROUTER from '../../router'
import Vue from 'vue'
export default {
  user: {
    userID: 0,
    username: '',
    type: 0,
    company_id: 0,
    company_branch_id: 0
  },
  tokenData: {
    token: null,
    tokenTimer: false,
    verifyingToken: false
  },
  currentPath: false,
  setUser(userID, username, type){
    if(userID === null){
      username = null
      type = null
    }
    this.user.userID = userID * 1
    this.user.username = username
    this.user.type = type * 1
  },
  setCompany(companyID, companyBranch){
    if(companyID === null){
      companyID = null
      companyBranch = null
    }
    this.user.company_id = companyID * 1
    this.user.company_branch_id = companyBranch
    localStorage.setItem('company_id', companyID)
    localStorage.setItem('company_branch_id', companyBranch)
  },
  setToken(token){
    this.tokenData.token = token
    localStorage.setItem('usertoken', token)
    if(token){
      setTimeout(() => {
        let vue = new Vue()
        vue.APIRequest('authenticate/refresh', {}, (response) => {
          this.setToken(response['token'])
        }, (response) => {
          ROUTER.go('/')
        })
      }, 1000 * 60 * 50) // 50min
    }
  },
  authenticate(username, password, callback, errorCallback){
    let vue = new Vue()
    let credentials = {
      username: username,
      password: password
    }

    vue.APIRequest('authenticate', credentials, (response) => {
      this.setToken(response.token)
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        this.setUser(userInfo.id, userInfo.username, userInfo.user_type_id)
        if(callback){
          callback(userInfo)
        }
      })

    }, (response, status) => {
      if(errorCallback){
        errorCallback(response, status)
      }
    })
  },
  checkAuthentication(callback){
    this.tokenData.verifyingToken = true
    let token = localStorage.getItem('usertoken')
    this.user.company_id = localStorage.getItem('company_id')
    this.user.company_branch_id = localStorage.getItem('company_branch_id')
    if(token){
      this.setToken(token)
      let vue = new Vue()
      vue.APIRequest('authenticate/user', {}, (userInfo) => {
        this.setUser(userInfo.id, userInfo.username, userInfo.user_type_id)
        this.tokenData.verifyingToken = false
        if(this.currentPath){
          ROUTER.push({
            path: this.currentPath
          })
        }
      }, (response) => {
        this.setToken(null)
        this.tokenData.verifyingToken = false
        ROUTER.push({
          path: this.currentPath
        })

      })
      return true
    }else{
      this.tokenData.verifyingToken = false
      this.setUser(null)
      return false
    }

  },
  deaunthenticate(){
    localStorage.removeItem('usertoken')
    localStorage.removeItem('company_id')
    localStorage.removeItem('company_branch_id')
    this.setUser(null)
    let vue = new Vue()
    vue.APIRequest('authenticate/invalidate')
  }
}
