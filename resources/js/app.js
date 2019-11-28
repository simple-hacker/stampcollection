/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


// CountUp the Stats ont he welcome page.

import { CountUp } from 'countup.js';

window.onload = function () {
    const usersCount = parseInt(document.getElementById('usersCount').innerHTML);
    const collectionsCount = parseInt(document.getElementById('collectionsCount').innerHTML);
    const stampsCount = parseInt(document.getElementById('stampsCount').innerHTML);
    let countUpUsers = new CountUp('usersCount', usersCount, {
        startVal: 0,
        duration: 4
    });
    let countUpCollections = new CountUp('collectionsCount', collectionsCount, {
        startVal: 0,
        duration: 4
    });
    let countUpStamps = new CountUp('stampsCount', stampsCount, {
        startVal: 0,
        duration: 4
    });
    countUpUsers.start();
    countUpCollections.start();
    countUpStamps.start();
}