import React from 'react'
import ReactDOM from 'react-dom'
import './index.css'
import Battle from './Battle'
import * as serviceWorker from './serviceWorker'

ReactDOM.render(
  <React.StrictMode>
    <Battle />
  </React.StrictMode>,
  document.getElementById('root')
)

serviceWorker.unregister()
