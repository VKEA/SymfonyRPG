import React from 'react'
import ReactDOM from 'react-dom'
import '../css/Battle.css'

import BattleContainer from './components/BattleContainer'

ReactDOM.render(
  <React.StrictMode>
    <BattleContainer />
  </React.StrictMode>,
  document.getElementById('root')
)

serviceWorker.unregister()