<template>
    <div  class="spinner-wrapper">
        <clip-loader  class="spinner" :loading="true" :color="'#3f3f3f'" :size="'100px'"></clip-loader>
    </div>
</template>

<script setup>

</script>

<style scoped>
.spinner-wrapper {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0.7;
    background-color: #f3f3f3;
}

.spinner-wrapper .spinner {

    position: relative;
    top: 50%;
}
</style>
