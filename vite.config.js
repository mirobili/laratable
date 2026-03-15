// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import react from '@vitejs/plugin-react';

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: 'resources/js/app.jsx',
//             refresh: true,
//         }),
//         react(),
//     ],
//     server: {
//         host: 'gitea.local',
//         port: 3000,
//         hmr: {
//             host: 'gitea.local',
//         },
//         proxy: {
//             '/api': {
//                 target: 'http://gitea.local:8000',
//                 changeOrigin: true,
//                 secure: false,
//                 ws: true,
//             },
//         },
//     },
// });


// export default defineConfig({
    // plugins: [
        // laravel({
            // input: 'resources/js/app.jsx',
            // refresh: true,
        // }),
        // react(),
    // ],
    // server: {
        // host: 'laratable.local',
        // port: 3000,
        // hmr: {
            // host: 'laratable.local',
        // },
        // proxy: {
            // '/api': {
                // target: 'http://laratable.local:8000',
                // changeOrigin: true,
                // secure: false,
                // ws: true,
            // },
        // },
        // cors: {
            // origin: 'http://laratable.local:8000',
            // // or origin: ['http://laratable.local:8000', 'http://localhost:8000'] if needed
            // methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
            // allowedHeaders: ['*'],
            // credentials: true,
        // }
    // },
// });


import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx'
            ],
            refresh: true,
        }),
        react(),
    ],
    server: {
        host: 'laratable.local',
        port: 3000,
        hmr: {
            host: 'laratable.local',
        },
        proxy: {
            '/api': {
                target: 'http://laratable.local:8000',
                changeOrigin: true,
                secure: false,
                ws: true,
            },
        },
        cors: {
            origin: 'http://laratable.local:8000',
            methods: ['GET','POST','PUT','DELETE','OPTIONS'],
            allowedHeaders: ['*'],
            credentials: true,
        }
    },
})