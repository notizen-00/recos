import './bootstrap';
import '../css/app.css';

import {createApp, h} from 'vue';
import {createInertiaApp, usePage} from '@inertiajs/vue3';
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';

<<<<<<< Updated upstream
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faPhone,faHome,faCog,faBuilding,faList,faSignIn, faSignOut,faUser, faRightFromBracket, faUsers,faPaperPlane, faEnvelope,faBell, faEye, faEdit } from "@fortawesome/free-solid-svg-icons";

library.add(faPhone,faHome,faCog,faBuilding,faList,faSignIn,faSignOut,faUser,faRightFromBracket,faUsers,faPaperPlane,faEnvelope,faBell,faEye,faEdit);
=======
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {library} from "@fortawesome/fontawesome-svg-core";
import {
    faBell,
    faBuilding,
    faCog,
    faEdit,
    faEnvelope,
    faEye,
    faHome,
    faList,
    faPaperPlane,
    faPersonCircleCheck,
    faPhone,
    faRightFromBracket,
    faSignIn,
    faSignOut,
    faUser,
    faUserCheck,
    faUsers
} from "@fortawesome/free-solid-svg-icons";

library.add(faPhone, faHome, faCog, faBuilding, faList, faSignIn, faSignOut, faUser, faRightFromBracket, faUsers, faPaperPlane, faEnvelope, faBell, faEye, faEdit, faPersonCircleCheck, faUserCheck);
>>>>>>> Stashed changes

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