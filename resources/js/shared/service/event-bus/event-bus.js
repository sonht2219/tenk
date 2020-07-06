import Vue from 'vue';

const EVENTS = {
    required_auth: 'required_auth',
    validate_form: 'validate_form'
};

const eventBus = new Vue();

export { eventBus, EVENTS }
