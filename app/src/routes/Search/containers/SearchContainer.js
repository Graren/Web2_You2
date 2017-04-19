import { connect } from 'react-redux'

/*  This is a container component. Notice it does not contain any JSX,
    nor does it import React. This component is **only** responsible for
    wiring in the actions and state necessary to render a presentational
    component - in this case, the counter:   */

import Search from '../components/Search'
import SearchActions from 'store/search'
/*  Object of action creators (can also be function that returns object).
    Keys will be passed as props to presentational components. Here we are
    implementing our wrapper around increment; the component doesn't care   */

const mapDispatchToProps = (dispatch) => ({
  //eslint-disable-next-line
  searchVideos: (q, page) => dispatch(SearchActions.searchVideos(q, page)),
  // deleteUser: (user) => dispatch(UserActions.deleteUser(user))
  // editUser: (user) => dispatch(UserActions.editUser(user)),
})

const mapStateToProps = (state) => ({
  user : state.user.user,
  videos : state.search.videos,
  nextPage : state.search.nextPage,
  prevPage : state.search.prevPage
})

export default connect(mapStateToProps, mapDispatchToProps)(Search)
