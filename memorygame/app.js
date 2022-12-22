document.addEventListener('DOMContentLoaded', () => {
  //card options
  const cardArray = [
    {
      name: 'fries',
      img: 'images/3039523.png'
    },
    {
      name: 'cheeseburger',
      img: 'images/3868690.png'
    },
    {
      name: 'ice-cream',
      img: 'images/811683.png'
    },
    {
      name: 'pizza',
      img: 'images/vyprvpn-homepage-hero-banner-refresh-2021.png'
    },
    {
      name: 'milkshake',
      img: 'images/2687854.png'
    },
    {
      name: 'hotdog',
      img: 'images/421648.png'
    },
    {
      name: 'fries',
      img: 'images/Antivirus.png'
    },
    {
      name: 'cheeseburger',
      img: 'images/biometrico.png'
    },
    {
      name: 'ice-cream',
      img: 'images/firewall.png'
    },
    {
      name: 'pizza',
      img: 'images/vpn.png'
    },
    {
      name: 'milkshake',
      img: 'images/control-de-acceso.png'
    },
    {
      name: 'hotdog',
      img: 'images/contrasena.png'
    }
  ]

  cardArray.sort(() => 0.5 - Math.random())

  const grid = document.querySelector('.grid')
  const resultDisplay = document.querySelector('#result')
  let cardsChosen = []
  let cardsChosenId = []
  let cardsWon = []

  //create your board
  function createBoard() {
    for (let i = 0; i < cardArray.length; i++) {
      const card = document.createElement('img')
      card.setAttribute('src', 'images/card-mo.png')
      card.setAttribute('data-id', i)
      card.addEventListener('click', flipCard)
      grid.appendChild(card)
    }
  }

  //check for matches
  function checkForMatch() {
    const cards = document.querySelectorAll('img')
    const optionOneId = cardsChosenId[0]
    const optionTwoId = cardsChosenId[1]
    
    if(optionOneId == optionTwoId) {
      cards[optionOneId].setAttribute('src', 'images/card-mo.png')
      cards[optionTwoId].setAttribute('src', 'images/card-mo.png')
      alert('¡Has hecho clic en la misma imagen!')
    }
    else if (cardsChosen[0] === cardsChosen[1]) {
      alert('Encontraste una coincidencia!')
      cards[optionOneId].setAttribute('src', 'images/white.png')
      cards[optionTwoId].setAttribute('src', 'images/white.png')
      cards[optionOneId].removeEventListener('click', flipCard)
      cards[optionTwoId].removeEventListener('click', flipCard)
      cardsWon.push(cardsChosen)
    } else {
      cards[optionOneId].setAttribute('src', 'images/card-mo.png')
      cards[optionTwoId].setAttribute('src', 'images/card-mo.png')
      alert('Lo sentimos, intente de nuevo')
    }
    cardsChosen = []
    cardsChosenId = []
    resultDisplay.textContent = cardsWon.length
    if  (cardsWon.length === cardArray.length/2) {
      resultDisplay.textContent = '¡Felicidades! ¡Has encontrado todas las piezas!'
    }
  }

  //flip your card
  function flipCard() {
    let cardId = this.getAttribute('data-id')
    cardsChosen.push(cardArray[cardId].name)
    cardsChosenId.push(cardId)
    this.setAttribute('src', cardArray[cardId].img)
    if (cardsChosen.length ===2) {
      setTimeout(checkForMatch, 500)
    }
  }

  createBoard()
})
