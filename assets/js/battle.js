import React from 'react'
import ReactDOM from 'react-dom'
import '../css/Battle.css'

import BattleContainer from './components/BattleContainer'

ReactDOM.render(
  <React.StrictMode>
    <BattleContainer players={['1', '2']}/>
  </React.StrictMode>,
  document.getElementById('root')
)