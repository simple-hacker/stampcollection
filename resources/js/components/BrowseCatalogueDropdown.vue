<template>
    <div class="flex w-full items-center">
        <div class="flex w-1/5 justify-center">
            <a href="" @click.prevent="browseCatalogue(previousYear)" class="py-2 px-4 rounded-lg border-blue-800 border-2 text-blue-800 hover:bg-blue-100 text-lg font-semibold" v-show="previousYear">
                Previous Year
            </a>
        </div>
        <div class="flex-1 flex justify-center items-center">
            <span class="mr-4 p-2 text-xl font-semibold text-gray-700">Browse Catalogue By Year</span>
            <select class="bg-white border-lg border-blue-800 border-2 rounded py-3 px-6" @change="browseCatalogue(browseYear)" v-model="browseYear">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>
        </div>
        <div class="flex w-1/5 justify-center">
            <a href="" @click.prevent="browseCatalogue(nextYear)" class="py-2 px-4 rounded-lg border-blue-800 border-2 text-blue-800 hover:bg-blue-100 text-lg font-semibold justify-end" v-show="nextYear">
                Next Year
            </a>
        </div>
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                browseYear: 0
            }
        },
        props: {
            years: {
                type: Array,
                required: true,
            },
            year: {
                type: Number,
            }
        },
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