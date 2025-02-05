<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';
import { Checkbox } from '@/Components/ui/checkbox';

import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate';
import * as z from 'zod'
import { FormControl, FormDescription, FormField, FormItem, FormLabel, FormMessage } from '@/Components/ui/form';
import { Card, CardContent, CardHeader } from '@/Components/ui/card';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Icon } from '@iconify/vue';
// import { Loader2 } from 'lucide-vue-next';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const formSchema = toTypedSchema(z.object({
  email: z.string().min(8).max(50).email(),
  password: z.string().min(8),
  remember: z.boolean().optional()
}))

const { handleSubmit, isSubmitting } = useForm({
  validationSchema: formSchema,
})

const onSubmit = handleSubmit((values, actions) => {
    return new Promise((resolve, reject) => {
        router.post(route('login'), values, {
            onSuccess: (page) => {
                console.log('success');
                resolve();
            },
            onFinish: () => {
                console.log('finish');
            },
            onError: (errors) => {
                Object.keys(errors).forEach(key => {
                    actions.setFieldError(key, errors[key]);
                });
                resolve()
            }
        });
    });
})

</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <Card class="sm:max-w-md w-full overflow-hidden">
            <CardHeader>
                <Link href="/" class="flex justify-center">
                    <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
                </Link>
            </CardHeader>
            <CardContent>
                <form @submit="onSubmit">
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input type="text" class="mt-1 block w-full" v-bind="componentField" required autofocus autocomplete="username" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField class="mt-4" v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel>Password</FormLabel>
                            <FormControl>
                                <Input type="password" class="mt-1 block w-full" v-bind="componentField" required autocomplete="current-password" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>

                    <FormField v-slot="{ value, handleChange }" name="remember" >
                        <FormItem class="flex flex-row items-center space-x-2 space-y-0 mt-3">
                            <FormControl>
                                <Checkbox
                                    @update:checked="handleChange"
                                />
                            </FormControl>
                            <FormLabel for="remember">
                                Ingat saya
                            </FormLabel>
                        </FormItem>
                    </FormField>

                    <div class="mt-4 flex items-center justify-end">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Lupa Password?
                        </Link>

                        <Button
                            class="ms-4"
                            :class="{ 'opacity-25': isSubmitting }"
                            :disabled="isSubmitting"
                            type="submit"
                        >
                            <iconify-icon icon="lucide:loader-circle" class="w-5 h-5 mx-3 animate-spin" v-show="isSubmitting"/>
                            <span v-show="!isSubmitting">
                                Masuk
                            </span>
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </GuestLayout>
</template>
