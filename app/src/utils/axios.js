import axios from 'axios'

//Change when you know whats the port
const devConfig = {
  baseURL: 'http://localhost:8001/Web2_You2/',
  withCredentials: true
}

const productionConfig = {
  baseURL: '/W2_You2/'
}

const instance = axios.create(__DEV__ ? devConfig : productionConfig)

export default instance
