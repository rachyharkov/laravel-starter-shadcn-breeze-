<script setup>
import Header from '@/Components/Header.vue';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <Header title="Dashboardn" />
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
