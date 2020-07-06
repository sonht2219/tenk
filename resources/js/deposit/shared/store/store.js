import {
    CHOOSE_METHOD,
    DEPOSIT_CASH, GET_TELCOS_PHONE_CARD, GET_VALUES_CARD_PHONE_CARD,
    UPDATE_AMOUNT,
    UPDATE_CODE_PHONE_CARD,
    UPDATE_SERI_PHONE_CARD, UPDATE_SITUATION_FORM, UPDATE_TELCO_PHONE_CARD,
    UPDATE_TRANSACTION, UPDATE_VALUE_PHONE_CARD
} from './actions';
import depositService from '../service/deposit-service';
import get from 'lodash/get';
import {PAYMENT_METHODS} from "../../../shared";

const methods = [
    {
        id: PAYMENT_METHODS.MOMO,
        name: 'MoMo',
        icon: require('../../../assets/images/logo-momo.png'),
        component: 'payment-common',
        component_result: 'success'
    },
    {
        id: PAYMENT_METHODS.THE_CAO,
        name: 'Thẻ cào',
        icon: require('../../../assets/images/logo-phone-card.png'),
        component: 'payment-phone-card',
        component_result: 'phoneCard'
    },
    {
        id: PAYMENT_METHODS.TRANSFER_BANK,
        name: 'Chuyển khoản',
        icon: require('../../../assets/images/logo-bank.png'),
        component: 'payment-common',
        component_result: 'bankAccount'
    },
];

const state = () => ({
    methods,
    methodSelected: methods[0],
    amount: null,
    transaction: null,
    readyForm: false,
    phoneCard: {
        seri: null,
        code: null,
        telco: '',
        value: ''
    },
    telcos: [],
    valuesCard: []
});

const getters = {};

const mutations = {
    [CHOOSE_METHOD] (state, data) {
        state.methodSelected = data;
    },
    [UPDATE_AMOUNT] (state, data) {
        state.amount = data;
    },
    [UPDATE_TRANSACTION] (state, data) {
        state.transaction = data;
    },
    [GET_TELCOS_PHONE_CARD] (state, data) {
        state.telcos = data;
    },
    [GET_VALUES_CARD_PHONE_CARD] (state, data) {
        state.valuesCard = data;
    },
    [UPDATE_SERI_PHONE_CARD] (state, data) {
        state.phoneCard.seri = data;
    },
    [UPDATE_CODE_PHONE_CARD] (state, data) {
        state.phoneCard.code = data;
    },
    [UPDATE_TELCO_PHONE_CARD] (state, data) {
        state.phoneCard.telco = data;
    },
    [UPDATE_VALUE_PHONE_CARD] (state, data) {
        state.amount = data;
        state.phoneCard.value = data;
    },
    [UPDATE_SITUATION_FORM] (state, data) {
        state.readyForm = data;
    }
};

const actions = {
    [DEPOSIT_CASH] ({commit}, data) {
        return new Promise((resolve, reject) => {
            depositService
                .depositCash(data)
                .then((resp) => {
                    console.log(get(resp, 'data.data'));
                    commit(UPDATE_TRANSACTION, get(resp, 'data.data'));
                    resolve(resp);
                })
                .catch(error => reject(error));
        })
    },
    [GET_TELCOS_PHONE_CARD] ({commit}) {
        return new Promise((resolve, reject) => {
            depositService
                .getTelcos()
                .then((resp) => {
                    commit(GET_TELCOS_PHONE_CARD, get(resp, 'data.datas'));
                    resolve(resp);
                })
                .catch(error => reject(error));
        })
    },
    [GET_VALUES_CARD_PHONE_CARD] ({commit}) {
        return new Promise((resolve, reject) => {
            depositService
                .getValuesCard()
                .then((resp) => {
                    commit(GET_VALUES_CARD_PHONE_CARD, get(resp, 'data.datas'));
                    resolve(resp);
                })
                .catch(error => reject(error));
        })
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
