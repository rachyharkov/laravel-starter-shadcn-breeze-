<script setup>
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
</script>

<template>
    <div class="p-3 w-72 shrink-0 sticky overflow-hidden transition-all duration-300 data-[show=true]:w-0 [&[data-show='true']>div]:opacity-0 [&[data-show='false']>div]:opacity-100" id="sidebar" data-show="false">
        <Card class="h-full transition-all">
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
</template>
