<template>
    <div>
        <div class="amount">
            <p class="label">Số tiền nạp(VNĐ): </p>
            <input-currency v-model="amount"  :placeholder="'Nhập số tiền'" />
        </div>
        <div class="note">
            <span class="text-danger">* 1 XU tương đương 1000 VNĐ</span>
            <span class="text-danger">* Số tiền nạp tối thiểu 10.000 VNĐ</span>
        </div>
    </div>
</template>

<script>
    import InputCurrency from "../../../shared/components/InputCurrency";
    import { mapMutations } from 'vuex';
    import { UPDATE_AMOUNT } from "../../shared";

    export default {
        name: "PaymentCommon",
        components: {InputCurrency},
        methods: {
            ...mapMutations('depositStore', {
                updateAmount: UPDATE_AMOUNT
            })
        },
        computed: {
            amount: {
                get() {
                    return this.$store.state.depositStore.amount;
                },
                set(val) {
                    this.updateAmount(val);
                }
            }
        }
    }
</script>

<style scoped>

</style>
