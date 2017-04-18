import React,{Component,PropTypes} from 'react'
import { connect } from 'react-redux'
import HomeView from '../components/HomeView.js'

class HomeContainer extends Component{
  constructor(props){
    super(props);
  }
  static PropTypes = {
    user: PropTypes.object,
  }

  render() {
    return (
      <HomeView {...this.props} />
    )
  }

}

const mapStateToProps = (state) => ({
  user : state.user.user
})

const mapDispatchToProps = (dispatch) => ({
  createProject: (project) => dispatch(ProjectActions.createProject(project))
})

export default connect(mapStateToProps, mapDispatchToProps)(HomeContainer)
