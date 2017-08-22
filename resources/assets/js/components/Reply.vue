<template>
    <div :id="'reply-' + id" class="card mb-3">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <a :href="'/profiles/' + data.owner.name"
                        v-text="data.owner.name">
                    </a> said {{ data.created_at }}
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
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer" v-if="options">
            <!--@can('update', $reply)-->
            <div class="d-flex justify-content-end">
                <button class="btn btn-outline-danger btn-sm border-0 mr-2" @click="destroy">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <button class="btn btn-success btn-sm mr-2" @click="editing = true">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </button>
            </div>
            <!--@endcan-->
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
                body: this.data.body,
                options: false
            };
        },
        computed: {
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
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });

                this.editing = false;

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