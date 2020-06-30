import axios from 'axios'
import helper from "../helper/helper";
import {EVENTS, eventBus} from "../event-bus/event-bus";

const config = {
    baseURL: '/api/v1/'
};

const httpClient = axios.create(config);

const authInterceptor = config => {
    return {...config, headers: helper.getAuth()};
};

const responseSuccessInterceptor = response => {
    return response
};

const responseErrorInterceptor = error => {
    if (error.response.status === 401) {
        eventBus.$emit(EVENTS.required_auth);
    }
    return Promise.reject(error);
};

httpClient.interceptors.request.use(authInterceptor);
httpClient.interceptors.response.use(responseSuccessInterceptor, responseErrorInterceptor);

export {httpClient}
