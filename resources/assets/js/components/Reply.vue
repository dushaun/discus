<template>
    <div :id="'reply-' + id" class="card mb-3">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <a :href="'/profiles/' + data.owner.name"
                        v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </div>

                <div v-if="signedIn">
                    <like :reply="data"></like>
                </div>

                <div class="ml-2">
                    <button :class="classes" @click="optionsToggle">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-link" @click="cancel">Cancel</button>
                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer" v-if="options">
            <div class="d-flex justify-content-start" v-if="canUpdate">
                <button class="btn btn-success btn-sm mr-2" @click="editing = true">Edit</button>
                <button class="btn btn-outline-danger btn-sm border-0 mr-2" @click="destroy">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Like from './Like.vue';
    export default {
        props: ['data'],
        components: { Like },
        data() {
            return {
                editing: false,
                id: this.data.id,
                original: '',
                body: this.data.body,
                options: false
            };
        },
        created() {
            this.original = this.data.body;
        },
        computed: {
            ago() {
                return window.moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn
            },
            canUpdate() {
                return this.authorise(user => this.data.user_id == user.id);
            },
            classes() {
                return ['btn btn-sm border-0 ', this.options ? 'btn-secondary' : 'btn-outline-secondary']
            }
        },
        methods: {
            cancel() {
                this.editing = false;
                this.body = this.original;
            },
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });

                this.editing = false;
                this.original = this.body;

                flash('Your reply was updated');
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
            },
            optionsToggle() {
                this.options = ! this.options
            }
        }
    }
</script>