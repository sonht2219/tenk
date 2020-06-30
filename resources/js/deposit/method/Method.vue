<template>
    <div>
        <div class="title-method">Hình Thức Thanh Toán</div>
        <div class="wrap-method">
            <template v-for="method in methods">
                <div class="method" @click="chooseMethod(method)" :class="{ selected: method.id === getProp(methodSelected, 'id') }">
                    <img :src="method.icon" alt=""/>
                    <span>{{ method.name }}</span>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';
    import { CHOOSE_METHOD } from '../shared';
    import {MIXINS} from "../../shared";
    export default {
        name: "Method",
        mixins: [MIXINS],
        methods: {
            ...mapMutations('depositStore', {
                chooseMethod: CHOOSE_METHOD
            })
        },
        computed: {
            ...mapState('depositStore', ['methods', 'methodSelected'])
        }
    }
</script>

<style scoped>

</style>
