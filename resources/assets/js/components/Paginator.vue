<template>
    <nav aria-label="Page navigation example" v-if="shouldPaginate">
        <ul class="pagination">
            <li :class="prevUrl">
                <a class="page-link" href="#" rel="prev" @click.prevent="page--">Previous</a>
            </li>
            <!--<li class="page-item"><a class="page-link" href="#">1</a></li>-->
            <!--<li class="page-item"><a class="page-link" href="#">2</a></li>-->
            <!--<li class="page-item"><a class="page-link" href="#">3</a></li>-->
            <li :class="nextUrl">
                <a class="page-link" href="#" rel="next" @click.prevent="page++">Next</a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: ['dataSet'],
        data() {
            return {
                page: 1,
                prevLink: false,
                nextLink: false
            };
        },
        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevLink = this.dataSet.prev_page_url;
                this.nextLink = this.dataSet.next_page_url;
            },
            page() {
                this.broadcast().updateUrl();
            }
        },
        computed: {
            shouldPaginate() {
                return !! this.prevLink || !! this.nextLink;
            },
            prevUrl() {
                return ['page-item', this.prevLink ? '' : 'disabled'];
            },
            nextUrl() {
                return ['page-item', this.nextLink ? '' : 'disabled'];
            }
        },
        methods: {
            broadcast() {
                return this.$emit('changed', this.page)
            },
            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>