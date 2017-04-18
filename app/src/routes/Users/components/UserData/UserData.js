import React from 'react'
import './UserData.scss'
import {
  Row,
  Col,
  Grid
} from 'react-bootstrap'

const UserData = (props) => {
  return (
    <div className="userData">
      <div className="container">
        <Grid>
          <Row className="show-grid">
            <Col sm={6}>
              <h1>{props.user.username}</h1>
            </Col>
            <Col sm={6}>

            </Col>
          </Row>

          <Row className="show-grid">
              <Col sm={6}>
              </Col>
              <Col sm={6} >
                <p>email :{props.user.email}</p>
              </Col>
          </Row>
        </Grid>
      </div>
    </div>
  )
}

export default UserData
