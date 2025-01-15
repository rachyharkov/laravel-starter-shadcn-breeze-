<script setup>
import { ChevronLeft, Moon, Sun } from "lucide-vue-next";
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
import { Link } from "@inertiajs/vue3";

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
    "title"
]);
</script>

<template>
    <header class="flex flex-row items-center justify-between w-full px-3">
        <div class="flex flex-row items-center">
            <Button variant="ghost" @click="toggle">
                <ChevronLeft :size="32" :class="{ 'rotate-180': !tgstatus }"/>
            </Button>
            <div class="w-px h-12 bg-gray-200 dark:bg-gray-800 mx-2"></div>
            <div class="flex flex-col justify-start ms-2">
                <Breadcrumb>
                    <BreadcrumbList>
                        <BreadcrumbItem>
                            <BreadcrumbLink href="/">
                                Dashboard
                            </BreadcrumbLink>
                        </BreadcrumbItem>
                    </BreadcrumbList>
                </Breadcrumb>
                <h3 class="font-bold text-2xl">{{ title }}</h3>
            </div>
        </div>
        <div class="flex flex-row items-center gap-5">
            <Button variant="outline" class="w-10 h-10" @click="mode = mode === 'dark' ? 'light' : 'dark'">
                <Moon v-if="mode === 'light'" />
                <Sun v-else />
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
