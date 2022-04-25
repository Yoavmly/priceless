<template>
    <div class="single-post">
        <div class="post-votes">
            <button @click="upvotePost()" :disabled="post.user_id=== user.id"> <font-awesome-icon icon="caret-up" size="2x" /></button>
            <p class="post-votes-result">{{post.upvotes.length - post.downvotes.length}}</p>
            <button @click="downvotePost()" :disabled="post.user_id=== user.id">   <font-awesome-icon icon="caret-down" size="2x" /></button>
        </div>
        <div class="post-content">
            <h4 class="post-header">#1    {{post.user.username}}</h4>
            <div>{{post.content}}</div>
        </div>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";


const store = useStore();
const route = useRoute();

const props = defineProps({
    post : Object,
    user : Object

})



async function upvotePost() {

    const data = {
        post_id : props.post.id,
        value : 1
    }

    await store.dispatch('upvotePost', data);
    await store.dispatch('getPost', route.params.id);
}

async function downvotePost() {

    const data = {
        post_id : props.post.id,
        value : -1
    }

    await store.dispatch('downvotePost', data);
    await store.dispatch('getPost', route.params.id);
}



</script>

<style scoped>

.single-post  {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 20px;
}

.post-header {
    color : dodgerblue;
}


.post-votes {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 20px 10px 20px;
}

.post-votes {
    min-width: 30px;
    text-align: center;
}


</style>
