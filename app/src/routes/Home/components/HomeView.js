import React from 'react'
import './HomeView.scss'
import { Row, Col, Jumbotron } from 'react-bootstrap'

export const HomeView = (props) => {
    if (props.user) {
      return (
        <div className="container">
          <Jumbotron>
            <h1>Introducing You2</h1>
          </Jumbotron>
        </div>
      )
    }

    return (
      <div className="container">
        <Jumbotron>
          <h1>Introducing You2</h1>
          <p>Absolutely nothing like youtube</p>
          <p>Im serious</p>
          <ul>
            <li>You have to create an account to do stuff</li>
            <li>You can upload videos of you being... you</li>
            <li>You can comment on other people videos</li>
            <li>You can (dis)like videos</li>
            <li>If you want something else GTFO to youtube</li>
          </ul>
          <p>And once again in totally default bootstrap</p>
        </Jumbotron>
      </div>
    )
}

export default HomeView
