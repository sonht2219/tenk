import {CHOOSE_METHOD, DEPOSIT_CASH, UPDATE_AMOUNT, UPDATE_TRANSACTION} from './actions';
import depositService from '../service/deposit-service';
import get from 'lodash/get';

const methods = [
    {
        id: 1,
        name: 'MoMo',
        icon: require('../../../assets/images/logo-momo.png'),
        component: 'payment-common',
        component_result: 'success'
    },
    {
        id: 2,
        name: 'Thẻ cào',
        icon: require('../../../assets/images/logo-phone-card.png'),
        component: 'payment-common',
        component_result: 'success'
    },
    {
        id: 3,
        name: 'Chuyển khoản',
        icon: require('../../../assets/images/logo-bank.png'),
        component: 'payment-common',
        component_result: 'bankAccount'
    },
];

const state = () => ({
    methods,
    methodSelected: methods[0],
    amount: 0,
    transaction: null
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
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
