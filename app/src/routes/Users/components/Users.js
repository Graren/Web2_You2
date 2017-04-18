import React, { Component, PropTypes } from 'react'
import { Row, Col, Jumbotron } from 'react-bootstrap'
import { browserHistory } from 'react-router'
import axios from 'utils/axios'
import UsersData from './UserData/UserData'

export class  UserContainer  extends Component{
  constructor(props) {
    super(props)
    this.state = {
      user : {},
      videos : []
    }
  }
  static propTypes = {
    user : PropTypes.object,
    videos : PropTypes.array
  }

  componentDidMount() {
    if (!this.props.user) {
      browserHistory.push('/')
    } else {
      console.log("nothing implemented");
    }
  }

  render() {
    const { user } = this.props
    const { videos } = this.props || []
    return (
      <div>
        <UsersData user={user}/>
        <div className="videoContainer">
          {
              // (videos.map(video => {
              //   <Col md={4} sm={6} className="col-project-card">
              //         <VideoCard {...video} />
              //       </Col>
              // }))
          }
        </div>
      </div>
    )
  }
}

export default UserContainer
