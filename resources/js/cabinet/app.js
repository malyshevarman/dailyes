import './bootstrap';

import 'owl.carousel/dist/owl.carousel.min';

import 'moment/moment';
import './plugins/daterangepicker';
import './plugins/bootstrap-slider.min';

import 'jquery-validation/dist/jquery.validate.min';

import 'infinite-scroll/dist/infinite-scroll.pkgd.min'

import './plugins/simplebar.min';

window.Vue = require('vue');

// Dependencies --------------------------------------

import Toasted from 'vue-toasted';
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert';
import VueContentPlaceholders from 'vue-content-placeholders'

import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/antd.css'
Vue.use(Antd)

Vue.use(require('vue-moment'));


Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position: 'bottom-center',
    duration: 3500
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import {yandexMap, ymapMarker} from 'vue-yandex-maps'
Vue.component('yandex-map', yandexMap)
Vue.component('ymap-marker', ymapMarker)


import VueMask from 'v-mask'
Vue.use(VueMask);

// Select Single
Vue.component('select-single', require('./components/SelectSingle.vue'));

// Layout
Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('register', require('./components/auth/Register.vue'));
Vue.component('forgot', require('./components/auth/Forgot.vue'));
Vue.component('reset', require('./components/auth/Reset.vue'));

Vue.component('rulesplacement', require('./components/rulesplacement'));

//City
Vue.component('city_option', require('./components/city/CityOption.vue'));
Vue.component('city_select', require('./components/city/CitySelect.vue'));

// Subscriber Form
Vue.component('subscriber', require('./components/Subscriber.vue'));

// Profile
Vue.component('profile', require('./components/profile/Profile.vue'));
Vue.component('profile-password', require('./components/profile/Password.vue'));

// Метка избранного
Vue.component('bookmark', require('./components/Bookmark.vue'));
Vue.component('companyBookmark', require('./components/CompanyBookmark.vue'));

// Company
Vue.component('companies-form', require('./components/company/Form.vue'));

// Select Company Categories
Vue.component('select-company-categories', require('./components/SelectCompanyCategories.vue'));

// Company and Event Gallery Items
Vue.component('gallery-index', require('./components/gallery/Index.vue'));

// Image Upload
Vue.component('image-upload', require('./components/ImageUpload.vue'))

// Company Addresses
Vue.component('company-addresses-index', require('./components/company/address/Index.vue'));
Vue.component('company-addresses-form', require('./components/company/address/Form.vue'));

// Event
Vue.component('events-form', require('./components/event/Form.vue'));
Vue.component('events-stat', require('./components/event/Stat.vue'));

//PROFILE
Vue.component('deleteprodile', require('./components/deleteprofile.vue'));


// Input Autocomplete
Vue.component('input-autocomplete', require('./components/InputAutocomplete.vue'));

// Select Event Categories
Vue.component('select-event-categories', require('./components/SelectEventCategories.vue'));

// Event Addresses
Vue.component('event-addresses-index', require('./components/event/address/Index.vue'));

// Business Comments
Vue.component('business-comment-show', require('./components/business/comment/Show.vue'));

// Business Questions
Vue.component('business-question-show', require('./components/business/question/Show.vue'));

// Cabinet Comments
Vue.component('cabinet-comment-show', require('./components/cabinet/comment/Show.vue'));

// Cabinet Questions
Vue.component('cabinet-question-show', require('./components/cabinet/question/Show.vue'));

// Cabinet Settings
Vue.component('settings-index', require('./components/settings/Index.vue'));

Object.defineProperty(Vue.prototype, "$bus", {
    get: function () {
        return this.$root.bus;
    }
});

const app = new Vue({
    el: '#app',
    data: {
        bus: new Vue({})
    }
});
