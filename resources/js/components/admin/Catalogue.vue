<template>
    <div class="bg-white rounded shadow p-4">
        <!-- Loop through issues in catalogue year -->
                <div class="flex-flex-col sticky top-0">
                    <div class="flex justify-between bg-darker p-4 items-center">
                        <h1 class="text-white text-3xl font-bold">Edit stamps for {{year}}</h1>
                        <div class="flex items-center">
                            <span v-if="showSavedMessage" class="flex tems-center mr-5 italic text-green-300">
                                <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                                    <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                                </svg>
                                Saved Changes
                            </span>
                            <button
                                @click="save"
                                v-text="'Save Changes'"
                                class="px-4 py-2 text-white text-2xl font-semibold bg-highlight border border-dark rounded shadow hover:bg-dark hover:text-white"
                            ></button>
                        </div>

                    </div>
                    <div class="flex bg-dark text-white text-lg font-bold">
                        <div class="w-1/10 py-2 text-center border border-darker">SG #</div>
                        <div class="w-1/10 py-2 text-center border border-darker">SG ill.</div>
                        <div class="w-1/10 py-2 text-center border border-darker">Denomination</div>
                        <div class="w-2/10 py-2 text-center border border-darker">Title</div>
                        <div class="w-2/10 py-2 text-center border border-darker">Description</div>
                        <div class="w-1/10 py-2 text-center border border-darker">Face Value</div>
                        <div class="w-1/10 py-2 text-center border border-darker">Mint Value</div>
                        <div class="w-1/10 py-2 text-center border border-darker">Used Value</div>
                    </div>
                </div>


                <div
                    v-for="issue in issuesArray"
                    :key="issue.id"
                    class="flex-col mb-2"
                >
                    <div
                        v-text="convertDate(issue.release_date)+' - '+issue.title"
                        class="w-full bg-highlight text-white font-semibold p-3"
                    >
                    </div>
                        <div
                            v-for="(stamp, index) in issue.stamps"
                            :key="stamp.id"
                            class="flex-col"
                            :class="(index % 2 == 0) ? 'bg-light' : ''"
                        >
                        <div class="flex">
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <input  type="text"
                                        class="p-1 bg-transparent rounded w-full"
                                        :class="errors[`${stamp.id}.sg_number`] ? 'border-2 border-red-500' : 'border border-darker'"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.sg_number"
                                >
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.sg_number`]">{{ errors[`${stamp.id}.sg_number`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <input  type="text"
                                        class="p-1 bg-transparent rounded w-full"
                                        :class="errors[`${stamp.id}.sg_illustration`] ? 'border-2 border-red-500' : 'border border-darker'"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.sg_illustration"
                                >
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.sg_illustration`]">{{ errors[`${stamp.id}.sg_illustration`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <input  type="text"
                                        class="p-1 bg-transparent rounded w-full"
                                        :class="errors[`${stamp.id}.denomination`] ? 'border-2 border-red-500' : 'border border-darker'"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.denomination"
                                >
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.denomination`]">{{ errors[`${stamp.id}.denomination`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-2/10 p-1 border">
                                <input  type="text"
                                        class="p-1 bg-transparent rounded w-full"
                                        :class="errors[`${stamp.id}.title`] ? 'border-2 border-red-500' : 'border border-darker'"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.title"
                                >
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.title`]">{{ errors[`${stamp.id}.title`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-2/10 p-1 border">
                                <textarea
                                        type="text"
                                        rows="1"
                                        class="p-1 bg-transparent rounded w-full"
                                        :class="errors[`${stamp.id}.description`] ? 'border-2 border-red-500' : 'border border-darker'"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.description"
                                ></textarea>
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.description`]">{{ errors[`${stamp.id}.description`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <div
                                    class="flex items-center rounded"
                                    :class="errors[`${stamp.id}.face_value`] ? 'border-2 border-red-500' : 'border border-darker'"
                                >
                                    <currency-input
                                        class="p-1 bg-transparent w-full"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.face_value"
                                    ></currency-input>
                                </div>
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.face_value`]">{{ errors[`${stamp.id}.face_value`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <div
                                    class="flex items-center rounded"
                                    :class="errors[`${stamp.id}.mint_value`] ? 'border-2 border-red-500' : 'border border-darker'"
                                >
                                    <currency-input
                                        class="p-1 bg-transparent w-full"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.mint_value"
                                    ></currency-input>
                                </div>
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.mint_value`]">{{ errors[`${stamp.id}.mint_value`][0] }}</span>
                            </div>
                            <div class="flex flex-col justify-start w-1/10 p-1 border">
                                <div
                                    class="flex items-center rounded"
                                    :class="errors[`${stamp.id}.used_value`] ? 'border-2 border-red-500' : 'border border-darker'"
                                >
                                    <currency-input
                                        class="p-1 bg-transparent w-full"
                                        @change="addToStampsToSave(stamp)"
                                        @focus="showSavedMessage = false"
                                        v-model="stamp.used_value"
                                    ></currency-input>
                                </div>
                                <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="errors[`${stamp.id}.used_value`]">{{ errors[`${stamp.id}.used_value`][0] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showSavedMessage: false,
                stampsToSave: {},
                errors: {}
            }
        },
        props: ['catalogue', 'year'],
        computed: {
            issuesArray() {
                return Object.values(this.catalogue).sort(function(issue1, issue2) {
                    return issue1.release_date < issue2.release_date ? -1 : 0;
                });
            },
        },
        methods: {
            convertDate(date) {
                date = new Date(date);
                return date.getFullYear() + ' (' + date.getDate() + ' ' + date.toLocaleString('default', { month: 'short' }) + ')';
            },
            save() {
                if (Object.keys(this.stampsToSave).length > 0) {
                    axios.post('/admin/stamps', this.stampsToSave)
                        .then(response => {
                            this.showSavedMessage = true;
                            this.stampsToSave = {};
                            this.errors = [];
                        })
                        .catch(error => {
                            console.log(error);
                            this.errors = error.response.data.errors;

                            this.$modal.show('dialog', {
                                title: 'Errors!',
                                text: `Highlighted errors must be corrected.`,
                                buttons: [
                                    {
                                        title: 'Okay',
                                        class: 'py-3 hover:bg-gray-200',
                                        handler: () => {
                                            this.$modal.hide('dialog');
                                        }
                                    },
                                ]
                            })
                        });
                }
            },
            addToStampsToSave(stamp) {
                this.stampsToSave[stamp.id] = stamp;
            },
        }
    }
</script>

<style>

</style>
