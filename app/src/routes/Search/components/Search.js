import React, { Component, PropTypes } from 'react'
import { Row, Col, Jumbotron, Pager, FormControl, Button, Radio } from 'react-bootstrap'
import { LinkContainer } from 'react-router-bootstrap'
import { browserHistory } from 'react-router'
import axios from 'utils/axios'
import url from 'utils/url'
import VideoCard from 'components/VideoCard'
import _ from 'lodash'

export class Search extends Component {

  constructor(props) {
    super(props)
    this.state = {
      tags: '',
      orderBy: 'name',
      orderMethod: 'asc',
    }
  }

  static propTypes = {
    user : PropTypes.object,
    videos : PropTypes.array,
    searchVideos: PropTypes.func,
  }

  componentDidMount() {
    if (!this.props.user) {
      browserHistory.push('/')
    } else {
      this.searchVideos()
    }
  }

  componentDidUpdate(prevProps) {
    if (this.props.location.query.q != prevProps.location.query.q || this.props.location.query.page != prevProps.location.query.page) {
      this.searchVideos()
    }
  }

  searchVideos = () => {
    const query = this.props.location.query.q || ''
    const page = this.props.location.query.page || 1
    this.props.searchVideos(query, page)
  }

  render() {
    const query = this.props.location.query.q || ''
    const { prevPage, nextPage } = this.props
    const videos = this.state.tags.length > 0 ?
                   this.props.videos.filter(video => video.tags.some(tag => this.state.tags.split(',').includes(tag.name)))
                   : this.props.videos
    return (
      <div className="container">
        <div style={{marginBottom: '10px'}}>
          <span>Order by </span>
          <Button onClick={e => this.setState({orderBy: 'name'})}>Name</Button>
          <Button onClick={e => this.setState({orderBy: 'length'})}>Duration</Button>
        </div>
        <div style={{marginBottom: '10px'}}>
          <span>Order method </span>
          <Button onClick={e => this.setState({orderMethod: 'asc'})}>Asc</Button>
          <Button onClick={e => this.setState({orderMethod: 'desc'})}>Desc</Button>
        </div>
        <div style={{marginBottom: '10px'}}>
          <span>Live filter by tags</span>
          <div style={{ display: 'flex' }}>
            <FormControl
              label="tags"
              type="text"
              placeholder="comma separated tags"
              value={this.state.tags}
              onChange={e => this.setState({tags: e.target.value})}
            />
          </div>
        </div>

        {videos && _.orderBy(videos, this.state.orderBy, this.state.orderMethod).map(video => (
          <VideoCard
            title={video.name}
            description={video.description}
            id_video={video.id_video}
            tags={video.tags}
            length={video.length}
            username={video.username}
          />
        ))}
        <Pager>
          {prevPage &&
            <LinkContainer to={url('/search')} query={{q: query, page: prevPage}} >
              <Pager.Item>Previous</Pager.Item>
            </LinkContainer>
          }
          {nextPage &&
            <LinkContainer to={url('/search')} query={{q: query, page: nextPage }} >
              <Pager.Item>Next</Pager.Item>
            </LinkContainer>
          }
        </Pager>
      </div>
    )
  }
}

export default Search
