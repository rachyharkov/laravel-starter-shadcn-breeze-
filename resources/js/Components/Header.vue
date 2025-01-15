<script setup>
import { defineProps, ref } from "vue";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb";
import { Button } from "./ui/button";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from "./ui/dropdown-menu";
import { Avatar, AvatarFallback, AvatarImage } from "./ui/avatar";
import { useColorMode } from "@vueuse/core";
import { Head, Link } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";

const mode = useColorMode()

const tgstatus = ref(true)

const toggle = () => {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        const currentShow = sidebar.getAttribute('data-show') === 'true';
        sidebar.setAttribute('data-show', !currentShow);
        tgstatus.value = !tgstatus.value
    }
}

defineProps([
    "title",
    "breadcrumb",
    "description"
]);
</script>

<template>
    <Head :title="title" />
    <header class="flex flex-row items-center justify-between w-full px-3">
        <div class="flex flex-row items-center">
            <Button variant="ghost" @click="toggle">
                <iconify-icon icon="lucide:chevron-left" :class="{ 'rotate-180': !tgstatus }" />
            </Button>
            <div class="w-px h-12 bg-gray-200 dark:bg-gray-800 mx-2"></div>
            <div class="flex flex-col justify-start ms-2">
                <Breadcrumb>
                    <BreadcrumbList>
                        <BreadcrumbItem v-for="(crumb, index) in breadcrumb" :key="index">
                            <BreadcrumbLink :href="crumb.href">
                                {{ crumb.label }}
                            </BreadcrumbLink>
                        </BreadcrumbItem>
                    </BreadcrumbList>
                </Breadcrumb>
                <h3 class="font-bold text-2xl">{{ title }}</h3>
            </div>
        </div>
        <div class="flex flex-row items-center gap-5">
            <Button variant="outline" class="w-10 h-10" @click="mode = mode === 'dark' ? 'light' : 'dark'">
                <iconify-icon :icon="mode === 'light' ? 'lucide:moon' : 'lucide:sun'"/>
            </Button>
            <DropdownMenu>
                <DropdownMenuTrigger>
                    <Avatar class="w-9 h-9 align-middle">
                        <AvatarImage src="https://github.com/radix-vue.png" alt="@radix-vue" />
                        <AvatarFallback>CN</AvatarFallback>
                    </Avatar>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <DropdownMenuLabel>My Account</DropdownMenuLabel>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem>Profile</DropdownMenuItem>
                    <DropdownMenuItem>Billing</DropdownMenuItem>
                    <DropdownMenuItem>Team</DropdownMenuItem>
                    <DropdownMenuItem>
                        <Link :href="route('logout')" method="post" as="button" class="w-full text-start">Keluar</Link>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </div>
    </header>
</template>
