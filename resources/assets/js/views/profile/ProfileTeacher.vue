<template>
<ui-container
    class="teacher-profile"
    :contain="true"
>
    <ui-row :no-gutters="false">
        <ui-block :size="8">
            <ui-block-head
                class="teacher-profile__activities"
                :size="12"
                title="Activities"
                color="orange"
                :radius="true"
            >
                <pro-activity
                    v-for="(activity, i) in activities"
                    :key="activity.id"
                    :counter="i"
                    :activity="activity"
                    @delete-activity="deleteActivity"
                />
            </ui-block-head>
            <ui-block-head
                class="teacher-profile__network"
                :size="12"
                title="Network"
                color="orange"
                :radius="true"
            >
                <pro-session
                    v-for="(network, i) in networks"
                    :key="i"
                    :counter="i"
                    :idx="network.id"
                    :title="network.title"
                    :app="network.app.title"
                    :name="network.user.name"
                    :surname="network.user.surname"
                    :comments="network.comments"
                    :likes="network.likes"
                    :network="network"
                    @delete-network="deleteNetwork"
                />
            </ui-block-head>
        </ui-block>
        <ui-block-head
            :size="4"
            title="Students"
            color="orange"
            :radius="true"
        >
            <div
                class="teacher-profile__students"
                v-if="panelType == 1"
            >
                <pro-student
                    v-for="student in students"
                    :key="student.id"
                    :idx="student.id"
                    :name="student.name"
                    :surname="student.surname"
                    @edit="editStudent"
                />
            </div>
            <div
                class="teacher-profile__students"
                v-else-if="panelType == 2"
            >
                <pro-student-form @changed="setForm" />
            </div>

            <div
                class="teacher-profile__students"
                v-else-if="panelType == 3"
            >
                <pro-student-edit
                    :student="student"
                    @changed="setForm"
                />
            </div>
            <div class="teacher-profile__add-action">
                <ui-button
                    class="teacher-profile__button"
                    :title="button"
                    color="black"
                    align="center"
                    :has-container="false"
                    @click="addStudent"
                />
                <ui-button
                    v-if="panelType == 2 || panelType == 3"
                    class="teacher-profile__button"
                    title="Cancel"
                    color="black"
                    align="center"
                    :has-container="false"
                    @click="cancelEditing"
                />
            </div>
        </ui-block-head>
    </ui-row>
</ui-container>
</template>

<script>
import {
    ProActivity,
    ProStudent,
    ProStudentEdit,
    ProStudentForm,
    ProSession
}
from '../../uiprofile'
import {
    UiBlock,
    UiBlockHead,
    UiButton,
    UiContainer,
    UiRow,
}
from '../../ui'
export default {
    name: 'ProfileTeacher',
    components: {
        ProActivity,
        ProSession,
        ProStudent,
        ProStudentEdit,
        ProStudentForm,
        UiBlock,
        UiBlockHead,
        UiButton,
        UiContainer,
        UiRow,
    },
    data: function () {
        return {
            students: [],
            networks: [],
            activities: [],
            button: 'Add Student',
            panelType: 1,
            student: {
                name: 'simone',
                surname: 'pozzobon',
                email: 'info@rutryutru.com',
                password: 'password',
            },
        }
    },
    methods: {
        getData: function () {
            // console.log(this.$root.user);
            this.$http.get('/api/v2/profile').then(response => {
                // console.log(response.data.user.activities[0]);

                if (response.data.success) {
                    this.activities = response.data.user.activities
                    this.students = response.data.user.students
                    this.networks = response.data.user.networks
                }

                // console.log(this.activities[0]);
                // this.editStudent(160)
                // console.log(this.students[0]);
            })
        },
        deleteNetwork: function (idx) {
            let url = '/api/v2/profile/network/' + idx
            this.$http.delete(url).then(response => {
                if (response.data.success) {
                    this.networks = this.networks.filter(network => network.id != idx)
                }
            })
        },
        cancelEditing: function () {
            this.panelType = 1
            this.button = 'Add Student'
        },
        addStudent: function () {
            switch (this.panelType) {
            case 1:
                this.panelType = 2
                this.button = 'Save Student'
                break;
            case 2:
                this.saveStudent()
                break;
            case 3:
                this.updateStudent()
                break;
            }
        },
        setForm: function (value, name) {
            this.student[name] = value
        },
        editStudent: function (idx) {
            this.student = this.students.filter(student => student.id == idx)[0]
            this.$nextTick(() => {
                this.button = 'Update Student'
                this.panelType = 3
            })
        },
        updateStudent: function () {
            if (this.checkForm()) {
                this.$http.post('/api/v2/profile/student/edit', this.student).then(response => {
                    if (response.data.success) {
                        let newStudent = response.data.user
                        let idx = this.students.findIndex(student => student.id == newStudent.id)
                        if (idx > -1) {
                            this.students.splice(idx, 1, newStudent)
                        }
                        this.$nextTick(() => {
                            this.panelType = 1
                        })
                    }
                })
            }
        },
        saveStudent: function () {
            if (this.checkForm()) {
                this.$http.post('/api/v2/profile/student/save', this.student).then(response => {
                    // console.log(response.data);
                    if (response.data.success) {
                        this.students.push(response.data.user)
                        this.$nextTick(() => {
                            this.panelType = 1
                        })
                    }
                })
            }
        },
        checkForm: function () {
            for (let key in this.student) {
                if (!this.student.hasOwnProperty(key) || !this.student[key]) {
                    return false
                }
            }

            return true
        },
        deleteActivity: function (idx) {
            let obj = this.activities.find(activity => activity.id == idx)
            // console.log(obj);
            if (obj) {
                console.log(obj);
                let id = obj.id
                let url = '/api/v2/profile/activity/' + id
                this.$http.delete(url).then(response => {
                    console.log(response.data);
                    if (response.data.success) {
                        this.activities = this.activities.filter(activity => activity.id != idx)
                    }
                })
            }

        },
    },
    created: function () {
        this.getData()
    },
    mounted: function () {},
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.teacher-profile {
    padding-top: $spacer * 5;
    padding-bottom: $spacer * 2.5;

    &__activities {
        margin-bottom: $spacer * 1.618 * 2;
    }

    &__students {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    &__add-action {
        display: flex;
        justify-content: center;
        margin-top: $spacer * 1.618;
        padding-bottom: $spacer * 1.618;
    }

    &__button {
        margin-left: $spacer / 1.618;
        margin-right: $spacer / 1.618;
    }
}
</style>
