import Vue from 'vue';
import router from "./router";
import App from "./App";
import store from "./store/store";
import PaymentCommon from "./deposit/payment/handle/PaymentCommon";
import PaymentPhoneCard from "./deposit/payment/handle/PaymentPhoneCard";
import VueMask from 'v-mask';
import './assets/css/style.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Vuelidate from 'vuelidate';

Vue.component('payment-common', PaymentCommon);
Vue.component('payment-phone-card', PaymentPhoneCard);

Vue.use(VueMask);
Vue.use(Loading);
Vue.use(Vuelidate);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
