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
    user: Object,
    user_roles: Object,
    roles: Array
})

const isEdit = props?.user?.id ? true : false

const fileInputRef = ref()

const form = useForm('UpdateUser', {
    _method: 'put',
    username: props?.user?.username ?? '',
    name: props?.user?.name ?? '',
    email: props?.user?.email ?? '',
    code: props?.user?.code ?? '',
    branch_id: '',
    role_id: props?.user?.role_id?.toString() ?? '',
    is_active: props?.user?.is_active ?? '',
    password: '',
    password_confirmation: '' ?? '',
    birth_date: props?.user?.birth_date ?? '',
    birth_place: props?.user?.birth_place ?? '',
    gender: props?.user?.gender ?? '',
    address: props?.user?.address ?? '',
    phone: props?.user?.phone ?? '',
    avatar: '',
    save_and_back: false,
})

const saveAndback = () => {
    form.save_and_back = true
    save()
}

const save = () => {
    if (isEdit) {
        form.post(route('master-data.users.update', props?.user?.id), {
            preserveScroll: true
        })
    } else {
        form._method = 'post'
        form.post(route('master-data.users.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
            },
            onFinish: () => {
                form.reset('password', 'password_confirmation')
            }
        })
    }
}

const genderOptions = [
    {
        label: "Laki-laki",
        value: "MALE"
    },
    {
        label: "Perempuan",
        value: "FEMALE"
    },
]

const roleOptions = props.roles.reduce((acc, role) => {
    acc[role.id] = role.name;
    return acc;
}, {});

const anu = (a) => {
    return URL.createObjectURL(a)
}

// const branchOptions = [
//     {
//         label: "SMK Maju Kena Mundur Kena",
//         value: 1
//     },
//     {
//         label: "SMK Maju Kena Mundur Kena II",
//         value: 2
//     },
// ]


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
                    <CardTitle>Infromasi Dasar</CardTitle>
                    <CardDescription>
                        Informasi yang wajib dimiliki oleh setiap pengguna untuk menggunakan aplikasi
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 max-w-lg w-full">
                    <div class="flex flex-col flex-wrap gap-3">
                        <div class="grid items-center gap-1.5">
                            <Label for="name">Nama</Label>
                            <Input id="name" type="text" placeholder="John Doe" :error="form.errors.name" v-model="form.name" />
                        </div>

                        <div class="grid items-center gap-1.5">
                            <Label for="email">Email</Label>
                            <Input id="email" type="email" placeholder="johndoe@example.com" :error="form.errors.email" v-model="form.email" />
                        </div>

                        <div class="grid items-center gap-1.5">
                            <Label for="code">NO KTP/KITAS/SIM</Label>
                            <Input id="code" type="text" placeholder="3216xxxxxxxxxxxxxxxxxxxx" :error="form.errors.code" v-model="form.code"/>
                        </div>

                        <!-- <div class="grid items-center gap-1.5">
                            <Select id" :options="branchOptions" placeholder="Cabang" name="branch_id" type="text"
                                />
                        </div> -->

                        <div class="grid items-center gap-1.5">
                            <Label for="role_id">Peran</Label>
                            <Select id="role_id" v-model="form.role_id">
                                <SelectTrigger :error="form.errors.role_id">
                                    <SelectValue placeholder="Pilih peran"/>
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(v, i) in roleOptions" :value="i">
                                            {{ v }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                    </div>
                </CardContent>
            </Card>
            <Card class="flex flex-row">
                <CardHeader class="w-1/3">
                    <CardTitle>Status</CardTitle>
                    <CardDescription>
                        Tentukan apakah akun dapat aktif masuk ke sistem
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 max-w-lg w-full">
                    <div class="flex flex-col flex-wrap gap-3">
                        <RadioGroup v-model="form.is_active">
                            <div class="flex items-start space-x-2 my-1">
                                <RadioGroupItem id="1" value="1" />
                                <Label for="1" class="flex flex-col">
                                    <span class="font-bold mb-1">Aktif</span>
                                    <span class="text-sm font-light">User dapat melakukan login ke dalam sistem</span>
                                </Label>
                            </div>
                            <div class="flex items-start space-x-2 my-1">
                                <RadioGroupItem id="0" value="0" />
                                <Label for="0" class="flex flex-col">
                                    <span class="font-bold mb-1">Tidak Aktif</span>
                                    <span class="text-sm font-light">User akan dinonaktifkan dan tidak dapat masuk ke sistem</span>
                                </Label>
                            </div>
                        </RadioGroup>
                    </div>
                </CardContent>
            </Card>

            <Card class="flex flex-row">
                <CardHeader class="w-1/3">
                    <CardTitle>Akun</CardTitle>
                    <CardDescription>
                        Buatlah Username unik dan password yang sulit ditebak dengan gabungan huruf, angka, atau bahkan simbol seperti: <small>!@#$%</small>.
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 max-w-lg w-full">
                    <div class="flex flex-col flex-wrap gap-3">
                        <Alert v-if="isEdit">
                            <iconify-icon icon="lucide:circle-alert" class="h-4 w-4"/>
                            <AlertDescription>Biarkan password dan password konfirmasi kosong jika tidak ingin menggantinya.</AlertDescription>
                        </Alert>
                        <div class="w-full grid items-center gap-1.5">
                            <Label for="username">Username</Label>
                            <Input id="username" placeholder="johndoe24" type="text" autocomplete="username" :error="form.errors.username" v-model="form.username" />
                        </div>

                        <div class="w-full grid items-center gap-1.5">
                            <Label for="password">Password</Label>
                            <Input id="password" type="password" autocomplete="new-password" placeholder="password" :error="form.errors.password" v-model="form.password"/>
                        </div>
                        <div class="w-full grid items-center gap-1.5">
                            <Label for="password_confirmation">Konfirmasi password</Label>
                            <Input id="password_confirmation" autocomplete="new-password" placeholder="Konfirmasi Password" type="password" v-model="form.password_confirmation" :error="form.password_confirmation == form.password ? null : 'Password tidak sama'" />
                        </div>
                    </div>
                </CardContent>
            </Card>
            <Card class="flex flex-row">
                <CardHeader class="w-1/3">
                    <CardTitle>Informasi Tambahan</CardTitle>
                    <CardDescription>
                        Informasi yang bersifat opsional, anda dapat mengosongkannya.
                    </CardDescription>
                </CardHeader>
                <CardContent class="pt-6 w-2/3 gap-3 flex flex-row pe-0">
                    <div class="flex flex-col w-2/3 flex-wrap gap-3">
                        <div class="w-full grid items-center gap-1.5">
                            <Label for="phone">No. Telepon</Label>
                            <Input name="phone" type="text" placeholder="0812322222" :error="form.errors.phone" v-model="form.phone"/>
                        </div>

                        <div class="w-full grid items-center gap-1.5">
                            <Label for="birth_place">Tempat Lahir</Label>
                            <Input name="birth_place" type="text" placeholder="Jakarta" :error="form.errors.birth_place" v-model="form.birth_place" />
                        </div>

                        <div class="w-full grid items-center gap-1.5">
                            <Label for="birth_date">Tanggal Lahir</Label>
                            <Input name="birth_date" type="date" placeholder="10/10/1990" :error="form.errors.birth_date" v-model="form.birth_date" />
                        </div>

                        <div class="w-full grid items-center gap-1.5">
                            <Label for="gender">Jenis Kelamin</Label>
                            <Select id="gender" v-model="form.gender">
                                <SelectTrigger :error="form.errors.gender">
                                    <SelectValue placeholder="Pilih Jenis Kelamin" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem v-for="(v, i) in genderOptions" :value="v.value">
                                            {{ v.label }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        <div class="w-full grid items-center gap-1.5">
                            <Label for="address">Alamat</Label>
                            <Textarea placeholder="Alamat" name="address":error="form.errors.address" v-model="form.address" />
                        </div>
                    </div>
                    <div class="w-1/3 mx-auto flex flex-col gap-3">
                        <Label>Foto Profil</Label>
                        <div class="mx-auto">
                            <DropdownMenu>
                                <DropdownMenuTrigger>
                                    <div class="relative">
                                        <Avatar size="lg">
                                            <AvatarImage :src="typeof form.avatar === 'object' ? anu(form.avatar) : user.avatar" alt="Foto profil" />
                                            <AvatarFallback>{{ form.name ? form.name.split(' ').map(n => n[0]).join('') : 'CN' }}</AvatarFallback>
                                        </Avatar>
                                        <Button variant="outline" class="absolute bottom-0 left-0">
                                            Edit
                                        </Button>
                                    </div>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent class="w-56" side="bottom">
                                    <DropdownMenuItem v-on:click="fileInputRef.click()">
                                        <span>Upload foto</span>
                                    </DropdownMenuItem>
                                    <DropdownMenuItem v-on:click="form.avatar = 'remove'">
                                        <span>Hapus</span>
                                    </DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                        <p v-if="form.errors.avatar" class="text-red-600 dark:text-red-800 text-sm">{{ form.errors.avatar }}</p>
                        <div class="hidden">
                            <input type="file" @input="form.avatar = $event.target.files[0]" ref="fileInputRef"/>
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
                    <Link :href="route('master-data.users.index')">Kembali</Link>
                </Button>
            </div>
        </div>
    </form>
</template>
