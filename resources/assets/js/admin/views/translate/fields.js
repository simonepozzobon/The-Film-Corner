let fields = [{
        title: 'Apps',
        value: 'apps',
        model: 'AppTranslation',
        options: [{
                title: 'title',
                label: 'Titolo',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            },
        ],
        fields: [{
                key: 'title',
                label: 'Titolo',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Glossary',
        value: 'app_keywords',
        model: 'AppKeywordTranslation',
        options: [{
                title: 'name',
                type: 'input',
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'name',
                label: 'Nome',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Studios',
        value: 'app_sections',
        model: 'AppSectionTranslation',
        options: [{
                title: 'name',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'name',
                label: 'Nome',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Didactical Path',
        value: 'app_categories',
        model: 'AppCategoryTranslation',
        options: [{
                title: 'name',
                label: 'Nome',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'name',
                label: 'Nome',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'General Texts',
        value: 'general_texts',
        model: 'GeneralTextTranslation',
        options: [{
            title: 'description',
            label: 'Descrizione',
            type: 'textarea'
        }],
        fields: [{
                key: 'description',
                label: 'Descrizione',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Captions',
        value: 'captions',
        model: 'CaptionTranslation',
        options: [{
                title: 'title',
                label: 'Titolo',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'title',
                label: 'Titolo',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Filmography',
        value: 'filmographies',
        model: 'FilmographyTranslation',
        options: [{
                title: 'title',
                label: 'Titolo',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'title',
                label: 'Titolo',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Partners',
        value: 'partners',
        model: 'PartnerTranslation',
        options: [{
                title: 'name',
                label: 'Nome',
                type: 'input'
            },
            {
                title: 'location',
                type: 'input'
            },
            {
                title: 'description',
                label: 'Descrizione',
                type: 'textarea'
            }
        ],
        fields: [{
                key: 'name',
                label: 'Nome',
            },
            {
                key: 'location',
                label: 'Luogo',
            },
            {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ],
    },
    {
        title: 'Propaganda App Esercizi',
        value: 'exercises',
        model: 'Propaganda\\ExerciseTranslation',
        options: [{
            title: 'title',
            label: 'Titolo',
            type: 'input',
        }, {
            title: 'description',
            label: 'Descrizione',
            type: 'textarea',
        }],
        fields: [{
                key: 'title',
                label: 'Titolo',
            }, {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ]
    },
    {
        title: 'Propaganda App Challenges',
        value: 'challenges',
        model: 'Propaganda\\ChallengeTranslation',
        options: [{
            title: 'title',
            label: 'Titolo',
            type: 'input',
        }, {
            title: 'description',
            label: 'Descrizione',
            type: 'textarea',
        }],
        fields: [{
                key: 'title',
                label: 'Titolo',
            }, {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ]
    },
]

const values = [{
        title: 'Propaganda App Periodo',
        value: 'propaganda_period',
        model: 'Propaganda\\PeriodTranslation',
    },
    {
        title: 'Propaganda App Regista',
        value: 'propaganda_director',
        model: 'Propaganda\\DirectorTranslation',
    },
    {
        title: 'Propaganda App Interpreti',
        value: 'propaganda_people',
        model: 'Propaganda\\PeopleTranslation',
    },
    {
        title: 'Propaganda App Formato',
        value: 'propaganda_format',
        model: 'Propaganda\\FormatTranslation',
    },
    {
        title: 'Propaganda App Genere',
        value: 'propaganda_genre',
        model: 'Propaganda\\GenreTranslation',
    },
    {
        title: 'Propaganda App Nazionalità',
        value: 'propaganda_country',
        model: 'Propaganda\\CountryTranslation',
    },
    {
        title: 'Propaganda App Argomento',
        value: 'propaganda_topic',
        model: 'Propaganda\\TopicTranslation',
    },
]

for (let i = 0; i < values.length; i++) {
    let current = values[i]
    let newObj = {
        title: current.title,
        value: current.value,
        model: current.model,
        options: [{
            title: 'title',
            label: 'Titolo',
            type: 'input',
        }],
        fields: [{
                key: 'title',
                label: 'Titolo',
            }, {
                key: 'languages',
                label: 'Stato Traduzione',
                sortable: true,
            },
            {
                key: 'tools',
                label: '',
            },
        ]
    }


    if (current.value == 'propaganda_director') {
        newObj = {
            ...newObj,
            options: [{
                title: 'name',
                label: 'Nome',
                type: 'input',
            }],
            fields: [{
                    key: 'name',
                    label: 'Nome',
                }, {
                    key: 'languages',
                    label: 'Stato Traduzione',
                    sortable: true,
                },
                {
                    key: 'tools',
                    label: '',
                },
            ]
        }
    }


    fields.push(newObj)
}
export default fields
