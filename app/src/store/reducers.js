import { combineReducers } from 'redux'
import locationReducer from './location'
import { reducer as userReducer } from './user'
import { reducer as searchReducer } from './search'
import { reducer as videoReducer } from './video'
export const makeRootReducer = (asyncReducers) => {
  return combineReducers({
    location: locationReducer,
    user: userReducer,
    search: searchReducer,
    video: videoReducer,
    ...asyncReducers
  })
}

export const injectReducer = (store, { key, reducer }) => {
  if (Object.hasOwnProperty.call(store.asyncReducers, key)) return

  store.asyncReducers[key] = reducer
  store.replaceReducer(makeRootReducer(store.asyncReducers))
}

export default makeRootReducer
