import get from 'lodash/get';
export const MIXINS = {
    data: () => ({
        loader: null,
    }),
    methods: {
        getProp: get,
        showLoading() {
            this.loader = this.$loading.show({
                container: null,
                canCancel: false,
                color: '#FF9800'
            });
        },
        hideLoading() {
            this.loader.hide();
        }
    }
};
