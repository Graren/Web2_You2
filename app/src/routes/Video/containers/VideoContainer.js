import { connect } from 'react-redux'

/*  This is a container component. Notice it does not contain any JSX,
    nor does it import React. This component is **only** responsible for
    wiring in the actions and state necessary to render a presentational
    component - in this case, the counter:   */

import Video from '../components/Video'
import VideoActions from 'store/video'
/*  Object of action creators (can also be function that returns object).
    Keys will be passed as props to presentational components. Here we are
    implementing our wrapper around increment; the component doesn't care   */

const mapDispatchToProps = (dispatch) => ({
  //eslint-disable-next-line
  getVideo: (id_video) => dispatch(VideoActions.getVideo(id_video)),
  getVideoReport: (id_video) => dispatch(VideoActions.getVideoReport(id_video)),
  addComment: (id_video, comment) => dispatch(VideoActions.addComment(id_video, comment))
  // deleteUser: () => dispatch(UserActions.deleteUser())
  // editUser: (user) => dispatch(UserActions.editUser(user)),
})

const mapStateToProps = (state) => ({
  user : state.user.user,
  video : (state.video.video) ? state.video.video : {},
  report : (state.video.report) ? state.video.report : {}
  // userProfile :(state.user.profile && state.user.profile.user) ? state.user.profile.user : {},
  // videos : (state.user.profile && state.user.profile.videos) ? state.user.profile.videos : [],
})

export default connect(mapStateToProps, mapDispatchToProps)(Video)
