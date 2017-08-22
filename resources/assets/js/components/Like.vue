<template>
    <button class="btn-sm border-0" :class="classes" @click="toggle">
        <i class="fa fa-heart" aria-hidden="true"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data() {
            return {
                count: this.reply.likesCount,
                isLiked: this.reply.isLiked
            };
        },
        computed: {
            classes() {
                return ['btn', this.isLiked ? 'btn-primary' : 'btn-outline-primary']
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/likes';
            }
        },
        methods: {
            toggle() {
                this.isLiked ? this.destroy() : this.create();
            },
            create() {
                axios.post(this.endpoint);

                this.isLiked = true;
                this.count++;
            },
            destroy() {
                axios.delete(this.endpoint);

                this.isLiked = false;
                this.count--;
            }
        }
    }
</script>