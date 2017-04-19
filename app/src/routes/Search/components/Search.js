import React, { Component, PropTypes } from 'react'
import { Row, Col, Jumbotron, Pager } from 'react-bootstrap'
import { LinkContainer } from 'react-router-bootstrap'
import axios from 'utils/axios'
import url from 'utils/url'
import VideoCard from 'components/VideoCard'

export class Search extends Component {

  static propTypes = {
    user : PropTypes.object,
    videos : PropTypes.array,
    searchVideos: PropTypes.func,
  }

  componentDidMount() {
    this.searchVideos()
  }

  componentDidUpdate() {
    this.searchVideos()
  }

  searchVideos = () => {
    const query = this.props.location.query.q || ''
    const page = this.props.location.query.page || 1
    this.props.searchVideos(query, page)
  }

  render() {
    const query = this.props.location.query.q || ''
    const { videos, prevPage, nextPage } = this.props
    return (
      <div className="container">
        {videos && videos.map(video => (
          <VideoCard
            title={video.name}
            description={video.description}
            id_video={video.id_video}
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
