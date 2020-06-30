<template>
    <div class="content">
        <div class="title">
            Nạp Xu
        </div>
        <method v-if="currentStep === step.method"/>
        <payment v-if="currentStep === step.payment"/>
        <div class="btn-deposit">
            <template v-if="currentStep === step.method">
                <button type="button" class="btn-method" @click="nextStep" :disabled="!methodSelected" :class="{ disabled: !methodSelected }">Tiếp tục</button>
            </template>
            <template v-if="currentStep === step.payment">
                <button type="button" class="btn-payment" @click="prevStep">Quay lại</button>
                <button type="button" class="btn-payment" @click="confirmDeposit">Xác nhận</button>
            </template>
        </div>
    </div>
</template>

<script>
    import Method from "./method/Method";
    import Payment from "./payment/Payment";
    import { mapState } from 'vuex';
    import {DEPOSIT_CASH} from "./shared";
    import { mapActions } from 'vuex';
    import {MIXINS} from "../shared";

    export default {
        name: "Deposit",
        components: {Payment, Method},
        mixins: [MIXINS],
        data: () => ({
            step: {
                method: 1,
                payment: 2
            },
            currentStep: 1
        }),
        methods: {
            ...mapActions('depositStore', {
                depositCash: DEPOSIT_CASH
            }),
            nextStep() {
                this.currentStep++;
            },
            prevStep() {
                this.currentStep--;
            },
            confirmDeposit() {
                const data = {
                    payment_method: this.methodSelected.id,
                    value_original: this.amount,
                    success: 1
                };
                this.showLoading();
                this.depositCash(data)
                    .then(resp => {
                        this.$router.push({ name: this.methodSelected.component_result })
                    })
                    .catch(error => alert(error.response.data.message))
                    .finally(() => this.hideLoading());
            }
        },
        computed: {
            ...mapState('depositStore', ['methodSelected', 'amount'])
        }
    }
</script>

<style>
</style>
