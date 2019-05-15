<template lang="html">
    <ui-container class="teacher-profile" :contain="true">
        <ui-row
            :no-gutters="false">
            <ui-block
                :size="8">
                <ui-block-head
                    class="teacher-profile__activities"
                    :size="12"
                    title="Activities"
                    color="orange"
                    :radius="true">
                    <pro-activity
                        v-for="(activity, i) in activities"
                        :key="activity.id"
                        :counter="i"
                        :idx="activity.id"
                        :name="activity.user.name"
                        :app="activity.app.title"/>
                </ui-block-head>
                <ui-block-head
                    class="teacher-profile__network"
                    :size="12"
                    title="Network"
                    color="orange"
                    :radius="true">
                    <pro-session
                        v-for="(network, i) in networks"
                        :key="i"
                        :counter="i"
                        :idx="network.id"
                        :title="network.title"
                        :app="network.app.title"/>
                </ui-block-head>
            </ui-block>
            <ui-block-head
                :size="4"
                title="Students"
                color="orange"
                :radius="true">
                <div class="teacher-profile__students">
                    <pro-student
                        v-for="student in students"
                        :key="student.id"
                        :name="student.name"/>
                </div>
                <div class="teacher-profile__add-action">
                    <ui-button
                        title="Add Student"
                        color="black"
                        align="center"/>
                </div>
            </ui-block-head>
        </ui-row>
    </ui-container>
</template>

<script>
import { ProActivity, ProStudent, ProSession } from '../../uiprofile'
import { UiBlock, UiBlockHead, UiButton, UiContainer, UiRow, } from '../../ui'
export default {
    name: 'ProfileTeacher',
    components: {
        ProActivity,
        ProSession,
        ProStudent,
        UiBlock,
        UiBlockHead,
        UiButton,
        UiContainer,
        UiRow,
    },
    data: function() {
        return {
            students: [],
            networks: [],
            activities: [],
        }
    },
    methods: {
        getData: function() {
            // console.log(this.$root.user);
            this.$http.get('/api/v2/profile').then(response => {
                console.log(response.data);
                this.students = response.data.user.students
                this.networks = response.data.user.networks
                this.activities = response.data.user.activities
                // console.log(this.students[0]);
            })
        },
    },
    created: function() {
        this.getData()
    },
    mounted: function() {
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.teacher-profile {
    padding-top: $spacer * 8;

    &__activities {
        margin-bottom: $spacer * 1.618 * 2;
    }

    &__students {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    &__add-action {
        margin-top: $spacer * 1.618;
        padding-bottom: $spacer * 1.618;
    }
}
</style>
