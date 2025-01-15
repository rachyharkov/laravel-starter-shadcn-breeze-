<script setup>
import Header from "@/Components/Header.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Card, CardContent } from "primevue/card";

const props = defineProps({
    user: Object,
});

const breadcrumb = [
    {
        title: "Users",
        currentPage: false,
        link: route("users.index"),
    },
    {
        title: props.user.name,
        currentPage: true,
    },
];
</script>
<template>
    <AuthenticatedLayout>
        <Header :breadcrumb="breadcrumb" title="Detail User" description="Detail data pengguna"/>
        <div class="page-content">
            <Card>
                <CardContent>
                    <table>
                        <tr>
                            <td colspan="2" class="text-center">
                                <div class="avatar avatar-xl">
                                    <img :src="user.avatar" alt="Avatar" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Name</td>
                            <td>{{ user.name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Username</td>
                            <td>{{ user.username }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email</td>
                            <td>
                                <a
                                    :href="`mailto:${user.email}`"
                                    target="_blank"
                                    >{{ user.email }}</a
                                >
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Role</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Branch</td>
                            <td>SMK Maju Kena Mundur Kena</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email verified at</td>
                            <td>
                                {{
                                    user.email_verified_at
                                        ? user.email_verified_at
                                        : "-"
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Gender</td>
                            <td>{{ user?.gender }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Lahir</td>
                            <td>{{ user.birth_date }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tempat Lahir</td>
                            <td>{{ user.birth_place }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alamat</td>
                            <td>{{ user.address }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Created at</td>
                            <td>{{ user.created_at }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Updated at</td>
                            <td>{{ user.updated_at }}</td>
                        </tr>
                    </table>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
