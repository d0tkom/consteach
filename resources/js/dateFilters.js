import Vue from 'vue';
import vueMoment from 'vue-moment'
import Moment from 'moment-timezone';
import { extendMoment } from 'moment-range';

window.moment = extendMoment(Moment);
const moment = extendMoment(Moment);

require('moment/locale/hu')

Vue.use(vueMoment, {
    moment
})