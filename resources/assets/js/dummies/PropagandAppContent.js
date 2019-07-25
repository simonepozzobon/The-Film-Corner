const subsPics = [
    {
        id: 1,
        title: 'Condottieri',
        thumb: '/img/grafica/propaganda/condottieri.jpg',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 2,
        title: 'Lo squadrone bianco',
        thumb: '/img/grafica/propaganda/camicia-nera.jpg',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 3,
        title: 'Vecchia guardia',
        thumb: '/img/grafica/propaganda/lo-squadrone-bianco.jpg',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }
]

const subsTexts = [
    {
        id: 1,
        title: 'Technical informations',
        type: 'text',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 2,
        title: 'Abstract/description',
        type: 'text',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 3,
        title: 'Historical context',
        type: 'text',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 4,
        title: 'Food for thoughts',
        type: 'text',
        description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
    }, {
        id: 5,
        title: 'Paratexts',
        hasChildren: true,
        childrens: [
            {
                id: 1,
                title: 'Pics',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                type: 'gallery',
                medias: subsPics,
            }, {
                id: 2,
                title: 'Paintings',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                type: 'gallery',
                medias: subsPics,
            }, {
                id: 3,
                title: 'Books',
                type: 'text',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            }, {
                id: 4,
                title: 'Articles',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                type: 'gallery',
                medias: subsPics,
            }, {
                id: 5,
                title: 'Posters',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                type: 'gallery',
                medias: subsPics,
            }, {
                id: 6,
                title: 'Music',
                type: 'text',
                description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            },
        ]
    }
]

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
        image: images[0],
        subs: subsTexts,
        video: '/video/dottor-churkill.mp4',
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
        image: images[2],
        subs: subsTexts,
        video: '/video/dottor-churkill.mp4',
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
        image: images[1],
        subs: subsTexts,
        video: '/video/dottor-churkill.mp4',
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
        image: images[0],
        subs: subsTexts,
        video: '/video/dottor-churkill.mp4',
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

export {
    movies,
    subsTexts
}
