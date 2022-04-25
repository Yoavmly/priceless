<template>
    <tr class="text-[20px] font-bold">
        <td class="table_row"><span v-if="post.pinned===1"> <font-awesome-icon icon="thumbtack" size="1x"/> </span><router-link :to="{name : 'post', params : {id : post.id}}">{{post.title}}</router-link></td>
        <td class="table_row">{{post.user.username}}</td>
        <td class="hidden lg:table-cell table_row">08.03.2022</td>
        <td class="table_row">{{post.comments.length }}</td>
        <td class="hidden lg:table-cell table_row">{{post.views}}</td>
    </tr>
</template>

<script setup>
const props = defineProps({
    post : Object
})


</script>

<style scoped>

td {
    text-align: center;
}

td span {
    margin-right: 10px;
    color : red;
}
</style>
