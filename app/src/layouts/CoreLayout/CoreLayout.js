import React from 'react'
import PropTypes from 'prop-types'
import HeaderContainer from '../../containers/Header'
import './CoreLayout.scss'
import '../../styles/core.scss'

export const CoreLayout = ({ children }) => (
  <div>
    <HeaderContainer />
    <div className='core-layout__viewport'>
      {children}
    </div>
  </div>
)

CoreLayout.propTypes = {
  children : PropTypes.element.isRequired
}

export default CoreLayout
