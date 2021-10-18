<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicial
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">NOME</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <th scope="row">1</th>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>
                                        <Link :href="user.edit_url" class="underline text-sm text-gray-600 hover:text-gray-900">
                                            Editar
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import { computed } from 'vue'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link
    },
    data() {
        return {
            users: '' 
        }
    },
    created() {
    },
    mounted() {
    },
    methods:{
        
    }
}
</script>
