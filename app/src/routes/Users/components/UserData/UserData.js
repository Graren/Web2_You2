import React, { PropTypes } from 'react'
import './UserData.scss'
import {
  Row,
  Col,
  Grid,
  Button,
  ButtonGroup
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
            <Col sm={6} style={{textAlign:'center'}}>
              <ButtonGroup>
                <Button className="edit-btn" bsStyle="info" onClick={props.onEdit}>Edit</Button>
                <Button className="delete-btn" bsStyle="danger" onClick={props.onDelete}>Delete</Button>
            </ButtonGroup>
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

UserData.propTypes = {
  onDelete : PropTypes.func,
  onEdit : PropTypes.func,
  user : PropTypes.Object
}

UserData.defaultProps = {
  onDelete: () => {console.log("Deleted")},
  onEdit:  () => {console.log("Edit")}
}

export default UserData
