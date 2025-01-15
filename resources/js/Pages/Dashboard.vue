<script setup>
import Header from '@/Components/Header.vue';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <AuthenticatedLayout>
        <Header title="Dashboard Utama" :breadcrumb="[{ label: 'Dashboard', currentPage: true }]" />
        <main class="w-full mt-4">
            <Card>
                <CardHeader>
                    <h4 class="font-semibold text-xl">Welcome!</h4>
                </CardHeader>
                <CardContent>
                    <p>Anda sudah masup</p>
                </CardContent>
            </Card>
        </main>

    </AuthenticatedLayout>
</template>
