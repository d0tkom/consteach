require('./bootstrap');

import { app, plugin } from '@inertiajs/inertia-vue';
import Vue from 'vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import Lang from 'lang.js';
import messages from './../assets/js/ll_messages';


window.Lang = Lang;
window.Vue = Vue;

Vue.mixin({ methods: { route } });
Vue.use(plugin);
Vue.use(InertiaForm);
Vue.use(PortalVue);

const default_locale = window.default_locale;
const fallback_locale = window.fallback_locale;

Vue.prototype.trans = new Lang({messages, locale: default_locale, fallback: fallback_locale});

const el = document.getElementById('app');

new Vue({
    render: (h) =>
        h(app, {
            props: {
                initialPage: JSON.parse(el.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(el);
