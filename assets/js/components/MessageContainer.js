import React from 'react'

class MessageContainer extends React.Component {
  constructor(props) {
    super(props)
  }

  render () {
    let messages = ''
    for (let i = 0; i < this.props.messages.length; i++) {
      messages = (
        <>
          {messages}
          {this.props.messages[i]}<br />
        </>
      )
    }

    return (<div className="messagecontainer">
      {messages}
    </div>)
  }
}

export default MessageContainer