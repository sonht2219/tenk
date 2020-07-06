<template>
    <div>
        <div class="amount">
            <p class="label">Nhập thẻ cào: </p>
        </div>

        <div class="card-info">
            <div class="card-info-item">
                <span class="label">Nhà mạng:</span>
                <select v-model="$v.telco.$model">
                    <option disabled value="">Chọn nhà mạng</option>
                    <option v-for="telco in telcos" :value="telco.value">{{ telco.key }}</option>
                </select>
                <div class="wrap-error" v-if="$v.telco.$error && !$v.telco.required">
                    <span class="text-danger">Chọn nhà mạng</span>
                </div>
            </div>
            <div class="card-info-item">
                <span class="label">Mệnh giá:</span>
                <div>
                    <select v-model="$v.value.$model">
                        <option disabled value="">Chọn mệnh giá</option>
                        <option v-for="val in valuesCard" :value="val.value">{{ val.key }}</option>
                    </select>
                    <div class="wrap-error" v-if="$v.value.$error && !$v.value.required">
                        <span class="text-danger">Chọn mệnh giá</span>
                    </div>
                </div>
            </div>
            <div class="card-info-item">
                <span class="label">Seri thẻ cào:</span>
                <div>
                    <input v-model="$v.seri.$model" type="text" placeholder="Nhập seri thẻ cào">
                    <div class="wrap-error" v-if="$v.seri.$error && !$v.seri.required">
                        <span class="text-danger">Nhập seri thẻ cào</span>
                    </div>
                </div>
            </div>
            <div class="card-info-item">
                <span class="label">Mã thẻ cào:</span>
                <div>
                    <input v-model="$v.code.$model" type="text" placeholder="Nhập mã thẻ cào">
                    <div class="wrap-error" v-if="$v.code.$error && !$v.code.required">
                        <span class="text-danger">Nhập mã thẻ cào</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapMutations, mapState, mapActions } from 'vuex';
    import {
        GET_TELCOS_PHONE_CARD, GET_VALUES_CARD_PHONE_CARD,
        UPDATE_CODE_PHONE_CARD,
        UPDATE_SERI_PHONE_CARD, UPDATE_SITUATION_FORM,
        UPDATE_TELCO_PHONE_CARD,
        UPDATE_VALUE_PHONE_CARD
    } from "../../shared";
    import {minValue, required} from 'vuelidate/lib/validators';
    import {eventBus, EVENTS} from "../../../shared/service";
    export default {
        name: "PaymentPhoneCard",
        created() {
            if (!this.telcos || !this.telcos.length) {
                this.getTelcos();
            }
            if (!this.valuesCard || !this.valuesCard.length) {
                this.getValuesCard();
            }
            eventBus.$on(EVENTS.validate_form, this.validateForm);
        },
        methods: {
            ...mapMutations('depositStore', {
                updateSeri: UPDATE_SERI_PHONE_CARD,
                updateCode: UPDATE_CODE_PHONE_CARD,
                updateTelco: UPDATE_TELCO_PHONE_CARD,
                updateValue: UPDATE_VALUE_PHONE_CARD,
                updateSituationForm: UPDATE_SITUATION_FORM
            }),
            ...mapActions('depositStore', {
                getTelcos: GET_TELCOS_PHONE_CARD,
                getValuesCard: GET_VALUES_CARD_PHONE_CARD
            }),
            validateForm() {
                this.$v.$touch();
                this.updateSituationForm(!this.$v.$invalid);
            }
        },
        computed: {
            ...mapState('depositStore', ['telcos', 'valuesCard']),
            seri: {
                get() {
                    return this.$store.state.depositStore.phoneCard.seri;
                },
                set(val) {
                    this.updateSeri(val);
                }
            },
            code: {
                get() {
                    return this.$store.state.depositStore.phoneCard.code;
                },
                set(val) {
                    this.updateCode(val);
                }
            },
            telco: {
                get() {
                    return this.$store.state.depositStore.phoneCard.telco;
                },
                set(val) {
                    this.updateTelco(val);
                }
            },
            value: {
                get() {
                    return this.$store.state.depositStore.phoneCard.value;
                },
                set(val) {
                    this.updateValue(val);
                }
            }
        },
        validations: {
            seri: { required },
            code: { required },
            telco: { required },
            value: { required, minValue: minValue(10000) },
        },
        beforeDestroy() {
            eventBus.$off(EVENTS.validate_form);
        }
    }
</script>

<style scoped>
</style>
