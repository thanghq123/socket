import './bootstrap.js';

import Alpine from 'alpinejs';


import Echo from 'laravel-echo';
import io from 'socket.io-client';
// import SocketClient from 'socket.io-client';
// window.io = SocketClient;
// window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    // host: 'http://localhost' + ':6001',
    // host: 'http://103.163.217.193' + ':6001',
    host: 'http://103.163.217.193' + ':6001',
    client: io,
});

// const echo = new Echo({
//     broadcaster: 'socket.io',
//     host: window.location.hostname + ':6001', // Cài đặt host và port của Laravel Echo Server
//     client: io,
// });

console.log(window.Echo);


window.Echo.channel('test-channel')
    .listen('TestEvent', (data) => {
        // Xử lý dữ liệu nhận được tại đây
        console.log(data);
    });

// const echo = new Echo({
//     broadcaster: 'socket.io',
//     host: window.location.hostname + ':6001', // Sửa cổng nếu bạn đang sử dụng cổng khác
//     client: io,
// });
//
// echo.channel('test-channel')
//     .listen('.TestEvent', (data) => {
//         // Xử lý dữ liệu nhận được tại đây
//         console.log('123');
//     });
