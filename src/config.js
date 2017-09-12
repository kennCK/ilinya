<<<<<<< HEAD
let LIVE_BACKEND_URL = 'http://johnenrick.com'
let DEV_BACKEND_URL = 'http://127.0.0.1/ilinya/api'
=======
let LIVE_BACKEND_URL = 'https://45bbde8c.ngrok.io/ilinya/api' // 'http://johnenrick.com'
let DEV_BACKEND_URL = 'http://localhost/ilinya/api'
>>>>>>> 6728dc5a84595c9de4e3c2f190a53fd640f3dbb7
let isDev = true
let BACKEND_URL = isDev ? DEV_BACKEND_URL : LIVE_BACKEND_URL
export default{
  IS_DEV: isDev,
  API_URL: BACKEND_URL + '/api/',
  IMAGE_URL: BACKEND_URL + '/image/',
  BACKEND_URL: BACKEND_URL
}
