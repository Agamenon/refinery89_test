<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Paginator from '@/Components/Paginator.vue';
import Modal from '@/Components/Modal.vue';
import { usePage, Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref} from "vue";
import CardDepartment from '@/Pages/Department/Partials/CardDepartment.vue';

const departments = computed(() => usePage().props.departments || []);
const openModalNewDepartment = ref(false);
const onError = ref(false);
const query = ref('');

const openModal = () => openModalNewDepartment.value = true;

const form = useForm({
    name: ''
})

const submit = () => {
    form.post(route('department.store'), {
        onSuccess: () => closeModal(),
        onError: () => {
            onError.value = true;
            setTimeout(()=> onError.value = false,2000);
        }
    });
}

const search = () => {
    router.get(route('department.index'),{"query":query.value},{ only: ['departments'],preserveState: true });
}

const closeModal = () => {
    openModalNewDepartment.value = false;
    form.reset();
}

</script>
<template>
    <Head title="Departments" />
    <AuthenticatedLayout>
        <div class="relative bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-auto mx-auto p-6 lg:p-8">
                <div class="">
                    <div class="navbar bg-base-100 mb-3">
                        <div class="flex-1">
                            <h2 class="btn btn-ghost text-xl">Department List</h2>
                            <Paginator :current_page="departments.current_page" :prev_page="departments.prev_page_url" :next_page="departments.next_page_url"  />
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
                        <div v-for="department in departments.data" :key="department.id">
                            <CardDepartment :department="department"></CardDepartment>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="openModalNewDepartment" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a New Department
                </h2>
                <form @submit.prevent="submit">
                    <div class="mt-2">
                        <input type="text" placeholder="Department Name" class="input input-bordered input-md w-full max-w-xs" v-model="form.name" />
                        <span v-show="onError" class="text-red-500">{{ form.errors.name }}</span>
                        <button class="mx-2 btn btn-success" :class="{ 'opacity-25': form.processing }" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>