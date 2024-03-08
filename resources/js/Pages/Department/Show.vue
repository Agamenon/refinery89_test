<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { usePage, Head, useForm, Link } from "@inertiajs/vue3";
import { computed, ref} from "vue";
import CardDepartment from './Partials/CardDepartment.vue';
import ListDepartmentUsers from './Partials/ListDepartmentUsers.vue';
import ListDepartmentChild from './Partials/ListDepartmentChild.vue';
import ModalLinkDepartment from './Partials/ModalLinkDepartment.vue';
import ModalLinkUserToDepartment from './Partials/ModalLinkUserToDepartment.vue';

const linkSubDepartment = ref(false);
const linkUsers = ref(false);

const department = computed(() => usePage().props.department || []);
const users = computed(() => usePage().props.department.users || []);
const subdepartments = computed(() => usePage().props.department.child_departments || []);

const openModelSubDepartment = () => linkSubDepartment.value = true;
const closeModelSubDepartment = () => linkSubDepartment.value = false;

const openModelUsers = () =>  linkUsers.value = true;
const closeModelUsers = () => linkUsers.value = false;

</script>
<template>
    <Head title="Departments" />
    <AuthenticatedLayout>
        <div class="relative bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="max-auto mx-auto p-6 lg:p-8">
                <div>
                    <div class="navbar bg-base-100 mb-3">
                        <div class="flex-1">
                            <a class="btn btn-ghost text-xl">Department Details</a>
                        </div>
                        <div class="flex-none">
                            <ul class="grid grid-cols-1">
                                <li><Link method="delete" as="button" :hre="route('department.destroy',[department.id])" class="btn btn-error">Delete</Link></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex gap-4 flex-row">
                        <div class="basis-1/4">
                            <CardDepartment :department="department" @linkSubDepartment="openModelSubDepartment" @linkWithUser="openModelUsers" :edition="true"></CardDepartment>
                        </div>
                        <div class="basis-2/3">
                            <div role="tablist" class="tabs tabs-lifted">
                                <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="Users" checked/>
                                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                    <ListDepartmentUsers :users="users" :department="department"/>
                                </div>

                                <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="SubDepartments"/>
                                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                                    <ListDepartmentChild :departments="subdepartments"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModalLinkDepartment :open="linkSubDepartment" :department="department" @close="closeModelSubDepartment"></ModalLinkDepartment>
        <ModalLinkUserToDepartment :open="linkUsers" :department="department" @close="closeModelUsers"></ModalLinkUserToDepartment>
    </AuthenticatedLayout>
</template>