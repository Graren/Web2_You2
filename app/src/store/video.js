import { createReducer, createActions } from 'reduxsauce'
import * as actions from './actions/video'

/* ------------- Types and Action Creators ------------- */

const { Types, Creators } = createActions({
  login: actions.login,
  loginSuccess: ['user'],
  loginError: ['error'],
  signout: actions.signout,
  signoutSuccess: [],
  signoutError: ['error'],
  signup: actions.signup,
  signupSuccess: ['user'],
  signupError: ['error'],
  deleteUser: actions.deleteUser,
  deleteSuccess: ['user'],
  deleteError: ['error']
})

export const UserTypes = Types
export default Creators

/* ------------- Initial State ------------- */

export const INITIAL_STATE = {
  user: null,
  fetching: false,
  error: null
}

/* ------------- Reducers ------------- */

export const request = (state) => Object.assign({}, state, {
  fetching: true,
  error: null
})

export const loginSuccess = (state, { user }) => Object.assign({}, state, {
  user,
  fetching: false,
  error: null
})

export const deleteSuccess = (state) => Object.assign({}, state, {
  user: null,
  fetching: false,
  error: null
})

export const signoutSuccess = state => INITIAL_STATE

export const error = (state, { error }) => Object.assign({}, state, {
  error,
  fetching: false
})

/* ------------- Hookup Reducers To Types ------------- */

export const reducer = createReducer(INITIAL_STATE, {
  [Types.LOGIN]: request,
  [Types.LOGIN_SUCCESS]: loginSuccess,
  [Types.LOGIN_ERROR]: error,
  [Types.SIGNOUT]: request,
  [Types.SIGNOUT_SUCCESS]: signoutSuccess,
  [Types.SIGNOUT_ERROR]: error,
  [Types.SIGNUP]: request,
  [Types.SIGNUP_SUCCESS]: loginSuccess,
  [Types.SIGNUP_ERROR]: error,
  [Types.DELETE]: request,
  [Types.DELETE_SUCCESS]: deleteSuccess,
  [Types.DELETE_ERROR]: error
})
