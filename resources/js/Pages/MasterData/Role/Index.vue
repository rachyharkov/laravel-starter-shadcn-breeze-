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

const deleteData = (id) => {
    router.delete(route('roles.destroy', id), {
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
    ajax: route('roles.index'),
    columns: [{
            title:'Nama',
            data: 'name',
            name: 'name',
        },
        {
            title: 'Aksi',
            name: 'action',
            searchable: false,
            sortable: false
        },
    ],
    columnDefs: [
        {
            targets: 1, // Assuming the 'Aksi' column is the second column (index 1)
            className: '!text-end'
        }
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
        <Header :breadcrumb="[{ label: 'Peran', currentPage: true }]" title="Daftar Peran" description="Peran digunakan untuk mengelompokan pengguna yang ter-registrasi di sistem."/>
        <div class="w-full">
            <Alert :variant="$page.props.messages.envelopes[0].type" class="mt-4" v-if="$page.props.messages.envelopes.length > 0">
                <iconify-icon :icon="$page.props.messages.envelopes[0].type == 'error' ? 'lucide:circle-alert' : 'lucide:check'" class="w-4 h-4"/>
                <AlertTitle>{{$page.props.messages.envelopes[0].title}}</AlertTitle>
                <AlertDescription>
                    {{$page.props.messages.envelopes[0].message}}
                </AlertDescription>
            </Alert>
            <div class="flex flex-row justify-between items-center mt-4">
                <Input v-model="search_keyword" placeholder="Ketik Pencarian disini"/>
                <Button as-child>
                    <Link :href="route('roles.create')">Tambah Baru</Link>
                </Button>
            </div>
            <DataTable :options="options" ref="table">
                <template #column-action="props">
                    <div class="flex flex-row items-center justify-end gap-1">
                        <Button variant="secondary" size="sm" asChild>
                            <Link :href="route('roles.edit', props.rowData.id)">
                                <iconify-icon icon="lucide:file-pen-line"/> Edit
                            </Link>
                        </Button>
                        <Button variant="destructive" size="sm" v-on:click="deleteData(props.rowData.id)" v-if="props.rowData.id !== 1">
                            <iconify-icon icon="lucide:trash-2"/>
                        </Button>
                    </div>
                </template>
            </DataTable>
        </div>
    </AuthenticatedLayout>
</template>


