<template>
    <div>
        <h1 class="text-4xl w-full border-b mb-2">Edit Monarchs</h1>
        <div class="mb-4">
            <transition-group name="slide">
                <div
                    v-for="monarch in monarchs"
                    :key="monarch.id"
                    class="flex mb-1 items-start"
                >
                    <div class="flex flex-col flex-1">
                        <input
                            type="text"
                            v-model="monarch.abbreviation"
                            v-text="monarch.abbreviation"
                            placeholder="Abbreviation"
                            class="p-2 m-1"
                            :class="updateMonarchsErrors[`${monarch.id}.abbreviation`] ? 'border-red-500 border-2' : 'border border-highlight'"
                        >
                        <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="updateMonarchsErrors[`${monarch.id}.abbreviation`]">{{ updateMonarchsErrors[`${monarch.id}.abbreviation`][0] }}</span>
                    </div>
                    <div class="flex flex-col flex-1">
                        <input
                            type="text"
                            v-model="monarch.monarch"
                            v-text="monarch.monarch"
                            placeholder="Monarch"
                            class="p-2 m-1"
                            :class="updateMonarchsErrors[`${monarch.id}.monarch`] ? 'border-red-500 border-2' : 'border border-highlight'"
                        >
                        <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="updateMonarchsErrors[`${monarch.id}.monarch`]">{{ updateMonarchsErrors[`${monarch.id}.monarch`][0] }}</span>
                    </div>
                    <div class="flex items-start p-1 ml-1">
                        <button @click.prevent="removeMonarch(monarch, monarch.id)" class="border rounded p-2 text-center bg-red-500 hover:bg-red-700 text-white">
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M3,8v15c0,0.552,0.448,1,1,1h16c0.552,0,1-0.448,1-1V8H3z M9,19H7v-6h2V19z M13,19h-2v-6h2V19z M17,19h-2v-6 h2V19z"></path>
                                <path d="M23,4h-6V1c0-0.552-0.447-1-1-1H8C7.447,0,7,0.448,7,1v3H1C0.447,4,0,4.448,0,5s0.447,1,1,1 h22c0.553,0,1-0.448,1-1S23.553,4,23,4z M9,2h6v2H9V2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </transition-group>
            <div class="flex items-center">
                <button
                    v-text="'Save Changes'"
                    @click="updateMonarchs"
                    class="mt-3 py-2 px-4 rounded text-center border border-darker bg-dark text-white text-xl hover:bg-highlight"
                >                
                </button>
                <span v-if="showUpdatedMessage" class="flex tems-center ml-3 italic text-green-700">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                        <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                    </svg>
                    Saved Changes
                </span>
            </div>
        </div>
        <h1 class="text-4xl w-full border-b mt-5 mb-2">Add Monarchs</h1>
        <div>
            <div
                v-for="(monarch, index) in addMonarchs"
                :key="index"
                class="flex mb-1 items-start"
            >
                <div class="flex flex-col flex-1">
                    <input
                        type="text"
                        v-model="monarch.abbreviation"
                        v-text="monarch.abbreviation"
                        placeholder="Abbreviation"
                        class="p-2 m-1"
                        :class="addMonarchsErrors[`${index}.abbreviation`] ? 'border-red-500 border-2' : 'border border-highlight'"
                    >
                    <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="addMonarchsErrors[`${index}.abbreviation`]">{{ addMonarchsErrors[`${index}.abbreviation`][0] }}</span>
                </div>
                <div class="flex flex-col flex-1">
                    <input
                        type="text"
                        v-model="monarch.monarch"
                        v-text="monarch.monarch"
                        placeholder="Monarch"
                        class="p-2 m-1"
                        :class="addMonarchsErrors[`${index}.monarch`] ? 'border-red-500 border-2' : 'border border-highlight'"
                    >
                    <span class="flex-1 p-2 italic text-xs font-bold text-red-500" v-if="addMonarchsErrors[`${index}.monarch`]">{{ addMonarchsErrors[`${index}.monarch`][0] }}</span>
                </div>
                <div class="flex items-start p-2">
                    <button @click.prevent="addMonarchs.splice(index, 1)" class="ml-2">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0zM15 9v2h-10v-2h10z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <button
                        v-text="'Add Monarchs'"
                        @click="storeMonarchs"
                        class="mt-3 py-2 px-4 rounded text-center border border-darker bg-dark text-white text-xl hover:bg-highlight"
                    >                
                    </button>
                    <span v-if="showAddedMessage" class="flex tems-center ml-3 italic text-green-700">
                        <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
                            <path d="M27 4l-15 15-7-7-5 5 12 12 20-20z"></path>
                        </svg>
                        Added monarchs
                    </span>
                </div>
                <button @click.prevent="addRow()" class="flex border rounded p-2 text-center bg-green-500 hover:bg-green-600 text-white">
                    <svg class="fill-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <path d="M11 9h4v2h-4v4h-2v-4h-4v-2h4v-4h2v4zM10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM10 18c4.418 0 8-3.582 8-8s-3.582-8-8-8v0c-4.418 0-8 3.582-8 8s3.582 8 8 8v0z"></path>
                    </svg>
                    Another Row
                </button>
            </div>            
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            monarchs: this.monarchsProp,
            addMonarchs: [
                {
                    abbreviation: '',
                    monarch: '',
                },
            ],
            showUpdatedMessage: false,
            showAddedMessage: false,
            updateMonarchsErrors: {},
            addMonarchsErrors: {},
        }
    },
    props: ['monarchsProp'],
    methods: {
        addRow() {
            this.addMonarchs.push({
                    abbreviation: '',
                    monarch: '',
                });
        },
        storeMonarchs() {
            axios.post('/admin/monarchs', {monarchs: this.addMonarchs})
                .then(response => {
                    this.monarchs = response.data;

                    this.addMonarchs = [{
                        abbreviation: '',
                        monarch: '',
                    }];

                    this.addMonarchsErrors = {};
                    this.showAddedMessage = true;
                })
                .catch(error => {
                    console.log(error);
                    this.addMonarchsErrors = error.response.data.errors;
                });
        },
        updateMonarchs() {
            axios.post('/admin/monarchs', {
                    _method: 'patch',
                    monarchs: this.monarchs
                })
                .then(response => {
                    this.updateMonarchsErrors = {};
                    this.showUpdatedMessage = true;
                })
                .catch(error => {
                    console.log(error);
                    this.updateMonarchsErrors = error.response.data.errors;
                });
        },
        removeMonarch(monarch, index) {
            if (confirm(`Are you sure you want to remove ${monarch.monarch}?`)) {
                axios.post('/admin/monarchs/'+monarch.id, {
                        _method: 'delete',
                        monarch: monarch
                    })
                    .then(response => {
                        Vue.delete(this.monarchs, index);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
}
</script>

<style>
    .slide-enter-active, .slide-leave-active {
        transition: all 0.5s
    }

    .slide-enter {
        opacity: 0;
        transform: translateX(-30px);
    }

    .slide-leave-to {
        opacity: 0;
        transform: translateX(30px);
    }
</style>