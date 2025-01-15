<script setup>
import { router, useForm } from '@inertiajs/vue3'
import { Input } from '@/Components/ui/input'
import { Card, CardContent, CardDescription, CardHeader } from '@/Components/ui/card'
import { Select } from '@/Components/ui/select'
import { Button } from '@/Components/ui/button'
// import { AlertCircle } from 'lucide-vue-next'
import { Alert, AlertDescription, AlertTitle } from '@/Components/ui/alert'
import { Icon } from '@iconify/vue'

const props = defineProps({
    user: Object,
    user_roles: Object,
})

const isEdit = props?.user?.id ? true : false

const form = useForm('CreateUser', {
    username: props?.user?.username ?? '',
    name: props?.user?.name ?? '',
    email: props?.user?.email ?? '',
    code: props?.user?.code ?? '',
    branch_id: '',
    role_id: props?.user?.role_id ?? '',
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
        form.put(route('users.update', props.user.id), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
                form.clearErrors()
            },
            onFinish: () => {
                form.reset('password', 'password_confirmation')
            },
        })
    } else {
        form.post(route('users.store'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset()
                form.clearErrors()
            },
            onFinish: () => {
                form.reset('password', 'password_confirmation')
            },
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

const roleOptions = props?.user_roles?.map((role) => {
    return {
        label: role.name,
        value: role.id
    }
});

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
    <div class="flex flex-row flex-wrap mb-3">
        <div class="w-full" v-if="$page?.props?.flash">
            <Alert variant="destructive">
                <iconify-icon icon="lucide:circle-alert" class="w-4 h-4"/>
                <AlertTitle>Perhatian</AlertTitle>
                <AlertDescription>
                    $page.props.flash.message
                </AlertDescription>
            </Alert>
        </div>
        <Form v-slot="$form" :resolver="resolver" :initialValues="form" @submit="save" class="flex justify-center flex-col gap-4">
            <div class="w-full">
                <div v-if="form.isDirty" class="alert alert-warning">Terdapat perubahan data yang belum disimpan, pastikan
                    kamu menyimpannya ya!</div>
                <Card>
                    <CardHeader>
                        Infromasi Dasar
                    </CardHeader>
                    <CardDescription>
                        Informasi yang wajib dimiliki oleh setiap pengguna untuk menggunakan aplikasi
                    </CardDescription>
                    <CardContent>
                        <div class="flex flex-row">
                            <div class="w-1/3">
                                <InputText name="username" type="text"  placeholder="Username" required autofocus />
                            </div>

                            <div class="w-1/3">
                                <InputText name="name" type="text"  placeholder="Name" />
                            </div>

                            <div class="w-1/3">
                                <InputText name="email" type="email"  placeholder="Email" />
                            </div>

                            <div class="w-1/3">
                                <InputText name="code" type="number"  placeholder="NISN/NIP" />
                            </div>

                            <!-- <div class="w-1/3">
                                <Select id" :options="branchOptions" placeholder="Cabang" name="branch_id" type="text"
                                 />
                            </div> -->

                            <div class="w-1/3">
                                <Select v-bind="form.role_id">
                                    <FormControl>
                                        <SelectTrigger>
                                            <SelectValue placeholder="Pilih peran" />
                                        </SelectTrigger>
                                    </FormControl>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem v-for="(v, i) in roleOptions" :value="v.value">
                                                {{ v.label }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        Password
                    </CardHeader>
                    <CardDescription>
                        Buatlah password yang sulit ditebak dengan gabungan huruf, angka, atau bahkan simbol seperti: <small>!@#$%</small>.
                    </CardDescription>
                    <CardContent>
                        <div class="flex flex-row">
                            <div class="w-1/2">
                                <InputText name="password" type="password" placeholder="Password" />
                                <Message v-if="$form.email?.invalid" severity="error" size="small" variant="simple">{{ $form.email.error?.message }}</Message>
                                <small class="font-light" v-if="isEdit">Biarkan password dan password konfirmasi kosong jika tidak ingin menggantinya.</small>
                            </div>

                            <div class="w-1/2">
                                <InputText name="password_confirmation" placeholder="Konfirmasi Password" type="passsword" />
                            </div>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        Informasi Tambahan
                    </CardHeader>
                    <CardDescription>
                        Informasi yang bersifat opsional, anda dapat mengosongkannya.
                    </CardDescription>
                    <CardContent>
                        <div class="flex flex-row flex-wrap">
                            <div class="w-1/4">
                                <InputText name="phone" type="text" placeholder="No. Telepon" />
                            </div>

                            <div class="w-1/4">
                                <InputText name="birth_place" type="text" placeholder="Tempat Lahir" />
                            </div>

                            <div class="w-1/4">
                                <InputText name="birth_date" type="date" placeholder="Tanggal Lahir" />
                            </div>

                            <div class="w-1/4">
                                <Select :options="genderOptions" placeholder="Jenis Kelamin" name="gender"/>
                            </div>

                            <div class="w-1/4">
                                <Textarea placeholder="Alamat" name="address" />
                            </div>

                            <div class="w-1/4">
                                <template v-if="isEdit">
                                    <div class="flex flex-row">
                                        <div class="w-2/12">
                                            <div class="avatar avatar-xl">
                                                <img :src="user.avatar" alt="Avatar">
                                            </div>
                                        </div>
                                        <div class="w-10/12">
                                            <input name="avatar" placeholder="Foto" type="file" />
                                            <small class="fw-light">Biarkan kosong jika tidak ingin diganti.</small>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <input name="avatar" placeholder="Foto" type="file" />
                                </template>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- <template v-if="form.progress">
                    <ProgressBar :value="form.progress.percentage"></ProgressBar>
                </template> -->

                <Button type="submit" :disabled="form.processing">
                    {{ isEdit ? 'Update' : 'Simpan' }}
                </Button>

                <Button type="button" severity="secondary" :disabled="form.processing" @click="saveAndback"
                    v-if="!isEdit">
                    Simpan & Kembali
                </Button>

                <Button variant="link" severity="danger" :disabled="form.processing" :href="route('users.index')">Kembali</Button>
            </div>
        </Form>
    </div>
</template>
