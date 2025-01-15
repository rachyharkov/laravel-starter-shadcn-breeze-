<script setup>
// import DataTable from 'primevue/datatable';
// import Column from 'primevue/column';         // optional
import { computed, ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { debounce } from 'lodash';
import Header from '@/Components/Header.vue';
import { Card, CardContent } from '@/Components/ui/card';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
import { Button } from '@/Components/ui/button';
import { Icon } from '@iconify/vue'
import { Badge } from '@/Components/ui/badge';

const page = usePage()

DataTable.use(DataTablesCore);

const props = defineProps({
    users: Object,
    filters: Object,
    total_users: Number,
})

// const search = ref(props.filters.search)
// const perPage = ref(props.filters.per_page)

const deleteData = (id) => {
    router.delete(route('users.destroy', id), {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => confirm('Anda yakin ingin menghapus?'),
        onSuccess: () => {
            search.value = ''
        },
    })
}

const options = {
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: route('users.index'),
    columns: [{
            title:'Nama',
            data: 'name',
            name: 'name'
        },
        {
            title: 'Email',
            data: 'email',
            name: 'email'
        },
        {
            title: 'Peran',
            data: 'user_roles',
            name: 'user_roles',
            searchable: false,
            sortable: false
        },
        {
            title: 'Created at',
            data: 'created_at',
            name: 'created_at'
        }
    ],
    language: {
    "processing"    :   "<div class='text-center p-4 rounded-lg' style='background-color: hsl(var(--border));color: hsl(var(--dt-text-footer-foreground-general));'>&emsp;Processing ...</div>",
    }
}

// watch(search, debounce(function (value) {
//     router.get(route('users.index'), { search: value }, { preserveScroll: true, preserveState: true, replace: true })
// }, 300))
</script>

<template>
    <AuthenticatedLayout>
        <Header :breadcrumb="[{ label: 'Pengguna', currentPage: true }]" title="Daftar Pengguna" description="User adalah semua pengguna terdaftar yang dapat mengakses aplikasi, termasuk guru, siswa, orang tua hingga para staff."/>
        <div class="w-full">
            <DataTable :options="options">
                <template #column-email="props">
                    <a class="underline" :href="`mailto:${props.cellData}`">{{ props.cellData }}</a>
                </template>
                <template #column-user_roles="props">
                    <template v-for="(v, i) in props.cellData">
                        <Badge variant="outline">
                            <span :class="v.is_active == 0 ? 'text-red-500 dark:text-red-800' : 'text-green-500 dark:text-green-800'" class="flex flex-row gap-1 items-center"><iconify-icon icon="lucide:disc"/>{{ v.name }}</span>
                        </Badge>
                    </template>
                </template>
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>


