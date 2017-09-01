<template>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="notificationsDropdown">
            <i :class="bell" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown" v-show="notifications.length">
            <a class="dropdown-item"
               v-for="notification in notifications"
               :href="notification.data.link"
               v-text="notification.data.message"
               @click="markAsRead(notification)"></a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            };
        },
        created() {
            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(response => this.notifications = response.data);
        },
        computed: {
            bell() {
                return ['fa', this.notifications.length ? 'fa-bell' : 'fa-bell-o'];
            }
        },
        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }
</script>

<style>
    .dropdown-toggle.notifications::after {
        display: none;
    }
</style>