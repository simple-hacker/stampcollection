<template>
    <div>
        <div
            v-for="issue in this.issues"
            :key="issue.id"
            class="mb-4 bg-white rounded shadow">
            <!-- Header and link -->
            <a :href="issue.path" class="flex justify-between items-center px-4 py-2 bg-dark text-white mb-1">
                <!-- Issue Title and Date -->
                <div class="flex flex-col">
                    <h2 class="text-2xl">{{ issue.title }}</h2>
                    <small v-if="issue.release_date != null" class="mt-1">Released {{ convertDate(issue.release_date) }}</small>
                </div>
                <!-- Issue Stamp Data -->
                <div class="flex text-xl items-center">
                    <div data-toggle="tooltip" :title="issue.stamps_count+ ' stamps in this issue'" class="flex items-center mr-5">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path d="M8 4v28l10-10 10 10v-28zM24 0h-20v28l2-2v-24h18z"></path>
                        </svg>
                        <span>{{ issue.stamps_count }}</span>
                    </div>
                    <div data-toggle="tooltip" :title="issue.stamps.length+' stamps collected in this issue'" class="flex items-center mr-5">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                        </svg>
                        <span>{{ issue.stamps.length }}</span>
                    </div>
                    <div v-if="(issue.stamps_count - issue.stamps.length) > 0" data-toggle="tooltip" :title="(issue.stamps_count - issue.stamps.length)+' stamps missing from collection'" class="flex items-center">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path d="M16 2.899l13.409 26.726h-26.819l13.409-26.726zM16 0c-0.69 0-1.379 0.465-1.903 1.395l-13.659 27.222c-1.046 1.86-0.156 3.383 1.978 3.383h27.166c2.134 0 3.025-1.522 1.978-3.383h0l-13.659-27.222c-0.523-0.93-1.213-1.395-1.903-1.395v0z"></path>
                            <path d="M18 26c0 1.105-0.895 2-2 2s-2-0.895-2-2c0-1.105 0.895-2 2-2s2 0.895 2 2z"></path>
                            <path d="M16 22c-1.105 0-2-0.895-2-2v-6c0-1.105 0.895-2 2-2s2 0.895 2 2v6c0 1.105-0.895 2-2 2z"></path>
                        </svg>
                        <span>{{ issue.stamps_count - issue.stamps.length }}</span>
                    </div>
                </div>
            </a>
            <!-- Stamps -->
            <div class="flex flex-wrap items-start px-4 py-2">
                <button v-for="stamp in issue.stamps" :key="stamp.id" @click.prevent="$modal.show('collection', {stamp: stamp})" class="flex min-w-1/6 max-w-1/5">
                    <div class="flex flex-col flex-1 items-center mr-1 p-1 border">
                        <img :src="stamp.image_src" :alt="stamp.title" class="h-20 mb-2">
                        <p v-if="stamp.prefixedSgNumber" class="italic" v-html="stamp.prefixedSgNumber"></p>
                        <p v-if="stamp.sg_illustration" class="italic" v-html="stamp.sg_illustration"></p>
                        <p class="text-sm flex-1" v-html="stamp.title"></p>
                        <div class="flex flex-wrap justify-center border-t p-2">
                            <div v-for="data in collectedStamps[stamp.id]" :key="data.id">
                                <div :title="data[0].grading.grading+'\r\n'+data[0].grading.description"
                                    class="py-1 px-3 mx-1 mt-1 rounded-lg text-xs font-semibold text-white"
                                    :class="'bg-'+data[0].grading.abbreviation"
                                    v-html="data.length+' x '+data[0].grading.abbreviation"
                                >
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['issues', 'collectedStamps', 'gradings'],
    methods: {
        convertDate(date) {
            date = new Date(date);
            // Jesus fucking christ it's 2019 and you still have to format a date manually. PHP > JS
            return date.toLocaleString('default', { month: 'long' }) + ' ' + date.getDate() + ', ' + date.getFullYear();
        }
    }
}
</script>

<style>

</style>