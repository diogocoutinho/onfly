<template>
  <Head title="Expenditures" />
  <BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Despesas
        </h2>
        <div class="flex items-center justify-end">
            <Link class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150" :href="route('expenditures.index')">
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
                            <BreezeLabel for="description" value="Descrição" />
                            <textarea id="description" class="mt-1 block w-full" maxlength="191" v-model="form.description" required autofocus autocomplete="description" ></textarea>
                        </div>

                        <div class="row">
                            <div class="col-4 mt-4">
                                <BreezeLabel for="datetime-local" value="Data" />
                                <BreezeInput id="datetime-local" type="datetime-local" class="mt-1 block w-full" v-model="form.date" required autocomplete="datetime" />
                            </div>
                            <div class="col-4 mt-4">
                                <BreezeLabel for="user" value="Usuário" />
                                <select class="mt-1 block w-full" id="user" v-model="form.user_id">
                                    <option v-for="user in users" v-bind:value="user.id" v-bind:key="user.id">
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-4 mt-4">
                                <BreezeLabel for="amount" value="Valor" />
                                <money3 class="mt-1 block w-full" v-model="form.amount" v-bind="money"></money3>
                            </div>
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
import { Money3Component } from 'v-money3'
import moment from "moment";

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
    money3: Money3Component
  },
  props: {
    expenditure: Object,
    users: Object,
    errors: Object
  },
  created() {
     console.log("expenditure", this.$props.expenditure);
    this.form.id = this.$props.expenditure.id
    this.form.description = this.$props.expenditure.description
    this.form.date = moment(this.$props.expenditure.date).format('YYYY-MM-DDThh:mm')
    this.form.user_id = this.$props.expenditure.user_id
    this.form.amount = this.$props.expenditure.amount
     console.log("form", this.form);

  },
  data(){
    return{
        form: this.$inertia.form({
            id: '',
            description: '',
            date: '',
            user_id: '',
            amount: ''
        }),
        money: {
            decimal: ',',
            thousands: '.',
            prefix: 'R$ ',
            suffix: '',
            precision: 2,
            masked: false, /* doesn't work with directive */
            disableNegative: false,
            disabled: false,
            min: null,
            max: null,
            allowBlank: false,
            minimumNumberOfCharacters: 0,
        },
    }
  },
  methods: {
      submit() {
            this.form.put(this.route('expenditures.update', this.form), {
                onFinish: (res) => {console.log("Res Edit: ", res)},
            })
        }
  }
}
</script>