const fields = [{
        title: 'Apps',
        value: 'apps',
        options: [{
                title: 'title',
                type: 'input'
            },
            {
                title: 'description',
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
        options: [{
                title: 'name',
                type: 'input',
            },
            {
                title: 'description',
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
        options: [{
                title: 'name',
                type: 'input'
            },
            {
                title: 'description',
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
        options: [{
                title: 'name',
                type: 'input'
            },
            {
                title: 'description',
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
        options: [{
            title: 'description',
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
        options: [{
                title: 'title',
                type: 'input'
            },
            {
                title: 'description',
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
        options: [{
                title: 'title',
                type: 'input'
            },
            {
                title: 'description',
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
        options: [{
                title: 'name',
                type: 'input'
            },
            {
                title: 'location',
                type: 'input'
            },
            {
                title: 'description',
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
]

export default fields
