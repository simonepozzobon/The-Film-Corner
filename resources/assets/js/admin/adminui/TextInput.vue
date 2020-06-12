<template>
    <div class="form-group" :class="isVertical">
        <label :for="name" :class="isVerticalCol">
            {{ label }}
        </label>
        <div :class="isVerticalCont">
            <input
                :type="type"
                class="form-control"
                :name="name"
                :placeholder="placeholder"
                v-model="value"
            />
            <small v-if="info">{{ info }}</small>
        </div>
    </div>
</template>

<script>
export default {
    name: "TextInput",
    props: {
        label: {
            type: String,
            default: "label"
        },
        name: {
            type: String,
            default: "name"
        },
        placeholder: {
            type: String,
            default: null
        },
        type: {
            type: String,
            default: "text"
        },
        info: {
            type: String,
            default: null
        },
        initial: [String, Number],
        vertical: {
            type: Boolean,
            default: false
        }
    },
    data: function() {
        return {
            value: null
        };
    },
    watch: {
        value: function(value) {
            this.$emit("update", value);
        },
        initial: function(value) {
            this.setInitial();
        }
    },
    computed: {
        isVertical: function() {
            if (!this.vertical) {
                return "row";
            }
        },
        isVerticalCol: function() {
            if (!this.vertical) {
                return "col-md-2";
            }
        },
        isVerticalCont: function() {
            if (!this.vertical) {
                return "col-md-10";
            }
        }
    },
    methods: {
        setInitial: function() {
            this.value = this.initial;
        }
    },
    created: function() {
        this.setInitial();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
