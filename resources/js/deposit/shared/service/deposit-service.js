import {httpClient} from "../../../shared/service";

const depositCash = (data) => {
    return httpClient.post('transactions/deposit-cash', data);
};
const getBankAccount = () => {
    return httpClient.get('transactions/bank-account');
};
const getTelcos = () => {
    return httpClient.get('phone-card/telcos');
};
const getValuesCard = () => {
    return httpClient.get('phone-card/values-card');
};

export default {
    depositCash,
    getBankAccount,
    getTelcos,
    getValuesCard
}
