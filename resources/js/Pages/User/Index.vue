<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Paginator from '@/Components/Paginator.vue';
import Modal from '@/Components/Modal.vue';
import { usePage, Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref} from "vue";
import CardUser from '@/Pages/User/Partials/CardUser.vue';

const users = computed(() => usePage().props.users || []);
const openModalNewUser = ref(false);
const onError = ref(false);
const query = ref('');

const openModal = () => openModalNewUser.value = true;

const form = useForm({
    name: '',
    email: ''
})

const submit = () => {
    form.post(route('user.store'), {
        onSuccess: () => closeModal(),
        onError: () => {
            onError.value = true;
            setTimeout(()=> onError.value = false,2000);
        }
    });
}

const search = () => {
    router.get(route('user.index'),{"query":query.value},{ only: ['users'],preserveState: true });
}

const closeModal = () => {
    openModalNewUser.value = false;
    form.reset();
}

</script>
<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <div class="relative bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-auto mx-auto p-6 lg:p-8">
                <div class="">
                    <div class="navbar bg-base-100 mb-3">
                        <div class="flex-1">
                            <h2 class="btn btn-ghost text-xl">User List</h2>
                            <Paginator :current_page="users.current_page" :prev_page="users.prev_page_url" :next_page="users.next_page_url"  />
                        </div>
                        <div class="flex mx-2">
                            <div class="join">
                                <div>
                                    <div>
                                        <input class="input input-bordered join-item" placeholder="Search" v-model="query" @keyup.enter="search"/>
                                    </div>
                                </div>
                                <div class="indicator">
                                    <button class="btn join-item" @click="search">Search</button>
                                </div>
                            </div>
                        </div>
                        <div class="flex-none">
                            <ul class="grid grid-cols-1">
                                <li><button @click="openModal()" class="btn btn-success">Create</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 lg:gap-8">
                        <div v-for="user in users.data" :key="user.id">
                            <CardUser :user="user"></CardUser>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="openModalNewUser" @close="closeModal" :maxWidth="lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a New Department
                </h2>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 gap-2">
                        <label class="input input-bordered flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM12.735 14c.618 0 1.093-.561.872-1.139a6.002 6.002 0 0 0-11.215 0c-.22.578.254 1.139.872 1.139h9.47Z" /></svg>
                            <input type="text" class="grow" placeholder="Name" v-model="form.name"/>
                            <span v-show="onError" class="label-text-alt text-red-500">{{ form.errors.name }}</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" /><path d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" /></svg>
                                <input type="email" class="grow" placeholder="Email" v-model="form.email"/>
                        </label>
                        <button class="mx-2 btn btn-success" :class="{ 'opacity-25': form.processing }" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>