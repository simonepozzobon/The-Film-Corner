<template lang="html">
    <div class="panel">
        <div class="reset-filters">
            <a href="#" @click="resetFilters" class="btn btn-green">Reset Filters</a>
        </div>
        <div class="list-items">
            <div class="filters">
                <div class="filter thumb">Thumb</div>
                <div class="filter title">Title</div>
                <div class="filter author">
                    <div class="text" ref="authorLabel" @click="showAuthorFilt">
                        <i class="fa fa-filter" v-if="authorFiltered"></i>
                        {{ author }}
                    </div>
                    <div class="input" ref="authorFilter">
                        <input type="text" v-model="author" class="form-control" @keydown.enter="hideAuthorFilt">
                        <i class="fa fa-times" @click="hideAuthorFilt"></i>
                    </div>
                </div>
                <div class="filter app">
                    <select class="form-control" v-model="appName">
                        <option value="0">App Name</option>
                        <option value="16">Lumière Minute</option>
                        <option value="17">Make Your Own film</option>
                    </select>
                </div>
                <div class="filter date">
                    <i :class="'fa '+dateSortClass" @click="sortingDate"></i>
                    <span @click="sortingDate">Date</span>
                </div>
            </div>
            <single-item v-for="session in results" :key="session.token" :session="session"></single-item>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import _ from 'lodash'
import {TimelineMax} from 'gsap'
import SingleItem from './SingleItem.vue'

export default {
    name: 'list',
    components: {
        SingleItem,
    },
    data: function() {
        return {
            appName: 0,
            author: 'Author',
            authorFiltered: false,
            dateSort: null,
            dateSortOpts: [null, 'desc', 'asc'],
            sessions: [],
            results: [],
            resultsFiltered: [],
        }
    },
    watch: {
        appName: function(filter) {
            if (filter > 0) {
                var filtered = this.sessions.filter(session => {
                    return session.app.id == filter
                })
                this.results = filtered
            } else {
                this.results = this.sessions
            }
        },
        author: function(string) {
            if (string.length > 3 && string != 'Author') {
                var filtered = this.sessions.filter(session => {
                    return session.teacher.name.includes(string) || session.teacher.email.includes(string)
                })
                this.results = filtered
                this.authorFiltered = true
            } else if (string == '') {
                this.results = this.sessions
                this.authorFilter = false
                this.author = 'Author'
            } else {
                this.results = this.sessions
                this.authorFiltered = false
            }
        },
        dateSort: function(sorting) {
            if (sorting == 'asc') {
                this.results = _.orderBy(this.sessions, session => {
                    return session.created_at
                }, ['asc'])
            } else if (sorting == 'desc') {
                this.results = _.orderBy(this.sessions, session => {
                    return session.created_at
                }, ['desc'])
            } else {
                this.results = this.sessions
            }
        }
    },
    computed: {
        dateSortClass: function() {
            if (this.dateSort == 'asc') {
                return 'fa-caret-up'
            } else if (this.dateSort == 'desc') {
                return 'fa-caret-down'
            } else {
                return ''
            }
        }
    },
    methods: {
        getContest: function() {
            axios.get('/api/v1/get-contest').then(response => {
                this.sessions = this.results = this.resultsFiltered = response.data
            })
        },
        showAuthorFilt: function() {
            var t1 = new TimelineMax()
            t1.to(this.$refs.authorLabel, .2, {
                    display: 'none'
                })
                .to(this.$refs.authorFilter, .2, {
                    display: 'flex'
                })
        },
        hideAuthorFilt: function() {
            var t1 = new TimelineMax()
            t1.to(this.$refs.authorFilter, .2, {
                    display: 'none'
                })
                .to(this.$refs.authorLabel, .2, {
                    display: 'block'
                })
        },
        sortingDate: function() {
            var index = this.dateSortOpts.indexOf(this.dateSort)
            if (index < (this.dateSortOpts.length - 1) && index > -1) {
                this.dateSort = this.dateSortOpts[index + 1]
            } else {
                this.dateSort = null
            }
        },
        resetFilters: function(e) {
            e.preventDefault()
            this.appName = 0
            this.author = 'Author'
            this.results = this.sessions
        }
    },
    mounted: function() {
        this.getContest()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

    .panel {
        > .reset-filters {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: $spacer;
        }

        .list-items {
            display: table;
            width: 100%;

            > .filters {
                display: table-row;

                > .filter {
                    display: table-cell;
                    padding-right: $spacer;
                    font-weight: bold;
                }

                > .author {
                    > .input {
                        display: none;
                        justify-content: space-between;
                        align-items: center;

                        > i {
                            padding-left: $spacer / 2;
                            cursor: pointer;
                        }
                    }
                }

                > .date {
                    > i, > span {
                        cursor: pointer;
                    }
                }
            }
        }
    }


</style>
