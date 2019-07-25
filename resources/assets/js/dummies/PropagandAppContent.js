const images = [
    {
        id: 1,
        thumb: '/img/grafica/propaganda/condottieri.jpg'
    }, {
        id: 2,
        thumb: '/img/grafica/propaganda/camicia-nera.jpg'
    }, {
        id: 3,
        thumb: '/img/grafica/propaganda/lo-squadrone-bianco.jpg'
    }
]

const generalAttributes = [
    {
        id: 1,
        name: 'format',
        value: '4:3'
    }, {
        id: 2,
        name: 'colors',
        value: 'B/N'
    }, {
        id: 3,
        name: 'audio',
        value: 'Mute'
    }, {
        id: 4,
        name: 'version',
        value: 'V.o.'
    }, {
        id: 5,
        name: 'subtitles',
        value: 'sott.it'
    }
]

const tags = [
    {
        id: 1,
        title: 'Guerra-propaganda'
    }
]

const movies = [
    {
        id: 1,
        title: 'Condottieri',
        title_original: null,
        year: '1937',
        director: 'Luis Trenker',
        country: 'Italy',
        duration: '100',
        description: '',
        tags: tags,
        attributes: generalAttributes,
        image: images[0]
    }, {
        id: 2,
        title: 'Lo squadrone bianco',
        title_original: null,
        year: '1936',
        director: 'Augusto Genina',
        country: 'Italia',
        duration: null,
        description: '',
        tags: tags,
        attributes: generalAttributes,
        image: images[2]
    }, {
        id: 3,
        title: 'Camicia nera',
        title_original: null,
        year: '1933',
        director: 'Giovacchino Forzano',
        country: 'Italia',
        duration: '100',
        description: '',
        tags: tags,
        attributes: generalAttributes,
        image: images[1]
    }, {
        id: 4,
        title: 'Vecchia guardia',
        title_original: null,
        year: '1934',
        director: 'Alessandro Blasetti',
        country: 'Italia',
        duration: '100',
        description: '',
        tags: tags,
        attributes: generalAttributes,
        image: images[0]
    }
]

const channels = [
    {
        id: 1,
        period: '1917',
        color: 'red',
        label: 'Russian Revolution',
        contents: []
    }, {
        id: 2,
        period: '1922-1945',
        color: 'orange',
        label: 'Fascism and Nazism',
        contents: []
    }, {
        id: 3,
        period: '1939-1945',
        color: 'green-var',
        label: 'Second World War',
        contents: movies
    }, {
        id: 4,
        period: '1946-1990',
        color: 'teal',
        label: 'Cold war',
        contents: []
    }
]

export default channels
