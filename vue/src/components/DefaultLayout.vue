<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow" />
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                            </div>
                        </div>
                    </div>
                    <div  class="hidden md:block">
                        <div v-if="token" class="ml-4 flex items-center md:ml-6">
                            <Menu  as="div" class="ml-3 relative">
                                <div>
                                    <MenuButton type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                        <span class="sr-only">View notifications</span>
                                        <BellIcon id="bell" class="h-6 w-6" aria-hidden="true" />
                                        <span v-if="notifications.length > 0" class="badge">{{notifications.length}}</span>
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="origin-top-right absolute right-0 mt-2 w-96 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-for="(item,index) in notifications" :key="index" v-slot="{ active }">
                                           <router-link :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']" class="notification-post-link" :to="{name : 'post' , params : {id : item.data.post_id}}"><font-awesome-icon icon="comment"/><span class="notification"> {{item.data.username}} Added {{item.data.message}}</span></router-link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
<!--                            <button type="button" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">-->
<!--                                <span class="sr-only">View notifications</span>-->
<!--                                <BellIcon id="bell" class="h-6 w-6" aria-hidden="true" />-->
<!--                                <span v-if="notifications.length > 0" class="badge">{{notifications.length}}</span>-->
<!--                            </button>-->

                            <!-- Profile dropdown -->
                            <Menu  as="div" class="ml-3 relative">
                                <div>
                                    <MenuButton class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                        <span class="sr-only">Open user menu</span>
<!--                                        <img class="h-8 w-8 rounded-full" :src="user.name? " alt="" />-->
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                            <a :href="item.href" @click="handle_function_call(item.function)" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                        <div class="flex justify-center" v-else>
                            <DisclosureButton  class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                <router-link :to="{name : 'register'}">Register</router-link>
                            </DisclosureButton>
                            <DisclosureButton  class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                                <router-link :to="{name : 'login'}">Login</router-link>
                            </DisclosureButton>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href" :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
                </div>
                <div v-if="token"  class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="user.name" alt="" />
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ user.name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ user.email }}</div>
                        </div>
                        <button type="button" class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-6 w-6" aria-hidden="true" />
                            <span v-if="notifications.length > 0" class="badge">{{notifications.length}}</span>
                        </button>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <DisclosureButton v-for="item in userNavigation" :key="item.name" as="a" :href="item.href" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">{{ item.name }}</DisclosureButton>
                    </div>
                </div>
                <div v-else>
                    <DisclosureButton  class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                        <router-link :to="{name : 'register'}">Register</router-link>
                    </DisclosureButton>
                    <DisclosureButton  class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">
                        <router-link :to="{name : 'login'}">Login</router-link>
                    </DisclosureButton>

                </div>
            </DisclosurePanel>
        </Disclosure>

        <router-view :key="$route.path"></router-view>
    </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon, InboxIcon } from '@heroicons/vue/outline'
import {computed,ref} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";


const navigation = ref([
    { name: 'Home', href: '/', current: true },
])

const userNavigation = ref([
    { name: 'Your Profile', href: '#' },
    { name: 'Settings', href: '#' },
    { name: 'Sign out', href: '#' , function : 'logout' },
])
const store = useStore();
const router = useRouter();

async function getNotifications() {
        await store.dispatch('getNotifications');
}

getNotifications()

const user = computed( () =>  store.state.user.data)
const token = computed(() => store.state.user.token)
const notifications  = computed(() => store.state.notifications)


function handle_function_call(function_name) {
    this[function_name]()
}

async function logout() {
console.log('logout')

await store.dispatch('logout');
await router.push('/')
}




</script>

<style scoped>

#bell {
    position: relative;
}

.badge {
    position: absolute;
    top: 1px;
    margin-left: 1px;
    border-radius: 50%;
    background-color: red;
    height: 15px;
    width: 15px;
    font-size: 10px;
}


.notification {
    font-size: 14px;
    /*word-wrap: break-word;*/
    /*padding: 10px;*/
}

.notification-post-link {
    display: flex;
    flex-direction: row;
    justify-content:flex-start ;
    gap: 20px;
    align-items: center;
}

.unread-notification {
    background-color:rgb(229, 231, 235);
    font-weight: 500;
    color: #2c3e50;
}



@media only screen and (max-width: 768px) {

    .badge {
        position: absolute;
        top: 140px;
        margin-left: 1px;
        border-radius: 50%;
        background-color: red;
        height: 15px;
        width: 15px;
        font-size: 10px;
    }

}

</style>
