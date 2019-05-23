<template lang="html">
    <div class="pro-student-form">
        <ui-form-group
            name="Name"
            align="left"
            color="black"
            type="text"
            :default-value="student.name"
            @changed="changed"/>
        <ui-form-group
            name="Surname"
            align="left"
            color="black"
            type="text"
            :default-value="student.surname"
            @changed="changed"/>
        <ui-form-group
            name="Email"
            align="left"
            color="black"
            type="email"
            :default-value="student.email"
            @changed="changed"/>
        <ui-form-group
            name="Password"
            align="left"
            color="black"
            type="password"
            :default-value="student.password"
            @changed="changed"/>
    </div>
</template>

<script>
import { UiFormGroup } from '../ui'

export default {
    name: 'ProStudentForm',
    components: {
        UiFormGroup,
    },
    props: {
        student: {
            type: Object,
            default: function() {},
        },
    },
    methods: {
        changed: function(value, name) {
            this.$emit('changed', value, name)
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.pro-student-form {
    margin-top: $spacer * 1.618;
    padding-left: $spacer * 1.618;
    padding-right: $spacer * 1.618;
    width: 100%;
}
</style>
