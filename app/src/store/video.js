import { createReducer, createActions } from 'reduxsauce'
import * as actions from './actions/video'

/* ------------- Types and Action Creators ------------- */

const { Types, Creators } = createActions({
  getVideo: actions.getVideo,
  getVideoSuccess: ['video'],
  getVideoError: ['error']
})

export const VideoTypes = Types
export default Creators

/* ------------- Initial State ------------- */

export const INITIAL_STATE = {
  video: null,
  fetching: false,
  error: null
}

/* ------------- Reducers ------------- */

export const request = (state) => Object.assign({}, state, {
  fetching: true,
  error: null
})

export const getVideoSuccess = (state, { video }) => Object.assign({}, state, {
  video,
  fetching: false,
  error: null
})

export const error = (state, { error }) => Object.assign({}, state, {
  error,
  fetching: false
})

/* ------------- Hookup Reducers To Types ------------- */

export const reducer = createReducer(INITIAL_STATE, {
  [Types.GET_VIDEO]: request,
  [Types.GET_VIDEO_SUCCESS]: getVideoSuccess,
  [Types.GET_VIDEO_ERROR]: error
})
