import React from 'react'

class BattleContainer extends React.Component {
  constructor(props) {
    super(props)
    this.state = {
      players: [],
      currentTurn: null
    }
  }

  initialise () {
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

            console.log (this.state)
            this.forceUpdate()
          }
        )
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
    // Check if players are loaded in
    if (this.state.players.length > 0) {

      let playerContainers = ''
      let playerContainerClasses = 'playercontainer'
      for (let i = 0; i < this.state.players.length; i++) {

        playerContainerClasses = 'playercontainer'
        if (this.state.currentTurn == this.state.players[i].id) {
          playerContainerClasses = playerContainerClasses + ' playercontainer--current playercontainer--damaged'
        }
        if (this.state.players[i].currenthitpoints < (this.state.players[i].hitpoints/10)) {
          playerContainerClasses = playerContainerClasses + ' playercontainer--damaged'
        }

        playerContainers = (
        <>
          {playerContainers}
          <div className={playerContainerClasses} id={this.state.players[i].id}>
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
