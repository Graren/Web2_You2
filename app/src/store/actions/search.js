import axios from 'utils/axios'
import { SearchTypes } from '../search'

export const searchVideos = (q, page) => (dispatch, getState) => {
  dispatch({ type: SearchTypes.SEARCH_VIDEOS })
  return axios.get('api/search.php', { params: { q, page } })
    .then(({ data : { data } }) => {
      dispatch({
        type: SearchTypes.SEARCH_VIDEOS_SUCCESS,
        videos: data.videos,
        nextPage: data.nextPage,
        prevPage: data.prevPage
      })
    })
    .catch(error => {
      dispatch({
        type: SearchTypes.SEARCH_VIDEOS_ERROR,
        error
      })
    })
}
