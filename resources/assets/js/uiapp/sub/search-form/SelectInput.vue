<template>
    <div class="form-group ua-select-input">
        <label :for="name">{{ title }}</label>
        <select class="form-control" :name="name" v-model="selectedValue">
            <option :value="null" selected>
                {{ placeholder }}
            </option>
            <option v-for="opt in options" :key="opt.id" :value="opt.id">
                {{ opt | translate(optionValue, $root.locale) }}
            </option>
        </select>
    </div>
</template>

<script>
import TranslationFilter from "../../../TranslationFilter";
export default {
    name: "TextInput",
    mixins: [TranslationFilter],
    props: {
        name: {
            type: String,
            default: "name"
        },
        title: {
            type: String,
            default: "Titolo"
        },
        placeholder: {
            type: String,
            default: null
        },
        value: [String, Number],
        optionValue: {
            type: String,
            default: "title"
        },
        options: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data: function() {
        return {
            selectedValue: null
        };
    },
    watch: {
        selectedValue: function(value) {
            this.$emit("update:value", value);
        }
    }
};
</script>

<style lang="scss">
@import "~styles/shared";
</style>
