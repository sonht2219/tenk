import Vue from 'vue';

const EVENTS = {
    required_auth: 'required_auth'
};

const eventBus = new Vue();

export { eventBus, EVENTS }
