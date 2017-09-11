<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" id="body"
                          placeholder="Reply here..." class="form-control"
                          rows="4" required v-model="body"></textarea>
            </div>
            <div class="form-group">
                <button type="submit"
                        class="btn btn-primary form-control"
                        @click="addReply">Submit</button>
            </div>
        </div>
        <p class="text-center mb-0" v-else>
            Please <a href="/login">login</a> or <a href="/register">register</a> to get involved with this conversation.
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
                endpoint: location.pathname + '/replies'
            };
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },
        methods: {
            addReply() {
                axios.post(this.endpoint, { body: this.body })
                    .then(({data}) => {
                        this.body = '';
                        flash('Your reply has been posted.');
                        this.$emit('created', data);
                    }).catch(error => {
                        flash(error.response.data, 'danger');
                    })
            }
        }
    }
</script>