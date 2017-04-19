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
  getProfile: (page,username) => dispatch(UserActions.getProfile(page,username)),
  deleteUser: () => dispatch(UserActions.deleteUser())
  // editUser: (user) => dispatch(UserActions.editUser(user)),
})

const mapStateToProps = (state) => ({
  user : state.user.user,
  userProfile :(state.user.profile && state.user.profile.user) ? state.user.profile.user : {},
  videos : (state.user.profile && state.user.profile.videos) ? state.user.profile.videos : [],
  prev : (state.user.profile && state.user.profile.prevPage) ? state.user.profile.prevPage : false,
  next : (state.user.profile && state.user.profile.nextPage) ? state.user.profile.nextPage : false
})

export default connect(mapStateToProps, mapDispatchToProps)(Users)
