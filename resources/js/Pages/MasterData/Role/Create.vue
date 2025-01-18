<script setup>
import RoleForm from './Form.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import AuthenticatedIsolatedLayout from '@/Layouts/AuthenticatedIsolatedLayout.vue';

defineProps({ roles: Array })

const breadcrumb = [
    {
        label: 'Peran',
        currentPage: false,
        href: route('roles.index')
    },
    {
        label: 'Tambah Baru',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedIsolatedLayout title="Tambah Peran Baru" :breadcrumb="breadcrumb" description="Tambahkan Peran baru untuk pengguna">
        <div class="mt-4">
            <RoleForm :role="{}" />
        </div>
    </AuthenticatedIsolatedLayout>
</template>
