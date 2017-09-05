<template>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="notificationsDropdown">
            <i :class="bell" class="bell" aria-hidden="true"></i> <span class="badge badge-danger" v-show="notifications.length" v-text="count"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right notifications" aria-labelledby="notificationsDropdown" v-show="notifications.length">
            <div class="notifications-title">
                <div class="row">
                    <div class="col">Notifications <span class="badge badge-danger" v-text="count"></span></div>
                    <div class="col text-right">
                        <a href="" @click="markAllAsRead()"><small>Read All</small></a>
                    </div>
                </div>
            </div>
            <div class="notifications-container">
                <div class="notification"
                     v-for="notification in notifications">
                    <div class="media px-4">
                        <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="Generic placeholder image">
                        <div class="media-body">
                            <a :href="'/profiles/' + notification.data.owner">{{ notification.data.owner }}</a>
                            {{ notification.data.action }}
                            <a :href="notification.data.link" @click="markAsRead(notification)">{{ shortenTitle(notification) }}</a>
                            <p class="d-flex justify-content-between mb-0">
                                <small class="py-1 font-italic">{{ fromNow(notification) }}</small>
                                <a href="" @click="markAsRead(notification)"><small>Read</small></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
            },
            count() {
                return this.notifications !== false ? this.notifications.length : 0;
            }
        },
        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            },
            markAllAsRead() {
                axios.delete('/profiles/' + window.App.user.name + '/notifications')
            },
            shortenTitle(notification) {
                let title = notification.data.title;
                let characterCount = title.length;
                let length = 27;
                return characterCount > length ? title.substring(0, length - 3) + "..." : title;
            },
            fromNow(notification) {
                let date = notification.created_at;
                return window.moment(date).fromNow();
            }
        }
    }
</script>