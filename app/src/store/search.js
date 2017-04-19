import { createReducer, createActions } from 'reduxsauce'
import * as actions from './actions/search'

/* ------------- Types and Action Creators ------------- */

const { Types, Creators } = createActions({
  searchVideos: actions.searchVideos,
  searchVideosSuccess: ['videos', 'prevPage', 'nextPage'],
  searchVideosError: ['error']
})

export const SearchTypes = Types
export default Creators

/* ------------- Initial State ------------- */

export const INITIAL_STATE = {
  videos: null,
  prevPage: null,
  nextPage: null,
  fetching: false,
  error: null
}

/* ------------- Reducers ------------- */

export const request = (state) => Object.assign({}, state, {
  fetching: true,
  error: null
})

export const searchVideos = (state, { videos, prevPage, nextPage }) => Object.assign({}, state, {
  videos,
  prevPage,
  nextPage,
  fetching: true,
  error: null
})

export const error = (state, { error }) => Object.assign({}, state, {
  error,
  fetching: false
})

/* ------------- Hookup Reducers To Types ------------- */

export const reducer = createReducer(INITIAL_STATE, {
  [Types.SEARCH_VIDEOS]: request,
  [Types.SEARCH_VIDEOS_SUCCESS]: searchVideos,
  [Types.SEARCH_VIDEOS_ERROR]: error,
})
