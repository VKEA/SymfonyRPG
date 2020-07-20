import React from 'react'

class BattleContainer extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      player: null
    }
  }

  componentDidMount() {
    fetch("/battle/api/get/player", {
      method: 'POST',
      mode: 'cors',
      cache: 'no-cache',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json'
      },
      redirect: 'follow',
      referrerPolicy: 'no-referrer',
      body: JSON.stringify({
        id: '1'
      })
    })
      .then(res => res.json())
      .then(
        (result) => {
          console.log(result.data)
          this.setState({
            player: result.data
          })
        }
      )
  }

  render () {
    if (this.state.player !== null) {
      return (
        <div className="battlecontainer">
          {this.state.player.username}
        </div>
      )
    }
    else {
      return (
        <div className="battlecontainer">
          initialising battle
        </div>
      )
    }
  }
}

export default BattleContainer
