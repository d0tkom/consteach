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

const VueScrollTo = require('vue-scrollto');
Vue.use(VueScrollTo);

const app = document.getElementById('app');

import {scroller} from 'vue-scrollto/src/scrollTo'

import VueGtag from "vue-gtag";

Vue.use(VueGtag, {
    config: { id: "G-0000000000" }
});

new Vue({
    data: {
        viewport: {
            w: null,
            h: null
        },
        currencies: {
            EUR: null,
            USD: null
        },
        popup: {
            login: false,
            registration: false,
            lostPassword: false,
            registrationType: 'student'
        },
        registrationAddonData: null,
        languageList: null,
        locale: window.default_locale,
        cookiePolicy: {
            accepted: false
        }
    },
    watch: {
        '$inertia'(e) {
            console.log(e);
            this.pageChange();
        },
        'cookiePolicy.accepted'(accepted) {
            this.$cookie.set('cookie-policy', accepted);
        }
    },
    mounted() {
        window.onpopstate = () => this.pageChange(document.location);

        this.$inertia.on('start', event => this.pageChange(event.detail.visit.url));

        this.$inertia.on('before', () => {
            scrollLock.enablePageScroll();
        });

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

        this.getCurrencyExchange();

        this.languageList = require('@cospired/i18n-iso-languages');
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));

        this.languageList = this.languageList.getNames(this.locale, {select: 'official'});
    },
    methods: {
        scrollToElement(selector) {
            const firstScrollTo = scroller();

            firstScrollTo(selector);
        },
        pageChange(url) {
            this.$gtag.pageview({
                page_path: url,
            });
        },
        openRegistrationPopup(type = 'student') {
            this.popup.lostPassword = false;
            this.popup.login = false;
            this.popup.registrationType = type;
            this.popup.registration = true;
        },
        getUrlVars() {
            let vars = {};
            window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });

            return vars;
        },
        openLoginPopup() {
            this.popup.registration = false;
            this.popup.lostPassword = false;
            this.popup.login = true;
        },
        getCurrencyExchange() {
            axios.get('/currency').then(({data}) => {
                this.currencies.EUR = data.EUR;
                this.currencies.USD = data.USD;
            }).catch(error => {
                console.error(error);
            });
        },
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
