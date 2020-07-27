import React from 'react'

class PlayersContainer extends React.Component {
  constructor(props) {
    super(props)
  }

  render () {
    // Check if players are loaded in
    if (this.props.players.length > 0) {

      let playerContainers = ''
      let playerContainerClasses = 'playercontainer'
      for (let i = 0; i < this.props.players.length; i++) {

        playerContainerClasses = 'playercontainer'
        if (this.props.currentTurn == this.props.players[i].id) {
          playerContainerClasses = playerContainerClasses + ' playercontainer--current'
        }
        if (this.props.players[i].currenthitpoints < (this.props.players[i].hitpoints/10)) {
          playerContainerClasses = playerContainerClasses + ' playercontainer--damaged'
        }

        playerContainers = (
        <>
          {playerContainers}
          <div className={playerContainerClasses} id={this.props.players[i].id}>
            <div className="playernamecontainer">
              <span className="name">{this.props.players[i].username}</span>
              <span className="level">lvl. {this.props.players[i].level}</span>
            </div>
            <div className="hitpointbar">
              <div className="hitpoints" style={{height: "100%", width: "calc(100% / " + this.props.players[i].hitpoints +" * " + this.props.players[i].currenthitpoints + ")"}}></div>
            </div>
            <div>HP: {this.props.players[i].currenthitpoints}/{this.props.players[i].hitpoints}</div>
          </div>
        </>
        )
      }

      return (
        <div className="players">
          {playerContainers}
        </div>
      )
    }
    else {
      return (
        <div className="players">
          initialising battle... Please wait. :)
        </div>
      )
    }
  }
}

export default PlayersContainer