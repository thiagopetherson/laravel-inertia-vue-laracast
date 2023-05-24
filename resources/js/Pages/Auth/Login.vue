<template>
    <Head title="Login" />

    <main class="p-8 bg-gray-100 min-h-screen flex flex-col justify-center items-center">
        <form @submit.prevent="submit" class="p-6 space-y-6 max-w-md mx-auto bg-white border border-gray-200" style="min-width: 500px;">
            <h1 class="text-4xl font-bold text-center">Login</h1>
            <div>
                <div class="flex justify-between">
                    <label for="email" class="block pb-2 font-bold text-xs text-gray-600">Email Address</label>
                    <p v-if="form.errors.email" class="ml-6 text-xs font-bold text-red-600">{{ form.errors.email }}</p>
                </div>
                <input v-model="form.email" type="email" email="email" id="email" class="border border-gray-200 p-2 w-full" :class="{ 'border-red-600': form.errors.email }" required>
            </div>
            <div>
                <div class="flex justify-between">
                    <label for="password" class="block pb-2 font-bold text-xs text-gray-600">Password</label>
                    <p v-if="form.errors.password" class="ml-6 text-xs font-bold text-red-600">{{ form.errors.password }}</p>
                </div>
                <input v-model="form.password" type="password" password="password" id="password" class="border border-gray-200 p-2 w-full" :class="{ 'border-red-600': form.errors.password }" required>
            </div>
            <div class="text-right">
                <Link href="/register" class="underline text-sm text-gray-600 hover:text-gray-900 mr-7" method="GET">
                    Already registered ?
                </Link>
                <button type="submit" as="button" class="bg-blue-600 hover:bg-blue-900 px-4 py-2 font-bold text-white disabled:bg-gray-600" :disabled="form.processing" preserve-scroll>Log In</button>
            </div>
        </form>
    </main>
</template>

<script>
export default {
    layout: null
};
</script>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3'

let form = useForm({
    email: '',
    password: '',
})

let submit = () => {
    form.post('/login');
}
</script>
