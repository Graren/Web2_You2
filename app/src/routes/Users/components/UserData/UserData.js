import React from 'react'
import './UserData.scss'
import {
  Row,
  Col,
} from 'react-bootstrap'

const UserData = (props) => {
  return (
    <div className="userData">
      <div className="container">
        <Row>
          <Col sm={6}>
            <h1>{props.user.username}</h1>
          </Col>
        </Row>
        <Row>
            <Col sm={6}>
              <p>id :{props.user.id_user}</p>
            </Col>
            <Col sm={6}>
              <p>email :{props.user.email}</p>
            </Col>
        </Row>
      </div>
    </div>
  )
}

export default UserData
