import React from 'react'

class Controls extends React.Component {
  constructor(props) {
    super(props)
  }

  render () {
    let controls = ''
    if (this.props.list !== undefined) {
      for (let i = 0; i < this.props.list.length; i++) {
        controls = (
          <>
            {controls}
            <button>{this.props.list[i]}</button>
          </>
        )
      }
    }

    return (<div className="controls">
      {controls}
    </div>)
  }
}

export default Controls