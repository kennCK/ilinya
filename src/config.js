
let LIVE_BACKEND_URL = 'https://app.ilinya.com/api' // 'http://johnenrick.com'
let DEV_BACKEND_URL = 'https://app.ilinya.com/api'
let isDev = true
let BACKEND_URL = isDev ? DEV_BACKEND_URL : LIVE_BACKEND_URL
export default{
  IS_DEV: isDev,
  API_URL: BACKEND_URL + '/api/',
  IMAGE_URL: BACKEND_URL + '/image/',
  BACKEND_URL: BACKEND_URL
}
