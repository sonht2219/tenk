import Vue from 'vue';
import Vuex from 'vuex';
import {depositStore} from "../deposit";
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        depositStore
    }
})
