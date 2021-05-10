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
        },
        fee: 1.2,
        languageToCountry: {
            "aa": "afar",
            "ab": "abház",
            "ae": "avesztai",
            "af": "afrikaans",
            "ak": "akan",
            "am": "hy",
            "an": "aragóniai",
            "ar": "arab",
            "as": "asszámi",
            "av": "avar",
            "ay": "ajmara",
            "az": "azeri",
            "ba": "baskír",
            "be": "belarusz",
            "bg": "bolgár",
            "bh": "maithili",
            "bi": "biszlama",
            "bm": "bambara",
            "bn": "bengáli",
            "bo": "tibeti",
            "br": "breton",
            "bs": "bosnyák",
            "ca": "valenciai",
            "ce": "csecsen",
            "ch": "csamorro",
            "co": "korzikai",
            "cr": "krí",
            "cz": "cs",
            "cu": "óegyházi szláv",
            "cv": "csuvas",
            "cy": "walesi",
            "dk": "da",
            "de": "német",
            "dv": "maldív",
            "dz": "dzongkha",
            "ee": "et",
            "gr": "el",
            "en": "angol",
            "eo": "eszperantó",
            "es": "spanyol",
            "eu": "baszk",
            "fa": "perzsa",
            "ff": "ful",
            "fi": "finn",
            "fj": "fidzsi",
            "fo": "feröeri",
            "fr": "francia",
            "fy": "fríz",
            "ie": "interlingue",
            "gd": "skót gael",
            "gl": "galiciai",
            "gn": "guarani",
            "gu": "gudzsaráti",
            "gv": "manx",
            "ha": "hausza",
            "il": "he",
            "hi": "hindi",
            "ho": "hiri motu",
            "hr": "horvát",
            "ht": "haiti kreol",
            "hu": "magyar",
            "hz": "herero",
            "ia": "interlingva",
            "id": "maláj",
            "ig": "igbó",
            "ii": "nuoszu",
            "ik": "inupiak",
            "io": "ido",
            "is": "izlandi",
            "it": "olasz",
            "iu": "inuktitut",
            "jp": "ja",
            "jv": "jávai",
            "ge": "ka",
            "kg": "kikongo",
            "ki": "kikuju",
            "kj": "kvanyama",
            "kk": "kazak",
            "kl": "grönlandi",
            "km": "khmer",
            "kn": "kannada",
            "kr": "kanuri",
            "ks": "kasmíri",
            "ku": "kurd",
            "kv": "komi",
            "kw": "korni",
            "ky": "kirgiz",
            "la": "latin",
            "lb": "luxemburgi",
            "lg": "luganda",
            "li": "limburgi",
            "ln": "lingala",
            "lo": "lao",
            "lt": "litván",
            "lu": "luba-katanga",
            "lv": "lett",
            "mg": "malgas",
            "mh": "Marshall-szigeteki",
            "mi": "maori",
            "mk": "macedón",
            "ml": "malajálam",
            "mn": "mongol",
            "mr": "maráthi",
            "ms": "maláj",
            "mt": "máltai",
            "my": "burmai",
            "na": "naurui",
            "no": "nynorsk",
            "nd": "északi ndebele",
            "ne": "nepáli",
            "ng": "ndonga",
            "nl": "holland",
            "nr": "déli ndebele",
            "nv": "navahó",
            "ny": "cseva",
            "oc": "okcitán",
            "oj": "odzsibva",
            "om": "oromó",
            "or": "orija",
            "os": "oszét",
            "pa": "pandzsábi",
            "pi": "páli",
            "pl": "lengyel",
            "ps": "pastu",
            "pt": "portugál",
            "qu": "kecsua",
            "rm": "romans",
            "rn": "rundi",
            "ro": "román",
            "ru": "orosz",
            "rw": "kinyarvanda",
            "sa": "szanszkrit",
            "sc": "szárd",
            "sd": "szindhi",
            "se": "sv",
            "sg": "szangó",
            "si": "sl",
            "sk": "szlovák",
            "sm": "szamoai",
            "sn": "sona",
            "so": "szomáli",
            "sq": "albán",
            "rs": "sr",
            "ss": "szvázi",
            "st": "déli szoto",
            "su": "szundai",
            "sw": "szuahéli",
            "ta": "tamil",
            "te": "telugu",
            "tg": "tádzsik",
            "th": "thai",
            "ti": "tigrinya",
            "tk": "türkmén",
            "tl": "tagalog",
            "tn": "csvana",
            "to": "tonga",
            "tr": "török",
            "ts": "conga",
            "tt": "tatár",
            "tw": "tvi",
            "ty": "tahiti",
            "ug": "ujgur",
            "ua": "uk",
            "ur": "urdu",
            "uz": "üzbég",
            "ve": "venda",
            "vn": "vi",
            "vo": "volapük",
            "wa": "vallon",
            "wo": "volof",
            "xh": "xhosza",
            "yi": "jiddis",
            "yo": "joruba",
            "za": "csuang",
            "cn": "zh",
            "zu": "zulu"
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
        getCountryCode(languageCode) {
            console.log(languageCode);

            return languageCode;
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
