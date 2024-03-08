<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    departments: Array
});

</script>
<template>
<div class="overflow-x-auto bg-base-100 shadow-xl">
  <table class="table table-zebra">
    <!-- head -->
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
      <tr class="bg-base-200" v-for="(department,key) in departments" :key="department.id">
        <th class="w-10">{{ key+1 }}</th>
        <td>{{ department?.name }}</td>
        <td class="w-10">
            <Link class="btn btn-outline btn-info" :href="route('department.show', [department.id])">View</Link>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</template>