<template>
    <input type="text" v-mask="mask" v-model="myInputModel" :placeholder="placeholder">
</template>

<script>
    import createNumberMask from 'text-mask-addons/dist/createNumberMask';
    const currencyMask = createNumberMask({
        prefix: '',
        allowDecimal: true,
        includeThousandsSeparator: true,
        allowNegative: false,
    });
    export default {
        name: "InputCurrency",
        props: ['placeholder', 'value'],
        data: () => ({
            mask: currencyMask,
        }),
        computed: {
            myInputModel: {
                get() {
                    return this.value;
                },
                set(val) {
                    this.$emit('input', Number(val.replace(/,/g, '')));
                }
            }
        }
    }
</script>

<style scoped>

</style>
