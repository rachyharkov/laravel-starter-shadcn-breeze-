<script setup>
import UserForm from './Form.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import AuthenticatedIsolatedLayout from '@/Layouts/AuthenticatedIsolatedLayout.vue';

defineProps({ roles: Array })

const breadcrumb = [
    {
        label: 'Pengguna',
        currentPage: false,
        href: route('users.index')
    },
    {
        label: 'Tambah Baru',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedIsolatedLayout title="Tambah Pengguna Baru" :breadcrumb="breadcrumb" description="Tambahkan pengguna baru untuk mengakses aplikasi">
        <div class="mt-4">
            <UserForm :user="{}" :roles="roles" />
        </div>
    </AuthenticatedIsolatedLayout>
</template>
