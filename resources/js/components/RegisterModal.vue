<template>
    <modal name="register" transition="pop-out" :width="modalWidth" height="auto">
        <div class="text-center shadow-md bg-blue-800">
            <h1 class="text-xl text-white font-bold px-8 py-3">Register</h1>
        </div>
        <form method="POST" action="register" class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8">
            
            <input type="hidden" name="_token" :value="_token">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input
                    name="name"
                    type="text"
                    placeholder="Name"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.name ? 'border-red-500 border-2' : 'border'"
                    v-model="form.name"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="nameError in errors.name" v-bind:key="nameError" v-text="nameError"></span>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    name="email"
                    type="email"
                    placeholder="Email"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.email ? 'border-red-500 border-2' : 'border'"
                    v-model="form.email"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="emailError in errors.email" v-bind:key="emailError" v-text="emailError"></span>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    name="password"
                    type="password"
                    placeholder="Password"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.password ? 'border-red-500 border-2' : 'border'"
                    v-model="form.password"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="passwordError in errors.password" v-bind:key="passwordError" v-text="passwordError"></span>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                    Confirm Password
                </label>
                <input
                    name="password_confirmation"
                    type="password"
                    placeholder="Confirm Password"
                    class="shadow appearance-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    :class="errors.password_confirmation ? 'border-red-500 border-2' : 'border'"
                    v-model="form.password_confirmation"
                    required />
                <div class="flex flex-col">
                    <span class="mt-2 text-xs text-red-500 italic font-bold" v-for="confirmPasswordError in errors.password_confirmation" v-bind:key="confirmPasswordError" v-text="confirmPasswordError"></span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button @click.prevent="submitForm()" type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Register
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
const MODAL_WIDTH = 656

export default {
    name: 'RegisterModal',
    data () {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            errors: {},
            modalWidth: MODAL_WIDTH,
        }
    },
    methods: {
        submitForm() {
            axios.post('register', this.form)
                .then(response => {
                    location = 'collection';
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    this.form.password = '';
                    this.form.password_confirmation = '';
                });
        },
    },
    created () {
        this.modalWidth = window.innerWidth < MODAL_WIDTH
            ? MODAL_WIDTH / 2
            : MODAL_WIDTH;
    }
}
</script>

<style>
    .pop-out-enter-active,
    .pop-out-leave-active {
    transition: all 0.5s;
    }

    .pop-out-enter,
    .pop-out-leave-active {
    opacity: 0;
    transform: translateY(24px);
    }
</style>