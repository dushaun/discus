<template>
    <button :class="classes" @click="subscribe">{{ label }}</button>
</template>

<script>
    export default {
        props: ['active'],
        data() {
            return {
                status: this.active
            };
        },
        computed: {
            label() {
                return this.status ? 'Subscribed' : 'Subscribe';
            },
            classes() {
                return ['btn btn-block', this.status ? 'btn-outline-primary' : 'btn-primary'];
            }
        },
        methods: {
            subscribe() {
                axios[(this.status ? 'delete' : 'post')](location.pathname + '/subscriptions')
                    .then(() => {
                        this.status = ! this.status;
                    })
            }
        }
    }
</script>