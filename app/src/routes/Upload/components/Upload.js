import React, { Component, PropTypes } from 'react'
import { Row, Col, Jumbotron, FormGroup, FormControl, ControlLabel, Button, HelpBlock } from 'react-bootstrap'
import { LinkContainer } from 'react-router-bootstrap'
import axios from 'utils/axios'
import url from 'utils/url'
import VideoCard from 'components/VideoCard'

export class Search extends Component {

  constructor(props) {
    super(props)
    this.state = {
      file : null,
      description: '',
      tags: '',
      video: null,
    }
  }

  static propTypes = {
    user : PropTypes.object,
  }

  onDescriptionChange = e => {
    this.setState({
      description: e.target.value
    })
  }

  onTagsChange = e => {
    this.setState({
      tags: e.target.value
    })
  }

  upload = () => {
    const { file, description, tags } = this.state
    const fd = new FormData()
    fd.append("file", file)
    fd.append("description", description)
    fd.append("tags", tags)
    fd.append("length", 1)
    return axios.post('api/file.php', fd)
      .then(({data : { data }}) => {
        this.setState({ video: data })
      })
      .catch(error => {
        console.log(error)
      })
  }

  render() {
    return (
      <div className="container">
        {this.state.video ? (
          <Jumbotron>
            <h2>Video Uploaded</h2>
            <VideoCard
              title={this.state.video.name}
              description={this.state.video.description}
              id_video={this.state.video.id_video}
              username={this.state.video.uploader}
            />
            <Button onClick={() => this.setState({ video: null })}>Upload a new one</Button>
          </Jumbotron>
        ) : (
          <Jumbotron>
            <h2>Upload a Video</h2>
            <FormGroup onChange={this.onDescriptionChange} value={this.state.description}>
              <ControlLabel>Description</ControlLabel>
              <FormControl componentClass="textarea" placeholder="Describe the video..." />
            </FormGroup>
            <FormGroup>
              <ControlLabel>Select a video</ControlLabel>
              <FormControl type="file" accept=".mp4,.ogg,.webm" style={{ color: 'transparent' }} onChange = {e => {
                let file = e.target.files[0]
                this.setState({
                  file
                })
              }} />
            </FormGroup>
            <FormGroup onChange={this.onTagsChange} value={this.state.tags}>
              <ControlLabel>Tags</ControlLabel>
              <FormControl label="tags" type="text" placeholder="doge,fun,wow" />
              <HelpBlock>Comma separated tag list</HelpBlock>
            </FormGroup>
            <Button type="submit" value="" onClick={this.upload}>Submit</Button>
          </Jumbotron>
        )}
      </div>
    )
  }

}

export default Search
