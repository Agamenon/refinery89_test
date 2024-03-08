<script setup>
import { Link } from '@inertiajs/vue3';


const props = defineProps({
    users: Array,
    department:Object
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
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <!-- row 1 -->
      <tr class="bg-base-200" v-for="(user,key) in users" :key="user.id">
        <th class="w-10">{{ key+1 }}</th>
        <td>{{ user?.name }}</td>
        <td>{{ user?.email }}</td>
        <td>
          <div class="w-10">
              <Link as="button" method="put" :href="route('department.unlinkWithUser',{'department':department.id,'user':user.id})" class="btn btn-outline btn-warning">Unlink</Link>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
</template>