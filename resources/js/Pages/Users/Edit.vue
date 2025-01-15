<script setup>
import UserForm from './Form.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';

const props = defineProps({ user: Object, roles: Object })

const breadcrumb = [
    {
        title: 'Pengguna',
        currentPage: false,
        href: route('users.index')
    },
    {
        title: props.user.name,
        currentPage: false,
        href: route('users.show', props.user.id)
    },
    {
        title: 'Edit',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedLayout>
        <Header title="Pengguna" :breadcrumb="breadcrumb" description="Edit data pengguna yang dapat mengakses aplikasi ini"/>
        <div class="page-content">
            <UserForm :user="user" :roles="roles"/>
        </div>
    </AuthenticatedLayout>
</template>
