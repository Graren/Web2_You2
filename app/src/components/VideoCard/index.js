import React from 'react'
import { Row, Col } from 'react-bootstrap'
import { Link } from 'react-router'
import AspectRatio from 'react-aspect-ratio'
import 'react-aspect-ratio/aspect-ratio.css'
import url from 'utils/url'
import Card from 'components/Card'

const VideoCard = (props) => {
  return (
    <Card>
      <Row>
        <Col xs={4} md={2}>
          <Link to={url(`/video/${props.id_video}`)}>
            <AspectRatio
              ratio="1"
              style={{
                maxWidth: '1000px',
                backgroundImage: `url(http://localhost:8001/W2_You2/api/thumbnail.php?id_video=${props.id_video})`,
                backgroundSize: 'cover'
              }}
            />
          </Link>
        </Col>
        <Col xs={8} md={10}>
          <Link to={url(`/video/${props.id_video}`)}>
            <h2 style={{ marginTop: 0 }}>{props.title}</h2>
          </Link>
          <p>{props.description}</p>
        </Col>
      </Row>
    </Card>
  )
}

export default VideoCard
