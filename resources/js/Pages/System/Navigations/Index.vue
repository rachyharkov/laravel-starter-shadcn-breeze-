<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';

</script>

<template>
    <AuthenticatedLayout>
        <Header
            :breadcrumb="[{ label: 'Navigasi Menu', currentPage: true }]"
            title="Pengaturan Akses Menu"
            description="Tentukan menu yang ada pada sistem."
        />
        <div class="w-full mt-4">
            <p>Alohaaa</p>
        </div>
    </AuthenticatedLayout>
</template>
