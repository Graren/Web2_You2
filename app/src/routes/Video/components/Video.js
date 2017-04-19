import React, { Component, PropTypes } from 'react'
import { browserHistory } from 'react-router'
import VideoCard from 'components/VideoCard'

export class Video extends Component{
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

  }

  componentDidMount (){
    // if (!this.props.user) {
    //   browserHistory.push('/')
    // } else {
    //   this.props.getProfile(1, this.props.params.username)
    // }
    this.props.getVideo(this.props.params.id_video);
    this.props.getVideoReport(this.props.params.id_video)
  }

  render (){
    // const  user  = this.props.params.username === this.props.user.username ? this.props.user : this.props.userProfile
    // const videos = (this.props.videos) ? this.props.videos : []
    // const { prev } = this.props
    // const { next } = this.props
    // const allowDelete = user.username === this.props.user.username? true : false
    return (
      <div className="container">
        <video src={`http://localhost:8001/W2_You2/api/video.php?id_video=${this.props.params.id_video}`} controls></video>
      </div>

    )
  }
}

export default Video
