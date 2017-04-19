import React, { PropTypes } from 'react'
import './UserData.scss'
import {
  Row,
  Col,
  Grid,
  Button,
  ButtonGroup,
  Modal
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
              {
                props.allowDelete ?
                  <ButtonGroup>
                    <Button className="delete-btn" bsStyle="danger" onClick={props.onDelete}>Delete</Button>
                </ButtonGroup> :
                <div></div>
              }
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
      <Modal show={props.showModal} onHide={props.close}>
          <Modal.Header closeButton>
            <Modal.Title>BACK THE F UP WE GOT A BAD GUY HERE</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            ARE YOU SURE YOU WANT OUT OF THIS GREATNESS
          </Modal.Body>
          <Modal.Footer>
            <Button onClick={props.close}>No, I love it</Button>
            <Button onClick={props.actualDelete}>Yup</Button>
          </Modal.Footer>
        </Modal>
    </div>
  )
}

UserData.propTypes = {
  onDelete : PropTypes.func,
  actualDelete:PropTypes.func,
  close:PropTypes.func,
  showModal: PropTypes.bool,
  user : PropTypes.Object,
  allowDelete : PropTypes.bool
}

UserData.defaultProps = {
  onDelete: () => {console.log("Deleted")}
}

export default UserData
