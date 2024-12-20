import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp, usePage} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';

import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {library} from "@fortawesome/fontawesome-svg-core";

import {fas} from "@fortawesome/free-solid-svg-icons";

library.add(fas);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';


createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(ZiggyVue)
            .mixin({
                methods: {
                    can: function (permissions) {
                        var allPermissions = usePage().props.auth.can;
                        var hasPermission = false;
                        permissions.forEach(function (item) {
                            if (allPermissions[item]) hasPermission = true;
                        });
                        return hasPermission;
                    }, lang: function () {
                        return usePage().props.language.original;
                    },
                },
            })
            .mount(el);
    },
    progress: {
        color: '#f56036',
    },
});
