<template>
    <div v-if="token && user.data.email_verified_at === null" class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">We sent a verification email, please click the link in the email to complete registration</h2>


                <button @click="resendLink()" type="submit" class="group relative w-full flex justify-center mt-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
                    Re-send the email confirmation link
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import {useStore} from "vuex";
import {computed} from "vue";

const store = useStore();

const user = computed(() => store.state.user);
const token = computed(() => store.state.user.token);

async function resendLink(){

    await store.dispatch('resendEmailConfirmationLink');



}
</script>

<style scoped>

</style>
