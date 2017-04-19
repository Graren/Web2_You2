import React, { Component, PropTypes } from 'react'
import { Link } from 'react-router'
import {
  Row,
  Col,
  Button,
  FormGroup,
  FormControl,
  ControlLabel,
} from 'react-bootstrap'
import Card from 'components/card'
import VideoCard from 'components/VideoCard'
import { Line } from 'react-chartjs-2'
import { generateChartData } from '../utils/chartDataGenerator'
import axios from 'utils/axios'
import url from 'utils/url'
import _ from 'lodash'

const DAYS = ['day_1', 'day_2', 'day_3', 'day_4', 'day_5', 'day_6', 'day_7']

export class Video extends Component{
  constructor (props) {
    super(props)
    this.state = {
      user : {},
      videos : [],
      showModal: false,
      allowDelete :false,
      comment: ''
    }
  }

  static propTypes = {

  }

  componentDidMount (){
    this.props.getVideo(this.props.params.id_video);
    this.props.getVideoReport(this.props.params.id_video)
  }

  likeVideo = (id_video) => {
    const fd = new FormData();
    fd.append("id_video", id_video);
    axios.post('api/like.php', fd)
      .then(({ data : { data } }) => {
        this.props.getVideo(this.props.params.id_video);
        this.props.getVideoReport(this.props.params.id_video)
      })
      .catch(error => {
        console.log(error)
      })
  }

  dislikeVideo = (id_video) => {
    const fd = new FormData();
    fd.append("id_video", id_video);
    axios.post('api/dislike.php', fd)
      .then(({ data : { data } }) => {
        this.props.getVideo(this.props.params.id_video);
        this.props.getVideoReport(this.props.params.id_video)
      })
      .catch(error => {
        console.log(error)
      })
  }

  onCommentChange = e => {
    this.setState({
      comment: e.target.value
    })
  }

  render (){
    const { video, report } = this.props
    const chartData = generateChartData(DAYS.map(day => report.likes[day][day]), DAYS.map(day => report.dislikes[day][day]))
    return (
      <div className="container">
        <Row>
          <Col md={6}>
            <video style={{width: '100%'}} src={`http://localhost:8001/W2_You2/api/video.php?id_video=${this.props.params.id_video}`} controls></video>
            <div>
              <Button onClick={() => this.likeVideo(video.id_video)}>Like</Button>
              <Button onClick={() => this.dislikeVideo(video.id_video)}>Dislike</Button>
            </div>
            <h1>{video.name}</h1>
            <p>{video.description}</p>
            <h5>Tags: {video.tags && video.tags.map(tag => tag.name).join(', ')}</h5>
            <h5>Liked by {video.usersLiked.map(userLiked =>
              <span>
                <Link to={url(`/profile/${userLiked}`)}>{userLiked}</Link>
                <span> </span>
              </span>
            )}</h5>
            <h2 style={{color: 'grey'}}>Comments</h2>
            <FormGroup onChange={this.onCommentChange} value={this.state.comment}>
              <ControlLabel>Comment</ControlLabel>
              <FormControl componentClass="textarea" placeholder="Nice video" />
            </FormGroup>
            <Button onClick={() => this.props.addComment(video.id_video, this.state.comment)}>Add Comment</Button>
            {video.comments.map(comment => (
              <Card>
                <h5>{comment.comment}</h5>
                <Link to={url(`/profile/${comment.username}`)}>Comment by: {comment.username}</Link>
              </Card>
            ))}
          </Col>
          <Col md={6}>
            <Line data={chartData} />
          </Col>
        </Row>
      </div>

    )
  }
}

export default Video
