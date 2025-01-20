<script setup>
import RoleForm from './Form.vue'
import AuthenticatedIsolatedLayout from '@/Layouts/AuthenticatedIsolatedLayout.vue';

const props = defineProps({ role: Object, roles: Object })

const breadcrumb = [
    {
        label: 'peran',
        currentPage: false,
        href: route('master-data.roles.index')
    },
    {
        label: props.role.name,
        currentPage: false,
        href: route('master-data.roles.show', props.role.id)
    },
    {
        label: 'Edit',
        currentPage: true
    }
]
</script>
<template>
    <AuthenticatedIsolatedLayout title="Edit peran" :breadcrumb="breadcrumb" description="Edit data peran yang akan diisi oleh beberapa pengguna">
        <div class="mt-4">
            <RoleForm :role="role"/>
        </div>
    </AuthenticatedIsolatedLayout>
</template>
