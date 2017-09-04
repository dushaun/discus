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
                        <a href=""><small>Read All</small></a>
                    </div>
                </div>
            </div>
            <div class="notifications-container">
                <div class="notification"
                     v-for="notification in notifications"
                     @click="markAsRead(notification)">
                    <div class="media px-4">
                        <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="Generic placeholder image">
                        <div class="media-body">
                            <!--<h5 class="mt-0">Bottom-aligned media</h5>-->
                            <a :href="'/profiles/' + notification.data.owner">{{ notification.data.owner }}</a> {{ notification.data.action }} <a href="">{{ shortenTitle(notification) }}</a>
                            <p class="d-flex justify-content-between mb-0">
                                <small class="py-1">{{ date(notification) }} - <span class="font-italic">{{ fromNow(notification) }}</span></small>
                                <a href=""><small>Read</small></a>
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
            shortenTitle(notification) {
                let title = notification.data.title;
                let characterCount = title.length;
                let length = 27;
                return characterCount > length ? title.substring(0, length - 3) + "..." : title;
            },
            date(notification) {
                let date = notification.created_at;
                return window.moment(date).format('Do MMM YYYY, H:mm');
            },
            fromNow(notification) {
                let date = notification.created_at;
                return window.moment(date).fromNow();
            }
        }
    }
</script>