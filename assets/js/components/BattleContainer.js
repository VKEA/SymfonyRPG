import React from 'react'
import PlayersContainer from './PlayersContainer'
import MessageContainer from './MessageContainer'
import Controls from './Controls'

class BattleContainer extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      players: [],
      currentTurn: null,
      messages: [],
      action: {
        type: {
          prop: null,
          loaded: false,
          selected: false
        },
        item: {
          prop: null,
          loaded: false,
          selected: false
        },
        target: {
          prop: null,
          loaded: false,
          selected: false
        },
      },
      options: []
    }
  }

  initialise () {
    for (let i = 0; i < this.props.players.length; i++) {
      fetch('/battle/api/get/player', {
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

          this.setState({
            currentTurn: this.state.players[0].id,
            phase: 'item'
          })

          if (this.props.players.length == this.state.players.length) {
            this.state.messages.push('Battle initialised!')
            this.state.messages.push(this.state.players[0].username + '\'s turn!')
            console.log(this.state)
          }

          this.forceUpdate()
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
        this.state.messages.push(this.state.players[lastPlayerIndex]+'\'s turn!')
      }
    }
  }

  setOptions () {
    let tempAction = this.state.action
    if (this.state.action.type.selected == false) {
      tempAction.type.loaded = true
      this.setState({
        list: ['attack', 'item', 'skip'],
        action: tempAction
      })
    }
    else if (this.state.action.item.selected == false) {
      let url = ''
      switch (this.state.action.type) {
        case 'weapon':
          url = '/battle/api/get/weapons'
          break
        case 'item':
          url = '/battle/api/get/items'
          break
      }
      fetch(url, {
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
          id: this.state.currentTurn
        })
      })
      .then(res => res.json())
      .then(
        (result) => {
          tempAction.item.loaded = true
          this.setState({
            list: result,
            action: tempAction
          })
        }
      )
    }
    else if (this.state.action.target.selected == false) {
      tempAction.target.loaded = true
      this.setState({
        list: this.props.players,
        action: tempAction
      })
    }
  }

  clearOptions () {
    this.setState({
      action: {
        type: {
          prop: null,
          loaded: false,
          selected: false
        },
        item: {
          prop: null,
          selected: false
        },
        target: {
          prop: null,
          selected: false
        },
      }
    })
  }

  executeAction() {
    
  }

  componentDidMount() {
    if (this.state.players.length == 0) {
      this.initialise()
    }
    if (this.state.phase == null) {
      this.setOptions()
    }
  }

  render () {
    return (
      <div className="battlecontainer">
        <PlayersContainer players={this.state.players} currentTurn={this.state.currentTurn}/>
        <MessageContainer messages={this.state.messages}/>
        <main>
          <Controls list={this.state.list}/>
        </main>
        <footer>&copy; Verbond van Klei-etende Autisten 2020</footer>
      </div>
    )
  }
}

export default BattleContainer
