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

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;

Vue.prototype.trans = new Lang({messages, locale: default_locale, fallback: fallback_locale});

const VueScrollTo = require('vue-scrollto');
Vue.use(VueScrollTo);

var CountryLanguage = require('country-language');

import VueSlideoutPanel from 'vue2-slideout-panel';
Vue.use(VueSlideoutPanel);

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: '#7cc9fd',
    failedColor: 'red',
    height: '2px'
})

import {scroller} from 'vue-scrollto/src/scrollTo'

import VueGtag from "vue-gtag";

Vue.use(VueGtag, {
    config: { id: "G-0000000000" }
});

const app = document.getElementById('app');

Vue.component('register', require('@/Pages/Auth/Register.vue').default);
Vue.component('login', require('@/Pages/Auth/Login.vue').default);
Vue.component('forgot-password', require('@/Pages/Auth/ForgotPassword.vue').default);

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
            registration: null,
            login: null,
            forgotPassword: null,
            registrationType: 'student'
        },
        registrationAddonData: null,
        languageList: null,
        locale: window.default_locale,
        cookiePolicy: {
            accepted: false
        },
        fee: 1.2,
        languageToCountry: {
            "hu": "hu",
            "es": "es",
            "am": "hy",
            "cz": "cs",
            "dk": "da",
            "ee": "et",
            "gr": "el",
            "ff": "ful",
            "he": "il",
            "io": "ido",
            "jp": "ja",
            "ge": "ka",
            "lo": "lao",
            "se": "sv",
            "si": "sl",
            "rs": "sr",
            "tw": "tvi",
            "vn": "vi",
            "cn": "zh",
            "en": "gb",
            "de": "de",
            "fr": "fr",
            "it": "it",
            "ru": "ru",
            "nl": "nl",
            "ar": "sa",
            "no": "no",
            "uk": "ua"
        }
    },
    watch: {
        'cookiePolicy.accepted'(accepted) {
            this.$cookie.set('cookie-policy', accepted);
        }
    },
    mounted() {
        window.onpopstate = () => this.pageChange(document.location);

        this.$inertia.on('start', event => this.pageChange(event.detail.visit.url));

        this.$inertia.on('before', () => {
            this.$Progress.start();
            scrollLock.enablePageScroll();
        });

        this.$inertia.on('success', () => {
            this.$Progress.finish();
        });

        this.$inertia.on('error', () => {
            this.$Progress.fail();
        });

        this.cookiePolicy.accepted = this.$cookie.get('cookie-policy') || false;

        this.getViewportSize();

        window.onresize = event => {
            this.getViewportSize();
        };

        if (window.location.hash === '#login') {
            this.openLoginPopup();
        }

        if (window.location.hash === '#registration') {
            this.openRegistrationPopup();
        }

        if (window.location.hash === '#teacher-registration') {
            this.popup.registrationType = 'teacher';
            this.openRegistrationPopup();
        }

        if (window.location.hash === '#lost-password') {
            this.openForgotPasswordPopup();
        }

        this.getCurrencyExchange();

        this.languageList = require('@cospired/i18n-iso-languages');
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/en.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/hu.json'));
        this.languageList.registerLocale(require('@cospired/i18n-iso-languages/langs/de.json'));

        this.languageList = this.languageList.getNames(this.locale, {select: 'official'});
    },
    methods: {
        getCountryCode(languageCode) {
            if (!this.languageToCountry[languageCode]) {
                return null;
            }

            return this.languageToCountry[languageCode];
        },
        initHashScroll() {
            if (!location.hash) {
                return;
            }

            let hashedElement = $(location.hash);
            if (!hashedElement || !hashedElement.offset()) {
                return;
            }

            let hashedElementTop = hashedElement.offset().top;

            $("html, body").animate({
                scrollTop: hashedElementTop - 70
            }, 600);
        },
        documentTitle(title, append = true) {
            let finalTitle = title;

            if (append) {
                let documentTitleAppend = this.trans.get('other.document_title_append');
                finalTitle = title + documentTitleAppend;
            }

            document.title = finalTitle;
        },
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
            this.popup.registrationType = type;

            this.hideLoginPopup();
            this.hideForgotPasswordPopup();

            this.popup.registration = this.$showPanel({
                component : 'register',
                openOn: 'right',
                width: 600
            });
        },
        hideRegistrationPopup() {
            if (!this.popup.registration) {
                return;
            }
            this.popup.registration.hide();
            this.popup.registration = null;
        },
        openLoginPopup() {
            this.hideRegistrationPopup();
            this.hideForgotPasswordPopup();

            this.popup.login = this.$showPanel({
                component : 'login',
                openOn: 'right',
                width: 600
            });
        },
        hideLoginPopup() {
            if (!this.popup.login) {
                return;
            }
            this.popup.login.hide();
            this.popup.login = null;
        },
        openForgotPasswordPopup() {
            this.hideLoginPopup();
            this.hideRegistrationPopup();

            this.popup.forgotPassword = this.$showPanel({
                component : 'forgot-password',
                openOn: 'right',
                width: 600
            });
        },
        hideForgotPasswordPopup() {
            if (!this.popup.forgotPassword) {
                return;
            }
            this.popup.forgotPassword.hide();
            this.popup.forgotPassword = null;
        },
        getUrlVars() {
            let vars = {};
            window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });

            return vars;
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
        siteLanguage() {
            return this.$page.props.user ? this.$page.props.user.site_language : 'hu';
        },
        calendarType() {
            if (this.viewport.w > 700) {
                return 'timeGridWeek';
            }

            return 'timeGridDay';
        },
        isCurrentUserTeacher() {
            if (!this.$page.props.user) {
                return false;
            }

            return this.$page.props.user.role === 'teacher';
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
