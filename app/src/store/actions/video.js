import axios from 'utils/axios'
import { VideoTypes } from '../video'

export const login = (id_video) => (dispatch, getState) => {
  dispatch({ type: VideoTypes.GET_VIDEO })
  return axios.get('api/file.php', { params : { id_video } })
    .then(({ data : data }) => {
      dispatch({
        type: VideoTypes.GET_VIDEO_SUCCESS,
        user: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: VideoTypes.GET_VIDEO_ERROR,
        error
      })
    })
}
