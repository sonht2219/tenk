import Vue from 'vue';
import router from "./router";
import App from "./App";
import store from "./store/store";
import PaymentCommon from "./deposit/payment/handle/PaymentCommon";
import PaymentPhoneCard from "./deposit/payment/handle/PaymentPhoneCard";
import VueMask from 'v-mask';

Vue.component('payment-common', PaymentCommon);
Vue.component('payment-phone-card', PaymentPhoneCard);

Vue.use(VueMask);

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
