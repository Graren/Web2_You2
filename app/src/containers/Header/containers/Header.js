import React, { Component, PropTypes } from 'react'
import { IndexLink } from 'react-router'
import { LinkContainer } from 'react-router-bootstrap'

import {
  Navbar,
  Nav,
  NavDropdown,
  FormGroup,
  Button,
  ControlLabel,
  FormControl
} from 'react-bootstrap'
import { connect } from 'react-redux'

import './Header.scss'
import url from 'utils/url'
import UserActions from 'store/user'
import Header from './../components/Header'

export class HeaderContainer extends Component {
  constructor (props) {
    super(props)
    this.state = {
      email: 'admin1@gmail.com',
      password: '12345678',
      username: 'admin',
      isAuthDropdownOpen: false
    }
  }

  static propTypes = {
    login: PropTypes.func,
    signout: PropTypes.func,
    user: PropTypes.object
  }

  static defaultProps = {
    email: 'admin',
    password: '12345678',
    isAuthDropdownOpen: false
  }

  componentWillReceiveProps (nextProps) {
    if (nextProps.user !== this.props.user) {
      this.setState({
        isAuthDropdownOpen: false,
        isSignupDropdownOpen: false
      })
    }
  }

  onAuthDropdownToggle = (isOpen, e) => {
    if (e.target.tagName !== 'REACT') {
      this.setState({
        isAuthDropdownOpen: isOpen
      })
    }
  }

  onSignupDropdownToggle = (isOpen, e) => {
    if (e.target.tagName !== 'REACT') {
      this.setState({
        isSignupDropdownOpen: isOpen
      })
    }
  }

  onEmailChange = e => {
    this.setState({
      email: e.target.value
    })
  }

  onUsernameChange = e => {
    this.setState({
      username: e.target.value
    })
  }

  onPasswordChange = e => {
    this.setState({
      password: e.target.value
    })
  }

  renderAuthDropdown = () => {
    const { isAuthDropdownOpen, email, password } = this.state

    return (
      <NavDropdown
        eventKey={3}
        title="Sign In"
        id="auth-dropdown"
        open={isAuthDropdownOpen}
        onToggle={this.onAuthDropdownToggle}
      >
        <Navbar.Form>
          <FormGroup controlId="formHorizontalEmail">
            <ControlLabel>Email</ControlLabel>
            <FormControl
              type="email"
              placeholder="Email"
              onChange={this.onEmailChange}
              value={email}
            />
          </FormGroup>

          <FormGroup controlId="formHorizontalPassword">
            <ControlLabel>Password</ControlLabel>
            <FormControl
              type="password"
              placeholder="Password"
              onChange={this.onPasswordChange}
              value={password}
            />
          </FormGroup>

          <FormGroup className="login-btn">
            <Button
              type="submit"
              onClick={() => this.props.login(email, password)}
            >
              Sign in
            </Button>
          </FormGroup>
        </Navbar.Form>
      </NavDropdown>
    )
  }

  renderSignupDropdown = () => {
    const { isSignupDropdownOpen, email, password, username } = this.state

    return (
      <NavDropdown
        eventKey={3}
        title="Sign Up"
        id="auth-dropdown"
        open={isSignupDropdownOpen}
        onToggle={this.onSignupDropdownToggle}
      >
        <Navbar.Form>
          <FormGroup controlId="formHorizontalEmail">
            <ControlLabel>Username</ControlLabel>
            <FormControl
              type="text"
              placeholder="Username"
              onChange={this.onUsernameChange}
              value={username}
            />
          </FormGroup>

          <FormGroup controlId="formHorizontalEmail">
            <ControlLabel>Email</ControlLabel>
            <FormControl
              type="email"
              placeholder="Email"
              onChange={this.onEmailChange}
              value={email}
            />
          </FormGroup>

          <FormGroup controlId="formHorizontalPassword">
            <ControlLabel>Password</ControlLabel>
            <FormControl
              type="password"
              placeholder="Password"
              onChange={this.onPasswordChange}
              value={password}
            />
          </FormGroup>

          <FormGroup className="login-btn">
            <Button
              type="submit"
              onClick={() => this.props.signup({ email, password, username })}
            >
              Sign Up
            </Button>
          </FormGroup>
        </Navbar.Form>
      </NavDropdown>
    )
  }

  renderUserDropdown = () => {
    const { isAuthDropdownOpen } = this.state
    const { user } = this.props
    return (
      <NavDropdown
        eventKey={3}
        title={user.username}
        id="user-dropdown"
        open={isAuthDropdownOpen}
        onToggle={this.onAuthDropdownToggle}
      >
        <div className="user-dropdown">
          <Button
            className="logout-btn"
            onClick={this.props.signout}
          >
            Sign Out
          </Button>
          <LinkContainer to={url(`/profile/${user.username}`)}>
          <Button className="logout-btn">
            Profile
          </Button>
        </LinkContainer>

        </div>
      </NavDropdown>
    )
  }

  render () {
    const { user } = this.props

    return (
      <Header
        user={user}
        renderUserDropdown={this.renderUserDropdown}
        renderSignupDropdown={this.renderSignupDropdown}
        renderAuthDropdown={this.renderAuthDropdown}
      />
    )
  }
}

const mapStateToProps = (state) => ({
  user: state.user.user
})

const mapDispatchToProps = (dispatch) => ({
  login: (email, password) => dispatch(UserActions.login(email, password)),
  signup: (user) => dispatch(UserActions.signup(user)),
  signout: () => dispatch(UserActions.signout())
})

export default connect(mapStateToProps, mapDispatchToProps)(HeaderContainer)
