import React, { Component, PropTypes } from 'react'
import { Row, Col, Jumbotron } from 'react-bootstrap'
import { browserHistory } from 'react-router'
import axios from 'utils/axios'
import UsersData from './UserData/UserData'
import UserVideos from './UserVideos/UserVideos'

export class  Users  extends Component{
  constructor(props) {
    super(props)
    this.state = {
      user : {},
      videos : []
    }
  }
  static propTypes = {
    user : PropTypes.object,
    videos : PropTypes.array,
    getProfile : PropTypes.func,
    deleteUser: PropTypes.func
  }

  componentDidMount() {
    if (!this.props.user) {
      browserHistory.push('/')
    } else {
      this.props.getProfile(1)
    }
  }

  render() {
    const { user } = this.props
    const { videos } = this.props || []
    return (
      <div>
        <UsersData user={user}/>
        <UserVideos />
      </div>
    )
  }
}

export default Users
