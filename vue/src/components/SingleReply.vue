<template>
<div class="single-reply">
    <div class="reply-votes">
        <button @click="upvoteReply(reply.id)">  <font-awesome-icon icon="caret-up" size="2x" /> </button>
        <p class="post-votes-result">{{reply.upvotes.length - reply.downvotes.length}}</p>
        <button @click="downvoteReply(reply.id)"> <font-awesome-icon icon="caret-down" size="2x" /> </button>
    </div>
    <div class="post-reply">
        <h4 class="post-header">#{{indexComment+2}}.{{indexReply+1}} {{reply.user.username}}</h4>
        {{reply.content}}
    </div>
</div>
</template>

<script setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";


const store = useStore();
const route = useRoute();

const props = defineProps({
    reply : Object,
    indexReply : Number,
    indexComment : Number
})


async function upvoteReply() {
    const data = {
        reply_id : props.reply.id,
        value : 1
    }

    await store.dispatch('upvoteReply', data);
    await store.dispatch('getPost', route.params.id);
}

async function downvoteReply() {
    const data = {
        reply_id :  props.reply.id,
        value : -1
    }

    await store.dispatch('downvoteReply', data);
    await store.dispatch('getPost', route.params.id);
}
</script>

<style scoped>

.reply-votes {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 20px 10px 20px;
}

.single-reply {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 30px;
}

.post-header {
    color : dodgerblue;
}

.reply-votes p {
    min-width: 30px;
    text-align: center;
}

</style>
