<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import { onMounted, ref, watch } from "vue";
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from "@/Components/ui/card";
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
import { Button } from "@/Components/ui/button";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/Components/ui/tabs";
import { Badge } from "@/Components/ui/badge";
import axios from "axios";
import { Checkbox } from "@/Components/ui/checkbox";
import { useToast } from '@/components/ui/toast/use-toast'

DataTable.use(DataTablesCore);

const table_user = ref();

const options_user = {
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
        url: route('system.permissions.index') + '?users=true',
    },
    columns: [{
            title:'Nama',
            data: 'name',
            name: 'name'
        },
        {
            title: 'Peran',
            data: 'user_roles',
            name: 'user_roles',
            searchable: false,
            sortable: false
        },
        {
            title: '',
            name: 'action',
            searchable: false,
            sortable: false
        },
    ],
    language: {
        processing    :   "<div class='text-center p-4 rounded-lg' style='background-color: hsl(var(--border));color: hsl(var(--dt-text-footer-foreground-general));'>&emsp;Processing ...</div>"
    },
    layout: {
        topEnd: 'search',
        bottomStart: 'info',
        bottomEnd: 'paging'
    }
}

const { toast } = useToast()
const menus = ref([])

const get_menus = () => {
    axios.get(route('system.permissions.index') + '?menus=true')
        .then(response => {
            menus.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}

const update_permission = async (role_id, module_action_id, checked) => {
    const index_menu = menus.value.findIndex(menu => menu.id == module_action_id)
    const menu_module_action_id = menus.value[index_menu].allows.findIndex(allow => allow.id === role_id)
    const state_before = menus.value[index_menu].allows[menu_module_action_id].allow

    menus.value[index_menu].allows[menu_module_action_id].allow = 'loading'

    try {
        const response = await axios.put(route('system.permissions.update', 'ppp'), {
            role_id: role_id,
            module_action_id: module_action_id,
            allow: checked
        })
        // console.log(response.data)
        menus.value[index_menu].allows[menu_module_action_id].allow = response.data.data.allow
    } catch (error) {
        console.error('Error updating permission:', error)
        menus.value[index_menu].allows[menu_module_action_id].allow = state_before
        toast({
            title: error.response.statusText,
            description: error.response.data.message,
            variant: 'destructive'
        });
    }
}

onMounted(() => {
    get_menus()
})

</script>

<template>
    <AuthenticatedLayout>
        <Header
            :breadcrumb="[{ label: 'Hak Akses', currentPage: true }]"
            title="Pengaturan Hak Akses"
            description="Tentukan hak akses berdasarkan pengguna maupun perannya."
        />
        <div class="w-full mt-4">
            <Card>
                <CardHeader>
                    <h2 class="text-lg font-semibold">Quick Actions</h2>
                </CardHeader>
                <CardContent>
                    <div class="flex flex-row gap-2">
                        <Card>
                            <CardHeader>
                                <h2 class="text-lg font-semibold">
                                    Tambah Pengguna
                                </h2>
                            </CardHeader>
                            <CardContent>
                                <p class="text-sm">
                                    Tambah pengguna baru ke dalam sistem.
                                </p>
                            </CardContent>
                            <CardFooter>
                                <Button>Tambah Baru</Button>
                            </CardFooter>
                        </Card>
                        <Card>
                            <CardHeader>
                                <h2 class="text-lg font-semibold">
                                    Atur Peran
                                </h2>
                            </CardHeader>
                            <CardContent>
                                <p class="text-sm">
                                    Edit peran yang ter-registrasi di sistem.
                                </p>
                            </CardContent>
                            <CardFooter>
                                <Button>Peran</Button>
                            </CardFooter>
                        </Card>
                    </div>
                </CardContent>
            </Card>
        </div>
        <Card class="mt-4 w-full">
            <CardHeader>
                <h2 class="text-lg font-semibold">Atur Akses Berdasarkan</h2>
            </CardHeader>
            <CardContent>
                <Tabs default-value="account" class="min-w-2xl">
                    <TabsList>
                        <TabsTrigger value="account"> Pengguna </TabsTrigger>
                        <TabsTrigger value="password"> Peran </TabsTrigger>
                    </TabsList>
                    <TabsContent value="account">
                        <DataTable :options="options_user" ref="table_user">
                            <template #column-user_roles="props">
                                <template v-for="(v, i) in props.cellData">
                                    <Badge variant="outline" :style="{ borderColor: v.color }">
                                        <span class="flex flex-row gap-1 items-center" :style="{color: v.color}"><iconify-icon icon="lucide:disc"/>{{ v.name }}</span>
                                    </Badge>
                                </template>
                            </template>
                            <template #column-action="props">
                                <div class="flex flex-row items-center gap-1">
                                    <Button variant="ghost" size="sm">
                                        <iconify-icon icon="lucide:settings-2"/>
                                    </Button>
                                </div>
                            </template>
                        </DataTable>
                    </TabsContent>
                    <TabsContent value="password">
                        <Card>
                            <CardContent class="px-0 pb-6 pt-0">
                                <table class="w-full">
                                    <tbody>
                                        <tr class="border-b border-gray-200">
                                            <td class="font-medium text-gray-500 ps-4 py-3">Menu</td>
                                            <td v-for="(role, i) in $page.props.available_roles" :key="i" style="width: 1%; white-space: nowrap;"><span class="px-4 py-3 font-medium">{{ role.name }}</span></td>
                                        </tr>
                                        <tr v-for="(menu, i) in menus" :key="i" class="border-b">
                                            <td class="px-4 py-3" :class="{ 'bg-gray-100': menu.icon ?? false }" :colspan="menu.icon ? $page.props.available_roles.length + 1 : 1">
                                                <div class="flex flex-row items-center gap-2">
                                                    <iconify-icon v-if="menu.icon" :icon="menu.icon"/> <span>{{ menu.name }}</span>
                                                </div>
                                            </td>
                                            <template v-if="!menu.icon">
                                                <td v-for="(role, j) in $page.props.available_roles" :key="j" class="px-4 py-3">
                                                    <Checkbox
                                                        :checked="menu.allows?.find(allow => allow.id === role.id)?.allow ?? false" @update:checked="(isChecked) => update_permission(role.id, menu.id, isChecked)" :disabled="menu.allows?.find(allow => allow.id === role.id)?.allow === 'loading'"
                                                    />
                                                </td>
                                            </template>
                                        </tr>
                                    </tbody>
                                </table>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </CardContent>
        </Card>
    </AuthenticatedLayout>
</template>
