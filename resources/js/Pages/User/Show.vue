<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head, useForm, Link, router} from "@inertiajs/vue3";
import { computed, ref} from "vue";
import CardUser from '@/Pages/User/Partials/CardUser.vue';
import ListDepartmentChild from '@/Pages/Department/Partials/ListDepartmentChild.vue';
import ModalLinkDepartmentToUser from './Partials/ModalLinkDepartmentToUser.vue';

const linkSubDepartment = ref(false);
const onError = ref(false);
const onSuccess = ref(false);

const deleteUser = () => {
    router.delete(route('user.destroy',[user.value.id]),{
        onError: () => {
            onError.value = true;
            setTimeout(()=> onError.value = false,2000);
        }
    });
}

const user = computed(() => usePage().props.user || []);

const openModelSubDepartment = () => linkSubDepartment.value = true;
const closeModelSubDepartment = () => linkSubDepartment.value = false;

</script>
<template>
    <Head title="Users" />
    <AuthenticatedLayout>
        <div class="relative bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-auto mx-auto p-6 lg:p-8">
                <div>
                    <div v-show="onError" role="alert" class="alert alert-error flex-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ $attrs?.errors?.user }}</span>
                    </div>
                    <div class="navbar bg-base-100 mb-3">
                        <div class="flex-1">
                            <a class="btn btn-ghost text-xl">User Details</a>
                        </div>
                        <div class="flex-none">
                            <ul class="grid grid-cols-1">
                                <li><button class="btn btn-error" @click="deleteUser">Delete</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex gap-4 flex-row">
                        <div class="basis-1/4">
                            <CardUser :user="user" @linkSubDepartment="openModelSubDepartment" :edition="true"></CardUser>
                        </div>
                        <div class="basis-2/3">
                            <div role="tablist" class="tabs tabs-lifted">
                                <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Departments" checked/>
                                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                     <ListDepartmentChild :departments="user.departments"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalLinkDepartmentToUser :open="linkSubDepartment" :user="user" @close="closeModelSubDepartment"></ModalLinkDepartmentToUser>
    </AuthenticatedLayout>
</template>