import React, { PropTypes } from 'react'
import { IndexLink } from 'react-router'
import { LinkContainer } from 'react-router-bootstrap'
import './Header.scss'
import {
  Navbar,
  Nav,
  FormControl,
  Button,
  NavItem
} from 'react-bootstrap'
import url from '../../../utils/url'

export const Header = (props) => {
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
        <Nav>
          {props.renderSearchBar()}
        </Nav>
        <Nav />
          {props.user ? (
            <Nav pullRight>
              <LinkContainer to={url('/upload')}>
                <NavItem>Upload</NavItem>
              </LinkContainer>
              {props.renderUserDropdown()}
            </Nav>
          ) : (
            <Nav pullRight>
              {props.renderAuthDropdown()}
              {props.renderSignupDropdown()}
            </Nav>
          )}
      </Navbar.Collapse>
    </Navbar>
  )
}

Header.propTypes = {
  renderUserDropdown : PropTypes.func,
  renderSignupDropdown : PropTypes.func,
  renderAuthDropdown : PropTypes.func,
  user : PropTypes.Object
}

export default Header
