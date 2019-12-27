<template>
    <div class="flex flex-col bg-white rounded shadow sticky top-5">
        <div class="mb-2 p-4 bg-darker">
            <input  type="number"
                    v-model.number="typeYear"
                    @focus="typeYear = ''"
                    @keyup="changeYear"
                    class="w-full text-4xl bg-dark border border-highlight text-white text-center"
            >
        </div>
        <div class="flex mb-2">
            <div class="w-1/2 mr-1">
                <a  href=""
                    @click.prevent="$emit('change-year', previousYear)"
                    v-if="previousYear"
                    class="flex justify-center border-2 border-dark bg-highlight text-white font-semibold p-2 hover:bg-highlight"
                >
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
                        <path d="M16 32c8.837 0 16-7.163 16-16s-7.163-16-16-16-16 7.163-16 16 7.163 16 16 16zM16 3c7.18 0 13 5.82 13 13s-5.82 13-13 13-13-5.82-13-13 5.82-13 13-13z"></path>
                        <path d="M20.914 9.914l-2.829-2.829-8.914 8.914 8.914 8.914 2.828-2.828-6.086-6.086z"></path>
                    </svg>
                </a>
            </div>
            <div class="w-1/2 ml-1">
                <a  href=""
                    @click.prevent="$emit('change-year', nextYear)"
                    v-if="nextYear"
                    class="flex justify-center border-2 border-dark bg-highlight text-white font-semibold p-2 hover:bg-highlight"
                >
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
                        <path d="M16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 29c-7.18 0-13-5.82-13-13s5.82-13 13-13 13 5.82 13 13-5.82 13-13 13z"></path>
                        <path d="M11.086 22.086l2.829 2.829 8.914-8.914-8.914-8.914-2.828 2.828 6.086 6.086z"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div id="years" class="max-h-browse overflow-y-auto flex flex-col">
            <a
                :id="'browse_'+year"
                v-for="(year) in years"
                :key="year"
                :href="href+year"
                @click.prevent="$emit('change-year', year)"
                class="text-center py-2 px-4 border border-dark hover:text-highlight hover:border-highlight hover:bg-light mb-1"
                :class="(showYear == year) ? 'bg-highlight text-white' : 'text-dark'"
                v-text="year"
            >
            </a>
        </div>
    </div>
</template>

<script>

var VueScrollTo = require('vue-scrollto');

export default {
    name: 'BrowseYear',
    data() {
        return {
            typeYear: this.showYear
        }
    },
    props: ['showYear', 'years', 'href'],
    computed: {
        currentYearIndex() {
            return this.years.indexOf(this.showYear);
        },
        previousYear() {
            if (this.years.hasOwnProperty(this.currentYearIndex + 1)) {
                return this.years[this.currentYearIndex + 1];
            } else {
                return false;
            }
        },
        nextYear() {
            if (this.years.hasOwnProperty(this.currentYearIndex - 1)) {
                return this.years[this.currentYearIndex - 1];
            } else {
                return false;
            }
        }
    },
    methods: {
        changeYear() {
            if (this.typeYear.toString().length === 4) {
                if (this.years.includes(this.typeYear)) {
                    this.$emit('change-year', this.typeYear);

                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    this.$scrollTo('#browse_'+this.typeYear, 350, {
                            container: '#years',
                            easing: 'ease-in',
                            offset: -60,
                            force: true,
                            cancelable: true,
                            x: false,
                            y: true
                        });
                }
            }
        },
    }
}
</script>

<style scoped>
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
</style>