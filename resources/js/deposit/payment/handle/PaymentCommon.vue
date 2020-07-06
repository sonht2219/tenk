<template>
    <div>
        <div class="amount">
            <p class="label">Số tiền nạp(VNĐ): </p>
            <input-currency v-model="$v.amount.$model"  :placeholder="'Nhập số tiền'" />
            <div class="wrap-error" v-if="$v.amount.$error">
                <span class="text-danger" v-if="!$v.amount.required">Nhập số tiền</span>
                <span class="text-danger" v-if="!$v.amount.minValue">Số tiền nạp tối thiểu là 10,000VNĐ</span>
            </div>
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
    import {UPDATE_AMOUNT, UPDATE_SITUATION_FORM} from "../../shared";
    import { required, minValue } from "vuelidate/lib/validators";
    import {eventBus, EVENTS} from "../../../shared/service";

    export default {
        name: "PaymentCommon",
        components: {InputCurrency},
        created() {
            eventBus.$on(EVENTS.validate_form, this.validateForm);
        },
        methods: {
            ...mapMutations('depositStore', {
                updateAmount: UPDATE_AMOUNT,
                updateSituationForm: UPDATE_SITUATION_FORM
            }),
            validateForm() {
                this.$v.$touch();
                this.updateSituationForm(!this.$v.$invalid);
            }
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
        },
        validations: {
            amount: { required, minValue: minValue(10000) },
        },
        beforeDestroy() {
            eventBus.$off(EVENTS.validate_form);
        }
    }
</script>

<style scoped>

</style>
