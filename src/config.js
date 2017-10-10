let LIVE_BACKEND_URL = 'https://app.ilinya.com' // 'http://johnenrick.com'
let DEV_BACKEND_URL = 'http://localhost/ilinya/api'
let isDev = false // Set to false in live
let BACKEND_URL = isDev ? DEV_BACKEND_URL : LIVE_BACKEND_URL
export default{
  IS_DEV: isDev,
  API_URL: BACKEND_URL + '/api/',
  IMAGE_URL: BACKEND_URL + '/image/',
  BACKEND_URL: BACKEND_URL
}
