let LIVE_BACKEND_URL = 'https://devapi.ilinya.com/api' // DEV
// let LIVE_BACKEND_URL = 'https://api.ilinya.com/api' //PRODUCTION
let DEV_BACKEND_URL = 'http://localhost/ilinya/api'
let isDev = true // Set to false in live
let BACKEND_URL = isDev ? DEV_BACKEND_URL : LIVE_BACKEND_URL
export default{
  IS_DEV: isDev,
  API_URL: BACKEND_URL + '/api/',
  IMAGE_URL: BACKEND_URL + '/image/',
  BACKEND_URL: BACKEND_URL
}
