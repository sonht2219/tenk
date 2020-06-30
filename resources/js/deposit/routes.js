import Deposit from "./Deposit";
import Success from "./result/Success";
import Fail from "./result/Fail";
import BankAccount from "./result/BankAccount";

const depositRoutes = [
    {
        path: '/web-views/vue/deposit',
        component: Deposit,
        name: 'deposit'
    },
    {
        path: '/web-views/vue/deposit/success',
        component: Success,
        name: 'success'
    },
    {
        path: '/web-views/vue/deposit/fail',
        component: Fail,
        name: 'fail'
    },
    {
        path: '/web-views/vue/deposit/bank-account',
        component: BankAccount,
        name: 'bankAccount'
    }
];

export default depositRoutes;
