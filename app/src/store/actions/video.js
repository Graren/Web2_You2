import axios from 'utils/axios'
import { VideoTypes } from '../video'

export const addComment = (id_video, comment) => (dispatch, getState) => {
  dispatch({ type: VideoTypes.ADD_COMMENT })
  const fd = new FormData();
  fd.append("id_video", id_video);
  fd.append("comment", comment);
  return axios.post('api/comment.php', fd)
    .then(({ data : data }) => {
      dispatch({
        type: VideoTypes.ADD_COMMENT_SUCCESS,
        comment: data.data
      })
    })
    .catch(error => {
      dispatch({
        type: VideoTypes.ADD_COMMENT_ERROR,
        error
      })
    })
}

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
