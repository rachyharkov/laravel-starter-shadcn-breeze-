<script setup>
    import ApplicationLogo from "@/Components/ApplicationLogo.vue";
    import { Link, usePage } from "@inertiajs/vue3";
    import { Card, CardContent, CardHeader } from "@/Components/ui/card";
    import { Button } from "@/Components/ui/button";
    import { ref } from "vue";
    import { Collapsible, CollapsibleContent, CollapsibleTrigger} from '@/Components/ui/collapsible'

    const page = usePage()

    let p = page.props.auth.menu

    // for (let index = 0; index < p.length; index++) {
    //     p[index].show = page.url.startsWith(`/${p[index]['route']}`) ? true : false
    // }

    const menus = ref(p)

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
                    <template v-for="(v, i) in menus">
                        <div class="w-full">
                            <template v-if="v.menu_sub">
                                <Collapsible v-model:open="v.is_expanded" :key="i" :default-open="v.is_expanded">
                                    <CollapsibleTrigger class="w-full">
                                        <Button size="lg" class="w-full justify-between p-0 inline-flex flex-row items-center px-4" variant="ghost">
                                            <div class="flex">
                                                <iconify-icon :icon="v.icon" class="text-lg mr-2"/>
                                                <span class="flex-1">{{ v.name }}</span>
                                            </div>
                                            <iconify-icon
                                                icon="mdi:chevron-down"
                                                class="transition-transform duration-200"
                                                :class="{ 'rotate-180': v.is_expanded }"
                                            />
                                        </Button>
                                    </CollapsibleTrigger>
                                    <CollapsibleContent>
                                        <ul>
                                            <li v-for="(vsm, ksm) in v.menu_sub" :key="ksm">
                                                <Button  size="lg" class="w-full pt-0 pe-0 ps-0 pb-0 w-full" :variant="$page.url.startsWith(`/${v.route}/${vsm.route}`) ? '' : 'ghost'">
                                                    <Link :href="$route(`${v.route}.${vsm.route}.${vsm.module_action[0].action}`)" class="ps-11 w-full h-full flex items-center">
                                                        {{ vsm.name }}
                                                    </Link>
                                                </Button>
                                            </li>
                                        </ul>
                                    </CollapsibleContent>
                                </Collapsible>
                            </template>
                            <template v-else>
                                <Button size="lg" class="w-full justify-start p-0" :variant="$page.url.startsWith(`/${v.route}`) ? '' : 'ghost'">
                                    <Link :href="$route(`${v.route}.${v.module_action[0].action}`)" class="inline-flex h-full w-full flex-row items-center px-4">
                                        <iconify-icon :icon="v.icon" class="text-lg mr-2"/> {{ v.name }}
                                    </Link>
                                </Button>
                            </template>
                        </div>
                    </template>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
