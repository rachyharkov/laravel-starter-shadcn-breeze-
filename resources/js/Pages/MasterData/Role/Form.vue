<script setup>
import { router, useForm } from '@inertiajs/vue3'
import { Input } from '@/Components/ui/input'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/Components/ui/card'
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/Components/ui/select'
import { Button } from '@/Components/ui/button'
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/Components/ui/textarea'
import { Link } from '@inertiajs/vue3'
import { reactive, ref } from 'vue'
import { Avatar, AvatarFallback, AvatarImage } from '@/Components/ui/avatar'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/Components/ui/dropdown-menu'
import { Switch } from '@/Components/ui/switch'
import { RadioGroup, RadioGroupItem } from '@/Components/ui/radio-group'

const props = defineProps({
    role: Object,
})

const isEdit = props?.role?.id ? true : false

const fileInputRef = ref()

const form = useForm('UpdateRole', {
    _method: 'put',
    name: props?.role?.name ?? '',
    description: props?.role?.description ?? '',
    is_active: props?.role?.is_active ?? true,
    color: props?.role?.color ?? '#000000',
    save_and_back: false,
})

const saveAndback = () => {
    form.save_and_back = true
    save()
}

const save = () => {
    if (isEdit) {
        form.post(route('master-data.roles.update', props?.role?.id), {
            preserveScroll: true
        })
    } else {
        form._method = 'post'
        form.post(route('master-data.roles.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
            },
            onFinish: () => {
                form.reset('name')
            }
        })
    }
}
</script>

<template>
    <div class="w-full" v-if="$page?.props?.flash">
        <Alert :variant="$page.props.messages.envelopes[0].type" class="mt-4" v-if="$page.props.messages.envelopes.length > 0">
            <iconify-icon icon="lucide:check" class="w-4 h-4"/>
            <AlertTitle>{{$page.props.messages.envelopes[0].title}}</AlertTitle>
            <AlertDescription>
                {{$page.props.messages.envelopes[0].message}}
            </AlertDescription>
        </Alert>
    </div>
    <form @submit.prevent="save" novalidate>
        <div class="w-full flex justify-center flex-col gap-4">
            <Alert v-if="form.isDirty">
                <iconify-icon icon="lucide:circle-alert" class="h-4 w-4"/>
                <AlertTitle>Jangan Lupa Simpan</AlertTitle>
                <AlertDescription>Terdapat perubahan data, pastikan anda sudah menyimpannya</AlertDescription>
            </Alert>
            <Card class="flex flex-row">
                <CardHeader class="w-1/3">
                    <CardTitle>Nama Peran</CardTitle>
                    <CardDescription>
                        Nama ini digunakan untuk mengidentifikasi sekelompok pengguna yang memiliki peran ini
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 max-w-lg w-full flex flex-col gap-5">
                    <div class="flex flex-col flex-wrap gap-3">
                        <div class="grid items-center gap-2">
                            <Label for="name">Nama</Label>
                            <Input id="name" type="text" placeholder="John Doe" :error="form.errors.name" v-model="form.name" />
                        </div>
                    </div>
                    <div class="flex flex-col flex-wrap gap-3">
                        <div class="grid items-center gap-2">
                            <Label for="description">Deskripsi</Label>
                            <Input id="description" type="text" placeholder="John Doe" :error="form.errors.description" v-model="form.description" />
                        </div>
                    </div>
                </CardContent>
            </Card>
            <Card class="flex flex-row">
                <CardHeader class="w-1/3">
                    <CardTitle>Indikator/Status</CardTitle>
                    <CardDescription>
                        Tentukan warna dan status berjalan atau tidaknya peran ini
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 max-w-lg w-full flex flex-col gap-5">
                    <div class="flex flex-col flex-wrap gap-3">
                        <div class="grid items-center gap-2">
                            <Label for="color">Warna Indikator</Label>
                            <Input id="color" type="color" placeholder="John Doe" class="justify-self-start w-48" :error="form.errors.color" v-model="form.color" />
                        </div>
                    </div>
                    <div class="flex flex-col flex-wrap gap-3">
                        <div class="grid items-center gap-2">
                            <Label for="description">Status</Label>
                            <Switch v-model="form.is_active" />
                        </div>
                    </div>
                </CardContent>
            </Card>
            <div class="flex flex-row justify-end gap-2 ps-4 items-center">
                <Button type="submit" :disabled="form.processing">
                    {{ isEdit ? 'Update' : 'Simpan' }}
                </Button>

                <Button type="button" severity="secondary" :disabled="form.processing" @click="saveAndback"
                    v-if="!isEdit">
                    Simpan & Kembali
                </Button>

                <Button variant="destructive" as-child :disabled="form.processing">
                    <Link :href="route('master-data.roles.index')">Kembali</Link>
                </Button>
            </div>
        </div>
    </form>
</template>
