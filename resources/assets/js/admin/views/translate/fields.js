const fields = [{
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

export default fields
