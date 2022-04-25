<template>
<div class="container  px-3 md:px-0">
    <loader v-if="loader"></loader>
    <div v-else class="content">


    <h2 class="title">Add Post To {{topic.name}}</h2>
    <form class="forum_form" @submit.prevent="submitPost">
        <div class="form-group">
            <label for="title">
                Post Title
            </label>
            <input v-model="title" type="text" name="title" id="title" placeholder="Post Title">
        </div>
        <div class="form-group">
            <label for="content">
                Post Content
            </label>
            <textarea v-model="content" type="text" name="content" id="content" placeholder="Post Content" rows="10">

            </textarea>

        </div>
        <button type="submit" class="btn">Submit</button>
    </form>
    </div>
</div>
</template>

<script setup>
import Loader from '../components/Loader.vue';
import {useStore} from "vuex";
import {useRoute, useRouter} from "vue-router";
import {computed, ref} from "vue";




const store = useStore();
const route = useRoute();
const router = useRouter();

store.dispatch('getTopic' , route.params.id)
const topic = computed(() => store.state.topics.topic);
const loader = computed(() => store.state.loading)




const title = ref('');
const content = ref('');


async function submitPost() {
    const data = {
        title : title.value,
        content : content.value,
        topic_id : route.params.id
    }

    await store.dispatch('postPost' , data );
    await router.push({name: 'topic', params: {id: route.params.id}})

}
</script>

<style scoped>
.container {
    margin: 0 auto;
}

.form-group {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 25px;
}

.form-group label {
    width: 80%;
    font-size: 25px;
}

.form-group input,.form-group textarea {
    width: 80%;
    border-radius: 10px;
    border: 1px solid #1a202c;
    padding: 10px 10px 10px 20px;
}


.btn {
    display: flex;
    justify-content: center;
    align-items: center;
    align-self: center;
    padding: 15px 30px;
    background-color: rgb(44, 62, 80) ;
    color : #fff;
    border-radius: 5px;
    width: 50%;
    margin-top: 20px;
    margin-bottom: 20px;
}
</style>
