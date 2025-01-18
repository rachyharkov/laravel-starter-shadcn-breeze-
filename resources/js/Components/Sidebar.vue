<script setup>
    import ApplicationLogo from "@/Components/ApplicationLogo.vue";
    import Dropdown from "@/Components/Dropdown.vue";
    import DropdownLink from "@/Components/DropdownLink.vue";
    import NavLink from "@/Components/NavLink.vue";
    import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
    import { Link } from "@inertiajs/vue3";
    import { Card, CardContent, CardHeader } from "@/Components/ui/card";
    import { Button } from "@/Components/ui/button";
    import { Icon } from "@iconify/vue";
    import { AccordionSidebar, AccordionSidebarContent, AccordionSidebarItem, AccordionSidebarTrigger } from "@/Components/ui/accordion-sidebar";
</script>

<template>
    <div class="p-3 w-72 shrink-0 sticky overflow-hidden transition-all duration-300 data-[show=true]:w-0 data-[show=true]:p-0" id="sidebar" data-show="false">
        <Card class="h-full transition-all">
            <CardHeader class="flex flex-col space-y-2">
                <div class="flex flex-row items-center gap-2">
                    <ApplicationLogo class="w-10 h-10" />
                    <h2 class="font-bold text-3xl">APPNAME</h2>
                </div>
                <div class="flex flex-col space-y-2 rounded-md border-gray-200 dark:border-gray-800 border p-2">
                    <p class="text-sm font-medium leading-none text-muted-foreground">Anda login sebagai</p>
                    <p class="text-base leading-none">{{ $page.props.auth.current_role_session.name }}</p>
                </div>
            </CardHeader>
            <CardContent>
                <div class="flex flex-col items-start gap-3">
                    <Button size="lg" class="w-full justify-start p-0" :variant="route().current('dashboard') ? '' : 'ghost'">
                        <Link :href="$route('dashboard')" class="inline-flex h-full w-full flex-row items-center px-4">
                            <iconify-icon icon="lucide:chart-area" class="text-lg mr-2"/> Dashboard
                        </Link>
                    </Button>
                    <AccordionSidebar type="single" collapsible class="w-full" default-value="item-1">
                        <AccordionSidebarItem value="item-1">
                            <AccordionSidebarTrigger>
                                <iconify-icon icon="lucide:database" class="text-lg mr-2"/>Master Data
                            </AccordionSidebarTrigger>
                            <AccordionSidebarContent>
                                <Button size="lg" class="w-full p-0 w-full" :variant="route().current('roles.index') || $page.url.startsWith('/master-data/roles') ? '' : 'ghost'">
                                    <Link :href="$route('roles.index')" class="ps-11 w-full h-full flex items-center">
                                        Peran
                                    </Link>
                                </Button>
                                <Button size="lg" class="w-full p-0 w-full" :variant="route().current('users.index') || $page.url.startsWith('/master-data/users') ? '' : 'ghost'">
                                    <Link :href="$route('users.index')" class="ps-11 w-full h-full flex items-center">
                                        Pengguna
                                    </Link>
                                </Button>
                            </AccordionSidebarContent>
                        </AccordionSidebarItem>
                    </AccordionSidebar>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
