<script setup>
import Header from "@/Components/Header.vue";
import { Card, CardContent } from "@/Components/ui/card";
import { Table, TableBody, TableCell, TableRow } from "@/Components/ui/table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
// import { Card, CardContent } from "primevue/card";

const props = defineProps({
    role: Object,
});

const breadcrumb = [
    {
        label: "roles",
        currentPage: false,
        href: route("roles.index"),
    },
    {
        label: props.role.name,
        currentPage: true,
    },
];
</script>
<template>
    <AuthenticatedLayout>
        <Header :breadcrumb="breadcrumb" title="Detail Peran" description="Detail data pengguna"/>
        <div class="page-content w-full mt-6 flex flex-row gap-4 justify-center">
            <Table>
                <TableBody>
                    <TableRow v-for="(v, i) in Object.entries(role)" :key="i">
                        <TableCell class="font-medium">{{ v[0] }}</TableCell>
                        <TableCell>{{ v[1] }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AuthenticatedLayout>
</template>
