<template>
    <component :is="payment"/>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "Payment",
        computed: {
            ...mapState('depositStore', ['methodSelected']),
            payment() {
                return this.methodSelected.component;
            }
        }
    }
</script>

<style scoped>

</style>
