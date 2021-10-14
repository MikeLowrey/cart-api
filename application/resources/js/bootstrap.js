window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="session-id"]').getAttribute('value');
//window.axios.defaults.headers.common['COOKIE'] = 'laravel_session=' + document.querySelector('meta[name="session-id"]').getAttribute('value') +
//  '; ' + document.cookie.match(new RegExp('(^| )' + 'XSRF-TOKEN' + '=([^;]+)'))[0];;
//window.axios.defaults.headers.common['XSRF-TOKEN'] = document.cookie.match(new RegExp('(^| )' + 'XSRF-TOKEN' + '=([^;]+)'))[0]; //document.querySelector('meta[name="csrf-token"]').getAttribute('value');
window.axios.defaults.withCredentials = true
    /**
     * Echo exposes an expressive API for subscribing to channels and listening
     * for events that are broadcast by Laravel. Echo and event broadcasting
     * allows your team to easily build robust real-time web applications.
     */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

// axios.get('http://127.0.0.1:8000/cookietest', {
//     headers: {
//         'Accept': 'application/json',
//         'Content-Type': 'application/json',
//     },
// }).then(res => console.log('resCookieTest', res)).catch(err => console.log('err', err));