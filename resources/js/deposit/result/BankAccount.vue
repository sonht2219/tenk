<template>
    <div class="wrap-bank" v-if="bankAccount && transaction">
        <h4>Vui lòng chuyển khoản theo hóa đơn</h4>
        <div class="bank-content">
            <div class="bank-info">
                <p>- Ngân hàng: <span class="font-weight-bold ml-2">{{ getProp(bankAccount, 'bank_name') }}</span></p>
                <p>- Chủ tài khoản: <span class="font-weight-bold ml-2">{{ getProp(bankAccount, 'owner_name') }}</span></p>
                <p>- Số tài khoản: <span class="font-weight-bold ml-2">{{ getProp(bankAccount, 'bank_id') }}</span></p>
                <p>- Chi nhánh: <span class="font-weight-bold ml-2">{{ getProp(bankAccount, 'bank_branch') }}</span></p>
            </div>

            <div class="transaction-info">
                <p class="font-weight-bolder">- Số tiền: {{ getProp(transaction, 'transaction_cash_detail.value_original').toLocaleString('us') }} VNĐ</p>
                <p class="text-success">- Nội dung chuyển khoản: {{ getProp(transaction, 'id') }}</p>
                <p class="text-danger">* Lưu ý: Bắt buộc phải ghi nội dung chuyển khoản khi chuyển tiền.</p>
                <p class="text-danger">* Nếu quên ghi nội dung chuyển khoản, hãy liên hệ vào email: contact.tenk@gmail.com.</p>
            </div>
        </div>
    </div>
</template>

<script>
    import depositService from '../shared/service/deposit-service';
    import {MIXINS} from "../../shared";
    import { mapState } from 'vuex';
    export default {
        name: "BankAccount",
        mixins: [MIXINS],
        data: () => ({
            bankAccount: null
        }),
        created() {
            this.getBankAccount();
        },
        methods: {
            getBankAccount() {
                this.showLoading();
                depositService
                    .getBankAccount()
                    .then(resp => {
                        this.bankAccount = this.getProp(resp, 'data.data');
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.hideLoading());
            }
        },
        computed: {
            ...mapState('depositStore', ['transaction'])
        }
    }
</script>

<style scoped>
    .wrap-bank {
        padding: 20px 10px;
    }
    .bank-content {
        border: 1px solid #c0c5ce;
        padding: 10px;
        margin-top: 20px;
    }
    .bank-info {
        border-bottom: 1px solid #c0c5ce;
    }
    .transaction-info {
        margin-top: 20px;
    }
</style>
