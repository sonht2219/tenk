<template>
    <div class="wrap-result">
        <div class="wrap-result-content text-center">
            <img width="100px" src="../../assets/images/icon-info.png" alt="">
            <h4 class="mt-2">{{ message }}</h4>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PhoneCard",
        props: ['message']
    }
</script>

<style scoped>

</style>
