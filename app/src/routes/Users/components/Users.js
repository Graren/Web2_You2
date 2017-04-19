import React, { Component, PropTypes } from 'react'
import { browserHistory } from 'react-router'
import UsersData from './UserData/UserData'
import VideoCard from 'components/VideoCard'
import { Pager } from 'react-bootstrap'

export class Users extends Component{
  constructor (props) {
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
    deleteUser: PropTypes.func,
    prev : PropTypes.bool,
    next : PropTypes.bool
  }

  componentDidMount (){
    if (!this.props.user) {
      browserHistory.push('/')
    } else {
      this.props.getProfile(1, this.props.user.username)
    }
  }

  render (){
    const { user } = this.props
    const { videos } = this.props
    const { prev } = this.props
    const { next } = this.props
    console.log(this.props)

    return (
      <div className="container">
        <UsersData user={user}/>
        {videos.map(video => (
          <VideoCard
            title={video.name}
            description={video.description}
            id_video={video.id_video}
          />
        ))}
        <Pager>
          {
            prev && <Pager.Item onClick={e => {
              e.preventDefault()
              this.props.getProfile(prev, user.username)
            }} >Previous</Pager.Item>
          }
          {
            next && <Pager.Item onClick={e => {
              e.preventDefault()
              this.props.getProfile(next, user.username)
            }} >Next</Pager.Item>
          }
        </Pager>

      </div>

    )
  }
}

export default Users
