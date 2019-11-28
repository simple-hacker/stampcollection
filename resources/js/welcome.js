import { CountUp } from 'countup.js';
// CountUp the Stats on the welcome page.
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