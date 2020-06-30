const helper = {
    getAuth() {
        return {
            authorization: 'Bearer ' + this.getTokenString(),
            'Content-Type': 'application/json',
            accept: 'application/json'
        }
    },
    getTokenString() {
        const param = 'authorization';
        const urlSearchParams = new URLSearchParams(window.location.search);
        if (urlSearchParams.has(param))
            localStorage.setItem('authorization', urlSearchParams.get(param));
        return localStorage.getItem('authorization');
    },
};

export default helper
