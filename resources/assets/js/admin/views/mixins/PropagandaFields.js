const PropagandaFields = {
    data: function () {
        return {
            fields: [{
                    key: 'id',
                    label: 'ID',
                    sortable: true,
                },
                {
                    key: 'video',
                    label: 'Clip',
                    sortable: true
                },
                {
                    key: 'title',
                    label: 'Titolo',
                    sortable: true
                },
                {
                    key: 'period',
                    label: 'Periodo',
                    sortable: true
                },
                {
                    key: 'tools',
                    label: 'Tools',
                },
            ],
        }
    },
}

export default PropagandaFields
