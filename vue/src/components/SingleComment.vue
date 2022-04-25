<template>
    <div class="single-comment">
        <div class="comment-votes">
            <button @click="upvoteComment()">   <font-awesome-icon icon="caret-up" size="2x" /> </button>
            <p class="post-votes-result">{{comment.upvotes.length - comment.downvotes.length}}</p>
            <button @click="downvoteComment()">  <font-awesome-icon icon="caret-down" size="2x" /></button>
        </div>
        <div class="post-comment">
            <h4 class="post-header">#{{indexComment+2}} {{comment.user.username}}</h4>
            {{comment.content}}
        </div>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import {useRoute} from "vue-router";


const store = useStore();
const route = useRoute();

const props = defineProps({
    comment : Object,
    indexComment : Number
})



async function upvoteComment() {
    const data = {
        comment_id : props.comment.id,
        value : 1
    }

    await store.dispatch('upvoteComment', data);
    await store.dispatch('getPost', route.params.id);
}

async function downvoteComment() {
    const data = {
        comment_id :  props.comment.id,
        value : -1
    }

    await store.dispatch('downvoteComment', data);
    await store.dispatch('getPost', route.params.id);
}


</script>

<style scoped>

.comment-votes {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 10px 20px 10px 20px;
    min-width: 30px;
    text-align: center;

}

.single-comment {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 30px;
}

.post-header {
    color : dodgerblue;
}

</style>
