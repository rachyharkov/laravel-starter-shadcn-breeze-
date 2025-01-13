<script setup>
import AppHead from '@/Components/AppHead.vue';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #headernya>
            <AppHead title="Dashboardn" />
        </template>
        <Card>
            <CardHeader>
                <h4 class="font-semibold text-xl">Welcome!</h4>
            </CardHeader>
            <CardContent>
                <p>Anda sudah masup</p>
            </CardContent>
        </Card>
    </AuthenticatedLayout>
</template>
