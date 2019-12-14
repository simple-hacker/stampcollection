<template>
    <div class="dropdown-menu relative"> 
        <div @click.prevent="showDropdownContents = !showDropdownContents">
            <slot name="dropdown-toggle"></slot>
        </div>

        <!-- Dropdown contents -->
        <transition name="slide-fade">
            <div v-show="showDropdownContents" class="absolute bg-white shadow rounded top-40 right-0" style="min-width: 180px;">
                <slot name="dropdown-contents"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showDropdownContents: false
            };
        },

        created: function() {
            let self = this;

            window.addEventListener('click', function(e){
                // close dropdown when clicked outside
                if (!self.$el.contains(e.target)){
                    self.showDropdownContents = false
                } 
            })
        }
    }
</script>


<style>
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateY(-10px);
        opacity: 0;
    }

</style>