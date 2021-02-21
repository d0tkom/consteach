import Vue from 'vue';
import vueMoment from 'vue-moment'
import Moment from 'moment';
import { extendMoment } from 'moment-range';

const moment = extendMoment(Moment);

require('moment/locale/hu')

Vue.use(vueMoment, {
    moment
})