<template>
    <div class="container px-3 md:px-0">

        <loader v-if="loader"></loader>
        <div class="mt-4" v-else>
            <h2 class="title">Recent Discussions on {{topic.name}}</h2>
            <router-link class="btn" :to="{ name : 'createPost' , params : {id : topic.id}}">Create Post</router-link>
            <div class="main-content mt-4 flex justify-between flex-row">
                <div class="posts md:flex-[0_0_65%] flex-[0_0_100%]">
                    <table class="border-collapse border-solid border-black border-[1px] w-full">
                        <table-head/>
                        <tbody v-for="(post,index) in topic.posts" :key="index">
                        <post-item :post="post"></post-item>
                        </tbody>
                    </table>
                </div>
                <browse-forums :topics="topics"></browse-forums>

            </div>
        </div>
    </div>
</template>

<script  setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";
import {computed} from "vue";
import PostItem from '../components/PostItem.vue';
import TableHead from '../components/TableHead.vue';
import BrowseForums from '../components/BrowseForums.vue';
import Loader from '../components/Loader.vue';
const store= useStore();
const route = useRoute();






const loader = computed(() => store.state.loading);
const topic = computed(() =>store.state.topics.topic);
const topics = computed(() => store.state.topics.topics);

async function getTopicData() {
    // go get the topic with the posts
     await store.dispatch('getTopic',route.params.id);
    await store.dispatch('topics');
}
getTopicData();

</script>

<style scoped>

.container {
    margin: 0 auto;
}

tbody tr:nth-child(even) {
    background: #f7fafc;
}
</style>
