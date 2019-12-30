<template>
    <div>
        <div class="flex">
            <div class="mr-1 w-1/6">
                <browse-year
                    :years="years"
                    :showYear="showYear"
                    v-on:change-year="changeYear"
                ></browse-year>
            </div>
            <div class="flex-1 ml-1">
                <catalogue
                    :catalogue="catalogueData[showYear]"
                    :year="showYear"
                ></catalogue>
            </div>
        </div>
    </div>
</template>

<script>

import Catalogue from './admin/Catalogue.vue'

export default {
    name: 'StampEditPage',
    data() {
        return {
            showYear: this.year,
            catalogueData: this.catalogue,
        }
    },
    // props: ['catalogue', 'year', 'admin'],
    props: ['catalogue', 'year', 'years', 'admin'],
    components: {
        'catalogue' : Catalogue,
    },
    methods: {
        changeYear(year) {
            this.showYear = year;
        },
    }
}
</script>

<style>

</style>