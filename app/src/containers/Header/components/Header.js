import React, { PropTypes } from 'react'
import { IndexLink } from 'react-router'
import './Header.scss'
import {
  Navbar,
  Nav
} from 'react-bootstrap'
import url from '../../../utils/url'

export const Header = (props) => {
  console.log(props)
  return (
    <Navbar inverse collapseOnSelect>
      <Navbar.Header>
        <Navbar.Brand>
          <IndexLink to={url('/')}>
            You2
          </IndexLink>
        </Navbar.Brand>
        <Navbar.Toggle />
      </Navbar.Header>
      <Navbar.Collapse>
        <Nav />
        <Nav pullRight>
          {props.user ? (
            props.renderUserDropdown()
          ) : (
            props.renderAuthDropdown()
          )}
        </Nav>
      </Navbar.Collapse>
    </Navbar>
  )
}

Header.propTypes = {
  renderUserDropdown : PropTypes.func,
  renderAuthDropdown : PropTypes.func,
  user : PropTypes.Object
}

export default Header
