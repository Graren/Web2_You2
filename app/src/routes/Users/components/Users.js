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
      videos : [],
      showModal: false,
      allowDelete :false
    }
  }

  static propTypes = {
    user : PropTypes.object,
    videos : PropTypes.array,
    getProfile : PropTypes.func,
    deleteUser: PropTypes.func,
    prev : PropTypes.oneOfType([
      PropTypes.number,
      PropTypes.bool
    ]),
    next : PropTypes.oneOfType([
      PropTypes.number,
      PropTypes.bool
    ])
  }

  componentDidMount (){
    if (!this.props.user) {
      browserHistory.push('/')
    } else {
      this.props.getProfile(1, this.props.params.username)
    }
  }

  onDelete(){
    this.setState({ showModal: true })
  }

  close(){
    this.setState({ showModal: false });
  }
  actualDelete () {
    this.close()
    this.props.deleteUser()
  }

  render (){
    const  user  = this.props.params.username === this.props.user.username ? this.props.user : this.props.userProfile
    const videos = (this.props.videos) ? this.props.videos : []
    const { prev } = this.props
    const { next } = this.props
    const allowDelete = user.username === this.props.user.username? true : false
    return (
      <div className="container">
        <UsersData allowDelete={allowDelete}
          user={user}
          showModal={this.state.showModal}
          onDelete={this.onDelete.bind(this)}
          actualDelete={this.actualDelete.bind(this)}
          close={this.close.bind(this)}/>
        {videos && videos.map(video => (
          <VideoCard
            title={video.name}
            description={video.description}
            id_video={video.id_video}
            username={video.username}
            length={video.length}
            tags={video.tags}
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
