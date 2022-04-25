<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Account been successfully confirmed. Click here to login</h2>
                <button @click="moveToHomePage()" type="submit" class="group relative w-full flex justify-center mt-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
                    Take me to home page
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useRouter} from "vue-router";
import { LockClosedIcon } from '@heroicons/vue/solid'


const router = useRouter()


function moveToHomePage() {

    router.push('/login');
}
</script>

<style scoped>

</style>
