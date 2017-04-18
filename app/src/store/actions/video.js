import axios from 'utils/axios'
import { UserTypes } from '../video'

export const login = (email, password) => (dispatch, getState) => {
  dispatch({ type: UserTypes.LOGIN })
  const fd = new FormData();
  fd.append("email", email);
  fd.append("password", password);
  return axios.post('api/login.php', fd)
    .then( ({data : data}) => {
      console.log(data);
      dispatch({
        type: UserTypes.LOGIN_SUCCESS,
        user: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: UserTypes.LOGIN_ERROR,
        error
      })
    })
}

export const signup = (user) => (dispatch, getState) => {
  dispatch({ type: UserTypes.SIGNUP })
  const fd = new FormData();
  fd.append("username", user.username);
  fd.append("email", user.email);
  fd.append("password", user.password);
  return axios.post('api/signup.php', fd)
    .then(({data : data}) => {
      dispatch({
        type: UserTypes.SIGNUP_SUCCESS,
        user: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: UserTypes.SIGNUP_ERROR,
        error
      })
    })
}

export const signout = () => (dispatch, getState) => {
  dispatch({ type: UserTypes.SIGNOUT })
  return axios.post('api/logout.php', {})
    .then(() => {
      dispatch({
        type: UserTypes.SIGNOUT_SUCCESS
      })
    })
    .catch(error => {
      dispatch({
        type: UserTypes.SIGNOUT_ERROR,
        error
      })
    })
}

export const deleteUser = (user) => (dispatch, getState) => {
  dispatch({ type: UserTypes.DELETE })
  const fd = new FormData();
  fd.append("email", user.email);
  return axios.post('api/closeAccount.php',fd )
    .then(() => {
      dispatch({
        type: UserTypes.DELETE_SUCCESS
      })
    })
    .catch(error => {
      dispatch({
        type: UserTypes.DELETE_ERROR,
        error
      })
    })
}

//missing update
