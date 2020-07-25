import React from 'react'

class BattleContainer extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      players: [],
      turn: 0
    }
  }

  initialise() {
    
  }

  componentDidMount() {
    for (let i = 0; i < this.props.players.length; i++) {
      console.log(this.props.players[i])
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
          id: this.props.players[i]
        })
      })
        .then(res => res.json())
        .then(
          (result) => {
            console.log(result.data)
            this.state.players.push(result.data)
            console.log(this.state)
            this.forceUpdate()
          }
        )
    }
  }

  render () {
    // Check if players are loaded in
    if (this.state.players.length > 0) {

      let playerContainers = '';
      for (let i = 0; i < this.state.players.length; i++) {
        playerContainers = (
        <>
          {playerContainers}
          <div className="playercontainer" id={this.state.players[i].id}>
            <div className="playernamecontainer">
              <span className="name">{this.state.players[i].username}</span>
              <span className="level">lvl. {this.state.players[i].level}</span>
            </div>
            <div className="hitpointbar">
              <div className="hitpoints" style={{height: "100%", width: "calc(100% / " + this.state.players[i].hitpoints +" * " + this.state.players[i].currenthitpoints + ")"}}></div>
            </div>
            <div>HP: {this.state.players[i].currenthitpoints}/{this.state.players[i].hitpoints}</div>
          </div>
        </>
        )
      }

      return (
        <div className="battlecontainer">
          <div className="players">
            {playerContainers}
          </div>
        </div>
      )
    }
    else {
      return (
        <div className="battlecontainer">
          initialising battle... Please wait. :)
        </div>
      )
    }
  }
}

export default BattleContainer
