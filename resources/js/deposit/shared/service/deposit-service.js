import {httpClient} from "../../../shared/service";

const depositCash = (data) => {
    return httpClient.post('transactions/deposit-cash', data);
};
const getBankAccount = () => {
    return httpClient.get('transactions/bank-account');
};

export default {
    depositCash,
    getBankAccount
}
