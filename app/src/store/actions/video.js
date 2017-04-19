import axios from 'utils/axios'
import { VideoTypes } from '../video'

export const getVideo = (id_video) => (dispatch, getState) => {
  dispatch({ type: VideoTypes.GET_VIDEO })
  return axios.get('api/file.php', { params : { id_video } })
    .then(({ data : data }) => {
      console.log(data);
      dispatch({
        type: VideoTypes.GET_VIDEO_SUCCESS,
        video: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: VideoTypes.GET_VIDEO_ERROR,
        error
      })
    })
}

export const getVideoReport = (id_video) => (dispatch, getState) => {
  dispatch({ type: VideoTypes.GET_VIDEO_REPORT })
  return axios.get('api/weekData.php', { params : { id_video } })
    .then(({ data : data }) => {
      console.log(data);
      dispatch({
        type: VideoTypes.GET_VIDEO_REPORT_SUCCESS,
        report: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: VideoTypes.GET_VIDEO_REPORT_ERROR,
        error
      })
    })
}
