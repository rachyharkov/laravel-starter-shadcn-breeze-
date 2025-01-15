<script setup>
import UserForm from './Form.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';

defineProps({ roles: Object })

const breadcrumb = [
    {
        title: 'Pengguna',
        currentPage: false,
        href: route('users.index')
    },
    {
        title: 'Create',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedLayout>
        <Header title="Pengguna" :breadcrumb="breadcrumb" description="Tambahkan pengguna baru untuk mengakses aplikasi"/>
        <div class="page-content">
            <UserForm :user="{}" :roles="roles" />
        </div>
    </AuthenticatedLayout>
</template>
