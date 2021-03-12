require('@/bootstrap');
require('@/dateFilters');
require('@/globalComponents')
require('@/notification')

import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import PortalVue from 'portal-vue';
import Lang from 'lang.js';
import messages from './../assets/js/ll_messages';
import { directive as onClickOutside } from 'vue-on-click-outside'

const VueCookie = require('vue-cookie');

Vue.use(VueCookie);

import FlagIcon from 'vue-flag-icon'
Vue.use(FlagIcon);

window.Lang = Lang;

Vue.mixin({ methods: { route } });
Vue.directive('on-click-outside', onClickOutside)
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
import scrollLock from 'scroll-lock';

import VTooltip from 'v-tooltip'

Vue.use(VTooltip)

import CountryFlag from 'vue-country-flag';
Vue.component('country-flag', CountryFlag)

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;

Vue.prototype.trans = new Lang({messages, locale: default_locale, fallback: fallback_locale});

const app = document.getElementById('app');

new Vue({
    data: {
        viewport: {
            w: null,
            h: null
        },
        popup: {
            login: false,
            registration: false,
            lostPassword: false,
            registrationType: 'student'
        },
        cookiePolicy: {
            accepted: false
        }
    },
    watch: {
        'cookiePolicy.accepted'(accepted) {
            this.$cookie.set('cookie-policy', accepted);
        }
    },
    mounted() {
        this.cookiePolicy.accepted = this.$cookie.get('cookie-policy') || false;

        this.getViewportSize();

        window.onresize = event => {
            this.getViewportSize();
        };

        if (window.location.hash === '#login') {
            this.popup.login = true;
        }

        if (window.location.hash === '#registration') {
            this.popup.registration = true;
        }

        if (window.location.hash === '#teacher-registration') {
            this.popup.registrationType = 'teacher';
            this.popup.registration = true;
        }

        if (window.location.hash === '#lost-password') {
            this.popup.lostPassword = true;
        }

        this.$inertia.on('before', () => {
            scrollLock.enablePageScroll();
        })
    },
    methods: {
        getViewportSize() {
            const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
            const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);

            this.viewport.w = vw;
            this.viewport.h = vh;
        },
        sortAlphabetByName(a, b) {
            return a.name.localeCompare(b.name);
        }
    },
    computed: {
        calendarType() {
            if (this.viewport.w > 700) {
                return 'timeGridWeek';
            }

            return 'timeGridDay';
        }
    },
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
