/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.googleMapsClient = require('@google/maps').createClient({
    key: 'AIzaSyAHa9IFqVenjsSGJWM0XRucbb0LlV26Qqg',
    Promise: Promise
});

// Dependencies --------------------------------------

import Toasted from 'vue-toasted';
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert';
import VueContentPlaceholders from 'vue-content-placeholders'

import {yandexMap, ymapMarker} from 'vue-yandex-maps'
Vue.component('yandex-map', yandexMap)
Vue.component('ymap-marker', ymapMarker)

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

import VueRouter from 'vue-router'
Vue.use(VueRouter)
const router = new VueRouter({
    mode: 'history'
})

import Antd from 'ant-design-vue'
import 'ant-design-vue/dist/antd.css'
Vue.use(Antd)
import VueMask from 'v-mask'
Vue.use(VueMask);
Vue.use(require('vue-moment'));
Vue.use(Toasted)
Vue.toasted.register('error', message => message, {
    position: 'bottom-center',
    duration: 1000
})
Vue.use(VueClip)
Vue.component('multiselect', Multiselect)
Vue.use(VueContentPlaceholders)

Vue.component('vue-tinymce', require('./components/VueTinymce.vue'))

Vue.component('image-uploader', require('./components/ImageUploader.vue'))

Vue.component('image-upload', require('./components/ImageUpload.vue'))

Vue.component('image-gallery', require('./components/ImageGallery.vue'))
Vue.component('image-gallery-add-item', require('./components/ImageGalleryAddItem.vue'))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Layout
Vue.component('sidebar', require('./components/layout/Sidebar.vue'));

// Dashboard
Vue.component('users-count', require('./components/dashboard/UsersCount.vue'));
Vue.component('roles-count', require('./components/dashboard/RolesCount.vue'));
Vue.component('companies-count', require('./components/dashboard/CompaniesCount.vue'));
Vue.component('events-count', require('./components/dashboard/EventsCount.vue'));

// Users
Vue.component('users-index', require('./components/users/Index.vue'));
Vue.component('users-create', require('./components/users/Create.vue'));
Vue.component('users-edit', require('./components/users/Edit.vue'));

// Roles
Vue.component('roles-index', require('./components/roles/Index.vue'));
Vue.component('roles-create', require('./components/roles/Create.vue'));
Vue.component('roles-edit', require('./components/roles/Edit.vue'));

// City
Vue.component('cities-index', require('./components/city/Index.vue'));
Vue.component('cities-form', require('./components/city/Form.vue'));

// Event
Vue.component('events-index', require('./components/event/Index.vue'));
Vue.component('events-form', require('./components/event/Form.vue'));

// Event Category
// Vue.component('event-categories-index', require('./components/event/category/Index.vue'));
// Vue.component('event-categories-form', require('./components/event/category/Form.vue'));

// Event Label
Vue.component('event-labels-index', require('./components/event/label/Index.vue'));
Vue.component('event-labels-form', require('./components/event/label/Form.vue'));

// Company
Vue.component('companies-index', require('./components/company/Index.vue'));
Vue.component('companies-form', require('./components/company/Form.vue'));

// Company Category
// Vue.component('company-categories-index', require('./components/company/category/Index.vue'));
// Vue.component('company-categories-form', require('./components/company/category/Form.vue'));


// Category
Vue.component('categories-index', require('./components/category/Index.vue'));
Vue.component('categories-form', require('./components/category/Form.vue'));

// CategoryTags
Vue.component('tags-index', require('./components/tags/Index.vue'));
Vue.component('tags-form', require('./components/tags/Form.vue'));

// Page
Vue.component('pages-index', require('./components/page/Index.vue'));
Vue.component('pages-create', require('./components/page/Create.vue'));
Vue.component('pages-edit', require('./components/page/Edit.vue'));

// Subscriber
Vue.component('subscribers-index', require('./components/subscriber/Index.vue'));
Vue.component('subscribers-create', require('./components/subscriber/Create.vue'));
Vue.component('subscribers-edit', require('./components/subscriber/Edit.vue'));

// Slide
Vue.component('slides-index', require('./components/slide/Index.vue'));
Vue.component('slides-form', require('./components/slide/Form.vue'));

// Tile
Vue.component('tiles-index', require('./components/tile/Index.vue'));
Vue.component('tiles-form', require('./components/tile/Form.vue'));

// Selection
Vue.component('selections-index', require('./components/selection/Index.vue'));
Vue.component('selections-form', require('./components/selection/Form.vue'));

// Blog
Vue.component('blog-index', require('./components/blog/Index.vue'));
Vue.component('blog-form', require('./components/blog/Form.vue'));

// Company Addresses
Vue.component('company-addresses-index', require('./components/company/address/Index.vue'));
Vue.component('company-addresses-form', require('./components/company/address/Form.vue'));

// Company Addresses
Vue.component('event-addresses-index', require('./components/event/address/Index.vue'));

// Company and Event Gallery Items
Vue.component('gallery-index', require('./components/gallery/Index.vue'));

// Select Search
Vue.component('select-search', require('./components/SelectSearch.vue'));

// Input Autocomplete
Vue.component('input-autocomplete', require('./components/InputAutocomplete.vue'));

// Select Event Categories
Vue.component('select-event-categories', require('./components/SelectEventCategories.vue'));

// Select Company Categories
Vue.component('select-company-categories', require('./components/SelectCompanyCategories.vue'));

// Select Event Labels
Vue.component('select-event-labels', require('./components/SelectEventLabels.vue'));

// Select Single
Vue.component('select-single', require('./components/SelectSingle.vue'));

// Banner
Vue.component('banners-index', require('./components/banner/Index.vue'));
Vue.component('banners-form', require('./components/banner/Form.vue'));

// Banner Places
Vue.component('banner-places-index', require('./components/banner/place/Index.vue'));
Vue.component('banner-places-form', require('./components/banner/place/Form.vue'));

// Comments and answers
Vue.component('comment-index', require('./components/comment/Index.vue'));
Vue.component('comment-answer-index', require('./components/comment/answer/Index.vue'));

// Questions and answers
Vue.component('question-index', require('./components/question/Index.vue'));
Vue.component('question-answer-index', require('./components/question/answer/Index.vue'));

// Reports
Vue.component('report-index', require('./components/report/Index.vue'));
Vue.component('report-company', require('./components/report/Company.vue'));

// Reports
Vue.component('newsletter-index', require('./components/newsletter/Index.vue'));
Vue.component('newsletter-form', require('./components/newsletter/Form.vue'));

Object.defineProperty(Vue.prototype, "$bus", {
    get: function () {
        return this.$root.bus;
    }
});

const app = new Vue({
    el: '#app',
    router,
    data: {
        bus: new Vue({})
    },
});
