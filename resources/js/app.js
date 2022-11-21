import './bootstrap';
import '../css/app.css';
import Pusher from "pusher-js"
import Echo from "laravel-echo"
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Toast from "vue-toastification";
import CKEditor from '@ckeditor/ckeditor5-vue';
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(Toast)
            .use( CKEditor )
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

Pusher.logToConsole = false;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '55bd494d74078517df67',
    cluster: 'sa1',
    encrypted: true,
});



// resources/assets/js/bootstrap.js

