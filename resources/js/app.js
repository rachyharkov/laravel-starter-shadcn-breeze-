import '../css/app.css';
import '../css/dataTables.tailwind.css';
import './bootstrap';
import { Icon } from '@iconify/vue';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({
            render: () => h(App, props)
        })

        VueApp.config.globalProperties.$route = route
        VueApp.component('iconify-icon', Icon)
        return VueApp.use(plugin)
                .use(ZiggyVue)
                .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
