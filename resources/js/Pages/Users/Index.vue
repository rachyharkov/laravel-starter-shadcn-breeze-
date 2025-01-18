<script setup>
// import DataTable from 'primevue/datatable';
// import Column from 'primevue/column';         // optional
import { router, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
import 'datatables.net-buttons-dt';
import { Button } from '@/Components/ui/button';
import { Badge } from '@/Components/ui/badge';
import { Link } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert';
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar';
import { ref, watch } from 'vue';
import Input from '@/Components/ui/input/Input.vue';

DataTable.use(DataTablesCore);

const table = ref();
const search_keyword = ref(null)

const props = defineProps({
    users: Object,
    filters: Object,
    total_users: Number,
})

const deleteData = (id) => {
    router.delete(route('users.destroy', id), {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => confirm('Anda yakin ingin menghapus?'),
        onFinish: () => table.value.dt.ajax.reload()
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
            title: 'Teregistrasi pada',
            data: 'created_at',
            name: 'created_at'
        },
        {
            title: 'Aksi',
            name: 'action',
            searchable: false,
            sortable: false
        },
    ],
    language: {
        processing    :   "<div class='text-center p-4 rounded-lg' style='background-color: hsl(var(--border));color: hsl(var(--dt-text-footer-foreground-general));'>&emsp;Processing ...</div>"
    },
    layout: {
        topStart: null,
        topEnd: null,
        bottomStart: {
            className: 'flex flex-row items-center gap-2',
            features: ['pageLength', 'info']
        }
    }
}

watch(search_keyword, (newValue) => {
    table.value.dt.search(newValue).draw();
});
</script>

<template>
    <AuthenticatedLayout>
        <Header :breadcrumb="[{ label: 'Pengguna', currentPage: true }]" title="Daftar Pengguna" description="User adalah semua pengguna terdaftar yang dapat mengakses aplikasi, termasuk guru, siswa, orang tua hingga para staff."/>
        <div class="w-full">
            <Alert :variant="$page.props.messages.envelopes[0].type" class="mt-4" v-if="$page.props.messages.envelopes.length > 0">
                <iconify-icon icon="lucide:check" class="w-4 h-4"/>
                <AlertTitle>{{$page.props.messages.envelopes[0].title}}</AlertTitle>
                <AlertDescription>
                    {{$page.props.messages.envelopes[0].message}}
                </AlertDescription>
            </Alert>
            <div class="flex flex-row justify-between items-center mt-4">
                <Input v-model="search_keyword" placeholder="Ketik Pencarian disini"/>
                <Button as-child>
                    <Link :href="route('users.create')">Tambah Baru</Link>
                </Button>
            </div>
            <DataTable :options="options" ref="table">
                <template #column-name="props">
                    <div class="flex flex-row items-center gap-2">
                        <Avatar>
                            <AvatarImage :src="props.rowData.avatar" alt="Foto profil" />
                            <AvatarFallback>{{ props.rowData.name ? props.rowData.name.split(' ').slice(0, 2).map(n => n[0]).join('') : 'CN' }}</AvatarFallback>
                        </Avatar>
                        <span>
                            <Link :href="route('users.show', props.rowData.id)">{{ props.rowData.name }}</Link>
                        </span>
                    </div>
                </template>
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
                <template #column-action="props">
                    <div class="flex flex-row items-center gap-1">
                        <Button variant="secondary" size="sm" asChild>
                            <Link :href="route('users.edit', props.rowData.id)">
                                <iconify-icon icon="lucide:file-pen-line"/> Edit
                            </Link>
                        </Button>
                        <Button variant="destructive" size="sm" v-on:click="deleteData(props.rowData.id)">
                            <iconify-icon icon="lucide:trash-2"/>
                        </Button>
                    </div>
                </template>
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>


