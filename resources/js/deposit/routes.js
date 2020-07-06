import Deposit from "./Deposit";
import Success from "./result/Success";
import Fail from "./result/Fail";
import BankAccount from "./result/BankAccount";
import PhoneCard from "./result/PhoneCard";

const depositRoutes = [
    {
        path: '/web-views/vue/deposit',
        component: Deposit,
        name: 'deposit',
        meta: {
            auth: true
        }
    },
    {
        path: '/web-views/vue/deposit/result-success',
        component: Success,
        name: 'success',
    },
    {
        path: '/web-views/vue/deposit/result-fail',
        component: Fail,
        name: 'fail'
    },
    {
        path: '/web-views/vue/deposit/result-bank-transfer',
        component: BankAccount,
        name: 'bankAccount',
        meta: {
            auth: true
        }
    },
    {
        path: '/web-views/vue/deposit/result-phone-card',
        component: PhoneCard,
        name: 'phoneCard',
        props: (route) => ({ message: route.query.message }),
        meta: {
            auth: true
        }
    }
];

export default depositRoutes;
