import React from 'react'
import PlayersContainer from './PlayersContainer'

class BattleContainer extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      players: [],
      currentTurn: null,
      messages: ['battle initialised']
    }
  }

  initialise () {
    for (let i = 0; i < this.props.players.length; i++) {
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
            // Get players
            this.state.players.push(result.data)
            this.state.players.sort(function(a, b) {
              let keyA = a.speed
              let keyB = b.speed

              if (keyA > keyB) return -1
              if (keyA < keyB) return 1
              return 0
            })

            if (this.currentTurn == null) {
              this.setState({
                currentTurn: this.state.players[0].id
              })
            }
          }
        )
    }
  }

  nextTurn () {
    // Get the player from the last turn
    const lastPlayer = this.state.players.find(x => x.id === this.state.currentTurn)
    
    // Get the index from the last player
    let lastPlayerIndex = this.state.players.indexOf(lastPlayer)
    
    // Set the next player
    let NextPlayerFound = false
    for (;NextPlayerFound == false;) {
      lastPlayerIndex++
      // If the player is the last one in this.state.players, go back to index 0
      if (lastPlayerIndex >= this.state.players.length - 1) {
        lastPlayerIndex = 0
      }

      // If the player has 0 HP, skip
      if (this.state.players[lastPlayerIndex].currenthitpoints <= 0) {
        lastPlayerIndex++
      }
      // Else set the new player
      else {
        this.setState({
          currentTurn: this.state.players[lastPlayerIndex].id
        })
        NextPlayerFound = true
        this.state.messages.push(this.state.players[lastPlayerIndex]+'\'s turn')
      }
    }
  }

  attack() {
    
  }

  componentDidMount() {
    if (this.state.players.length == 0) {
      this.initialise()
    }
  }

  render () {
    return (
      <div className="battlecontainer">
        <PlayersContainer players={this.state.players} currentTurn={this.state.currentTurn}/>
      </div>
    )
  }
}

export default BattleContainer
