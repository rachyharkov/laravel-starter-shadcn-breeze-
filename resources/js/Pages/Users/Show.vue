<script setup>
import Header from "@/Components/Header.vue";
import { Card, CardContent } from "@/Components/ui/card";
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
// import { Card, CardContent } from "primevue/card";

const props = defineProps({
    user: Object,
});

const breadcrumb = [
    {
        label: "Users",
        currentPage: false,
        href: route("users.index"),
    },
    {
        label: props.user.name,
        currentPage: true,
    },
];
</script>
<template>
    <AuthenticatedLayout>
        <Header :breadcrumb="breadcrumb" title="Detail User" description="Detail data pengguna"/>
        <div class="page-content w-full mt-6 flex flex-row gap-4 justify-center">
            <div class="avatar avatar-xl">
                <img :src="user.avatar" alt="Avatar" class="w-40" />
            </div>
            <Card>
                <CardContent class="pt-6">
                    <Table>
                        <TableBody>
                            <TableRow v-for="(v, i) in Object.entries(user)" :key="i">
                                <TableCell class="font-medium">{{ v[0] }}</TableCell>
                                <TableCell>{{ v[1] }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
