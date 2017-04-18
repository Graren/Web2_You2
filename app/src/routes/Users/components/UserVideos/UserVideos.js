import React, { PropTypes } from 'react'
import './UserVideos.scss'
import {
  Col
} from 'react-bootstrap'

const UserVideos = (props) => {
  return (
      <div className="container userVideos">
        {
          props.videos.map((vid,id) => (
            <Col key={id} sm={12}>
              <p>{vid}</p>
            </Col>
          ))
        }
      </div>
  )
}
UserVideos.propTypes = {
  videos : PropTypes.array
}

UserVideos.defaultProps = {
  videos: [
    "CUlos",
    "papos"
  ]
}

export default UserVideos
