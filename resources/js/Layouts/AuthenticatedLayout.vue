<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import { Card, CardContent, CardHeader } from "@/Components/ui/card";
import { Button } from "@/Components/ui/button";
import { ChartArea, ChevronLeft, Database, Moon, NotebookText, Shield, Users } from "lucide-vue-next";
import { AccordionSidebar, AccordionSidebarContent, AccordionSidebarItem, AccordionSidebarTrigger } from "@/Components/ui/accordion-sidebar";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex flex-row gap-2 h-svh">
        <div class="p-3">
            <Card class="w-64 h-full">
                <CardHeader class="flex flex-row items-center gap-2">
                    <ApplicationLogo class="w-10 h-10" />
                    <h2 class="font-bold text-3xl">LARAVEL</h2>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-col items-start">
                        <Button size="lg" variant="" class="block w-full flex flex-row items-center gap-1 justify-start px-4">
                            <ChartArea :size="42" class="mr-2" /> Dashboard
                        </Button>
                        <AccordionSidebar type="single" collapsible class="w-full">
                            <AccordionSidebarItem value="item-1">
                                <AccordionSidebarTrigger>
                                    <Database class="w-8 h-8 mr-2"/>
                                    Master Data
                                </AccordionSidebarTrigger>
                                <AccordionSidebarContent>
                                    <Button size="lg" variant="ghost" class="block w-full flex flex-row items-center justify-start ps-10">
                                        Peran
                                    </Button>
                                    <Button size="lg" variant="ghost" class="block w-full flex flex-row items-center justify-start ps-10">
                                        Pengguna
                                    </Button>
                                </AccordionSidebarContent>
                            </AccordionSidebarItem>
                        </AccordionSidebar>
                    </div>
                </CardContent>
            </Card>
        </div>
        <div class="flex flex-col items-start justify-start py-3 pe-3 w-full">
            <slot name="headernya"/>
            <main class="w-full mt-4">
                <slot/>
            </main>
        </div>
    </div>
</template>
