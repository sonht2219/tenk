<template>
    <div>
        <router-view :key="$route.fullPath"></router-view>
    </div>
</template>

<script>
    import {eventBus, EVENTS} from "./shared/service";

    export default {
        name: "App",
        created() {
            eventBus.$on(EVENTS.required_auth, this.requiredAuth);
        },
        methods: {
            requiredAuth() {
                alert('Bạn chưa đăng nhập. Vui lòng đăng nhập để sử dụng tính năng này');
            }
        },
        beforeDestroy() {
            eventBus.$off(EVENTS.required_auth);
        }
    }
</script>

<style scoped>

</style>
