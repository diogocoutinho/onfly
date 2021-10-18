<template>
  <Head title="Users" />
  <BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuários
        </h2>
        <div class="flex items-center justify-end">
            <Link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150" :href="route('users.index')">
                Voltar
            </Link>
        </div>
    </template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <BreezeValidationErrors class="mb-4" />

                    <form @submit.prevent="submit">
                        <div>
                            <BreezeLabel for="name" value="Name" />
                            <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                            <BreezeInputErros for="name" :message="form.errors.name"/>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="email" value="Email" />
                            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="username" />
                            <BreezeInputErros for="email" :message="form.errors.email"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Salvar
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeInputError from "@/Components/InputError.vue";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Link, Head } from '@inertiajs/inertia-vue3'

export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    BreezeInputError,
    Link,
    Head,
  },
  props: {
    user: Object,
    errors: Object
  },
  created() {
    console.log("user", this.$props.user);
    this.form.id = this.$props.user.id
    this.form.name = this.$props.user.name
    this.form.email = this.$props.user.email
  },
  data(){
    return{
        form: this.$inertia.form({
            id: '',
            name: '',
            email: '',
        }),
    }
  },
  methods: {
      submit() {
            this.form.put(this.route('users.update', this.form), {
                onFinish: (res) => {console.log("Res Edit: ", res)},
            })
        }
  }
}
</script>