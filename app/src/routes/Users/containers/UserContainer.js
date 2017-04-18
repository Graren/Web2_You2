import { connect } from 'react-redux'

/*  This is a container component. Notice it does not contain any JSX,
    nor does it import React. This component is **only** responsible for
    wiring in the actions and state necessary to render a presentational
    component - in this case, the counter:   */

import Users from '../components/Users'
import UserActions from 'store/user'
/*  Object of action creators (can also be function that returns object).
    Keys will be passed as props to presentational components. Here we are
    implementing our wrapper around increment; the component doesn't care   */

const mapDispatchToProps = (dispatch) => ({
  //eslint-disable-next-line
  getProfile: (page) => dispatch(UserActions.getProfile(page)),
  deleteUser: (user) => dispatch(UserActions.deleteUser(user))
  // editUser: (user) => dispatch(UserActions.editUser(user)),
})

const mapStateToProps = (state) => ({
  user : state.user.user,
  // userProfile :state.profile.user,
  // videos : state.videos.videos
})

export default connect(mapStateToProps, mapDispatchToProps)(Users)
