import { connect } from 'react-redux'

/*  This is a container component. Notice it does not contain any JSX,
    nor does it import React. This component is **only** responsible for
    wiring in the actions and state necessary to render a presentational
    component - in this case, the counter:   */

import Users from '../components/Users'

/*  Object of action creators (can also be function that returns object).
    Keys will be passed as props to presentational components. Here we are
    implementing our wrapper around increment; the component doesn't care   */

const mapDispatchToProps = (dispatch) => ({
  //eslint-disable-next-line
  // getVideosFromUser: () => dispatch(AdminActions.getUsers()),
  // deleteUser: (id_user) => dispatch(AdminActions.deleteUser(id_user)),
  // editUser: (user) => dispatch(AdminActions.editUser(user)),
})

const mapStateToProps = (state) => ({
  user : state.user.user,
  //videos : state.videos.videos
})

export default connect(mapStateToProps, mapDispatchToProps)(Users)
