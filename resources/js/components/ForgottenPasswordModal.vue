<template>
    <modal name="forgotten-password" transition="pop-out" :width="modalWidth" height="auto">
        <div class="text-center bg-blue-800">
            <h1 class="text-xl text-white font-bold px-8 py-3">Reset Password</h1>
        </div>
        <form method="POST" action="password/email" class="bg-white shadow-md rounded-b-lg px-8 pt-6 pb-8">
            
            <input type="hidden" name="_token" :value="csrf">

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" placeholder="Email" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Send Password Reset Link
                </button>
            </div>
        </form>
    </modal>
</template>

<script>
const MODAL_WIDTH = 656

export default {
    name: 'ForgottenPasswordModal',
    data () {
        return {
            modalWidth: MODAL_WIDTH,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
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