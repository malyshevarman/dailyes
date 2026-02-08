import './bootstrap';

import 'owl.carousel/dist/owl.carousel.min';

import 'moment/moment';
import './plugins/daterangepicker';
import './plugins/bootstrap-slider.min';

import 'jquery-validation/dist/jquery.validate.min';

import 'infinite-scroll/dist/infinite-scroll.pkgd.min'

import './plugins/simplebar.min';

import '@fancyapps/fancybox';

window.Vue = require('vue');

// Dependencies --------------------------------------

import Toasted from 'vue-toasted';
import VueClip from 'vue-clip'
import Multiselect from 'vue-multiselect'
import swal from 'sweetalert';
import VueContentPlaceholders from 'vue-content-placeholders'

import Antd from 'ant-design-vue'

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

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueMask from 'v-mask'
Vue.use(VueMask);

import YmapPlugin from 'vue-yandex-maps'
const settings = {
  apiKey: 'f679a5dd-9081-411e-abf2-ac4a32c74e0c',
  lang: 'ru_RU',
  coordorder: 'latlong',
}
Vue.use(YmapPlugin, settings)


Vue.component('modal', require('./components/modal.vue'));

// Layout
Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('register', require('./components/auth/Register.vue'));
Vue.component('forgot', require('./components/auth/Forgot.vue'));
Vue.component('reset', require('./components/auth/Reset.vue'));


// Vue.component('rulesplacement', require('./components/rulesplacement'));
// Vue.component('rulesmailing', require('./components/rulesmailing'));

//City
Vue.component('city_option', require('./components/city/CityOption.vue'));
Vue.component('city_select', require('./components/city/CitySelect.vue'));

// Subscriber Form
Vue.component('subscriber', require('./components/Subscriber.vue'));

// Карта с отображением адресов
Vue.component('addressesMap', require('./components/AddressesMap.vue'));
Vue.component('companyMap', require('./components/CompanyMap.vue'));
Vue.component('addressesCarousel', require('./components/AddressesCarousel.vue'));
// Карта на странице контактов
Vue.component('contactmap', require('./components/contactmap.vue'));
Vue.component('coockie', require('./components/coockie.vue'));


// Метка избранного
Vue.component('bookmark', require('./components/Bookmark.vue'));
Vue.component('companyBookmark', require('./components/CompanyBookmark.vue'));

// система отзывов рейтинга и оценок
Vue.component('ratingHeader', require('./components/event/RatingHeader.vue'));
Vue.component('recommendationHeader', require('./components/event/RecommendationHeader.vue'));

// система отзывов рейтинга и оценок для компании
Vue.component('companyRatingHeader', require('./components/company/RatingHeader.vue'));
Vue.component('companyRecommendationHeader', require('./components/company/RecommendationHeader.vue'));

//Форма на странице помощь
Vue.component('questionform', require('./components/QuestionForm.vue'));

//Форма на странице контакты
Vue.component('contactform', require('./components/ContactForm.vue'));

//Форма на странице реклама
Vue.component('advertisingform', require('./components/AdvertisingForm.vue'));

//Форма на странице контакты
Vue.component('blogform', require('./components/Blogform.vue'));

//Кнопка определения координат местоположения пользователя
Vue.component('getposition', require('./components/GetPosition.vue'))
Vue.component('getpositionmob', require('./components/GetPositionMob.vue'))

//Модалка на странице компаний
Vue.component('ModalMapIndex', require('./components/company/map-modal/ModalMapIndex.vue'))
//Меню категорий в шапке модалки с картой
Vue.component('ModalMapHeaderCategories', require('./components/company/map-modal/ModalMapHeaderCategories.vue'))
//Список слева от карты в модалке
Vue.component('ModalMapLeftSideListItems', require('./components/company/map-modal/ModalMapLeftSideListItems.vue'))
//Фильтр в шапке модалки
Vue.component('ModalMapFilter', require('./components/company/map-modal/ModalMapFilter.vue'));
//Карта в модалке
Vue.component('ModalMap', require('./components/company/map-modal/ModalMap.vue'));
//Формы отзыва и ответа на отзыв на странице компании
Vue.component('company-reivews-form', require('./components/company/ReviewsForm.vue'));
Vue.component('company-reivew-answers-form', require('./components/company/ReviewAnswersForm.vue'));
//Форма владельца компании
Vue.component('owner-form', require('./components/company/OwnerForm.vue'));



//Модалка на странице акций
Vue.component('EventModalMapIndex', require('./components/event/map-modal/ModalMapIndex.vue'))
//Меню категорий в шапке модалки с картой
Vue.component('EventModalMapHeaderCategories', require('./components/event/map-modal/ModalMapHeaderCategories.vue'))
//Список слева от карты в модалке
Vue.component('EventModalMapLeftSideListItems', require('./components/event/map-modal/ModalMapLeftSideListItems.vue'))
//Фильтр в шапке модалки
Vue.component('EventModalMapFilter', require('./components/event/map-modal/ModalMapFilter.vue'));
//Карта в модалке
Vue.component('EventModalMap', require('./components/event/map-modal/ModalMap.vue'));
//Формы отзыва и ответа на отзыв на странице акции
Vue.component('event-reivews-form', require('./components/event/ReviewsForm.vue'));
Vue.component('event-reivew-answers-form', require('./components/event/ReviewAnswersForm.vue'));

Vue.component('MainPageMap', require('./components/MainPageMap.vue'));
Object.defineProperty(Vue.prototype, "$bus", {
    get: function () {
        return this.$root.bus;
    }
});

const router = new VueRouter({
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router,
    data: {
        bus: new Vue({})
    }
});
