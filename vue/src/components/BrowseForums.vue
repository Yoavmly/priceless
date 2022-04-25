<template>
    <div class="hidden md:block forums">
        <h3 class="browse_forums_title">Browse Forums</h3>
        <ul class="flex justify-center flex-col align-middle">
            <li class="mt-[10px] w-full" v-for="(topic,index) in topics" :key="index">
                <router-link @click="getTopic($event, topic)" :to="{name: 'topic', params : {id:topic.id}}"><span class="mx-[10px]"><font-awesome-icon icon="comment"/></span>{{topic.name}}</router-link>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {useStore} from "vuex";

const store = useStore();

// This takes as props all the available topics
const props = defineProps({
    'topics' : Object
})


/**
 * Function sends a request to the store to go get the topic that was clicked before moving to the desired page
 * @param event
 * @param topic
 */
function getTopic(event,topic) {

    const topicId = topic.id;
    console.log(topicId);
    store.dispatch('getTopic', topicId);
}

</script>

<style scoped>

.forums {
    border: 1px solid #000;
    flex : 0 0 25%;
    height: fit-content;
}

/*.forums ul {*/
/*    display: flex;*/
/*    flex-direction: column;*/
/*    justify-content: center;*/
/*    align-items: center;*/
/*}*/

/*.forums ul li {*/
/*    margin-top: 10px;*/
/*    width: 100%;*/
/*}*/

/*li span {*/
/*    margin-right: 10px;*/
/*    margin-left: 10px;*/
/*}*/

.browse_forums_title {
    text-align: center;
    border-bottom: 1px solid #000;
    font-size: 24px;
    font-weight: bold;
}

</style>
