<template>
    <div class="flex flex-col bg-white shadow rounded sticky">
        <span class="mb-1 p-2 bg-darker text-xl font-bold text-white text-center p-4">Browse Catalogue</span>
        <div class="flex mb-2">
            <a  href=""
                @click.prevent="browseCatalogue(previousYear)"
                v-show="previousYear"
                class="flex-1 border-2 border-dark bg-highlight text-white font-semibold p-2 text-center hover:bg-highlight"
                :class="nextYear ? 'mr-1' : ''"
            >
                Previous Year
            </a>
            <a  href=""
                @click.prevent="browseCatalogue(nextYear)"
                v-show="nextYear"
                class="flex-1 border-2 border-dark bg-highlight text-white font-semibold p-2 text-center hover:bg-highlight"
                :class="previousYear ? 'ml-1' : ''"
            >
                Next Year
            </a>
        </div>
        <div class="flex flex-col max-h-screen overflow-y-scroll">
            <a
                v-for="year in years"
                :key="year"
                :href="'/collection/'+year"
                @click.prevent="browseCatalogue(year)"
                class="text-center py-2 px-4 border border-dark hover:text-highlight hover:border-highlight hover:bg-light mb-1"
                :class="(showYear == year) ? 'bg-highlight text-white' : 'text-dark'"
                v-text="year"
            >
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showYear: this.year,
            }
        },
        props: ['year', 'years'],
        methods: {
            browseCatalogue(year) {
                location = '/catalogue/'+year;
            }
        },
        computed: {
            currentYearIndex: function() {
                return this.years.indexOf(this.year);
            },
            previousYear: function () {
                if (this.years.hasOwnProperty(this.currentYearIndex + 1)) {
                    return this.years[this.currentYearIndex + 1];
                } else {
                    return false;
                }
            },
            nextYear: function () {
                if (this.years.hasOwnProperty(this.currentYearIndex - 1)) {
                    return this.years[this.currentYearIndex - 1];
                } else {
                    return false;
                }
            }
        }
    }
</script>

<style>

</style>