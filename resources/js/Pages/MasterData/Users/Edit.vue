<script setup>
import UserForm from './Form.vue'
import AuthenticatedIsolatedLayout from '@/Layouts/AuthenticatedIsolatedLayout.vue';

const props = defineProps({ user: Object, roles: Object })

const breadcrumb = [
    {
        label: 'Pengguna',
        currentPage: false,
        href: route('users.index')
    },
    {
        label: props.user.name,
        currentPage: false,
        href: route('users.show', props.user.id)
    },
    {
        label: 'Edit',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedIsolatedLayout title="Edit Pengguna" :breadcrumb="breadcrumb" description="Edit data pengguna yang dapat mengakses aplikasi ini">
        <div class="mt-4">
            <UserForm :user="user" :roles="roles"/>
        </div>
    </AuthenticatedIsolatedLayout>
</template>
