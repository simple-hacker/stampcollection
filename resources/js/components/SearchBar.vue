<template>
    <div class="w-5/6">
        <form @submit.prevent="submit()" class="flex items-center justify-center w-full">
            <input
                type="text"
                class="p-3 w-full bg-darker text-white shadow rounded-l"
                placeholder="Search for stamps or issues"
                v-model="query"
                @focus="showResults = true"
            >
            <button type="submit" class="bg-highlight text-white p-3 rounded-r">
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                    <path d="M31.008 27.231l-7.58-6.447c-0.784-0.705-1.622-1.029-2.299-0.998 1.789-2.096 2.87-4.815 2.87-7.787 0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12c2.972 0 5.691-1.081 7.787-2.87-0.031 0.677 0.293 1.515 0.998 2.299l6.447 7.58c1.104 1.226 2.907 1.33 4.007 0.23s0.997-2.903-0.23-4.007zM12 20c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z"></path>
                </svg> 
            </button>
        </form>
        <div
            v-if="(stamps.length > 0 || issues.length > 0) && query.length > 1 && showResults == true"
            class="flex w-full absolute left-0 mt-2 shadow bg-gray-300 text-dark border-2 border-dark z-50"
        >
            <div
                v-if="stamps.length > 0"
                class="flex flex-col flex-1"
            >
                <div class="bg-highlight text-white text-center text-2xl font-bold p-2">
                    Stamps
                </div>
                <div class="flex flex-col p-2">
                    <a
                        v-for="stamp in stamps.slice(0,10)"
                        :key="stamp.id"
                        :href="stamp.url"
                        class="flex hover:bg-dark hover:text-white p-1 items-center">
                        <div class="w-1/4 flex justify-center">
                            <img :src="stamp.searchable.image_src" :alt="stamp.title" class="h-16">
                        </div>
                        <div class="flex flex-col w-3/4 px-1">
                            <div v-text="stamp.title" class="font-semibold"></div>
                            <small>Part of {{ stamp.searchable.issue.title }} ({{ stamp.searchable.issue.year }})</small>
                        </div>
                    </a>
                </div>                
            </div>
            <div
                v-if="issues.length > 0"
                class="flex flex-col flex-1"
            >
                <div class="bg-highlight text-white text-center text-2xl font-bold p-2">
                    Issues
                </div>
                <div class="flex flex-col p-2">
                    <a
                        v-for="issue in issues.slice(0,10)"
                        :key="issue.id"
                        :href="issue.url"
                        class="flex hover:bg-dark hover:text-white p-2 items-center">
                        <div class="flex flex-col">
                            <span class="font-semibold">{{ issue.title }}</span> ({{ issue.searchable.year }})
                        </div>
                    </a>
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showResults: false,
                query: null,
                issues: [],
                stamps: [],
            };
        },
        created: function() {
            let self = this;

            window.addEventListener('click', function(e){
                // close dropdown when clicked outside
                if (!self.$el.contains(e.target)){
                    self.showResults = false
                } 
            })
        },
        watch: {
            query() {
                if (this.query.length > 1) {
                    this.showResults = true;
                    this.search();
                }
            }
        },
        methods: {
            search() {
                axios.get('/search/'+this.query)
                    .then(response => {
                        this.stamps = response.data.stamps || [];
                        this.issues = response.data.issues || [];
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            submit() {
                location = '/search/'+this.query;
            }
        }
    }
</script>

<style>

</style>