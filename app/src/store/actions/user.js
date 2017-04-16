import axios from 'utils/axios'
import { UserTypes } from '../user'

export const login = (email, password) => (dispatch, getState) => {
  dispatch({ type: UserTypes.LOGIN })
  let fd = new FormData();
  fd.append("email",email);
  fd.append("password",password);
  return axios.post('api/login.php', fd)
    .then( ({data : data}) => {
      dispatch({
        type: UserTypes.LOGIN_SUCCESS,
        user: data.data
      })
    })
    .catch(({ response: { data } }) => {
      dispatch({
        type: UserTypes.LOGIN_ERROR,
        error: data
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
    .catch(({ response: { data } }) => {
      dispatch({
        type: UserTypes.SIGNOUT_ERROR,
        error: data
      })
    })
}
