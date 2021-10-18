<template>
  <Head title="Expenditures" />
  <BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Despesas
        </h2>
        <div class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-end">
            <Link :href="$props.create_url" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                + Despesa
            </Link>
        </div>
    </template>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="search-wrapper">
                        <input type="text" v-model="search" placeholder="Pesquisa por usário"/>
                    </div>
                    <table class="table mb-5">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Data</th>
                            <th scope="col">Usuário</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr v-for="expenditure in resultQuery" :key="expenditure.id" >
                                <th scope="row">{{ expenditure.id }}</th>
                                <td>
                                    {{ expenditure.description }}
                                </td>
                                <td>{{formattedDate(expenditure.date)}}</td>
                                <td>{{expenditure.user.name}}</td>
                                <td>R$ {{expenditure.amount}}</td>
                                <td>
                                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                                        <div class="ml-3 relative">
                                            <BreezeDropdown align="left" width="48">
                                                <template #trigger>
                                                    <span class="inline-flex rounded-md">
                                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                            Ações

                                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </template>
                                                <template #content>
                                                    <BreezeDropdownLink :href="route('expenditures.show', expenditure.id)" method="get" as="button">
                                                        Ver
                                                    </BreezeDropdownLink>
                                                    <BreezeDropdownLink :href="expenditure.edit_url" method="get" as="button">
                                                        Editar
                                                    </BreezeDropdownLink>
                                                    <BreezeDropdownLink @click="deleteExpenditure(expenditure.id)" method="delete" as="button">
                                                        Apagar
                                                    </BreezeDropdownLink>
                                                </template>
                                            </BreezeDropdown>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <!-- <tbody v-else>
                            <tr>
                                Não há registros!!
                            </tr>
                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeButton from "@/Components/Button.vue";
import { Link, Head } from '@inertiajs/inertia-vue3';
import moment from "moment";
moment.locale('pt-br')
export default {
  components: {
    BreezeDropdownLink,
    BreezeDropdown,
    BreezeAuthenticatedLayout,
    BreezeButton,
    Link,
    Head,
  },
  props: {
    expenditures: Array,
    create_url: String
  },
  created() {
      console.log("Created: ", this.$props.expenditures);
      this.expen = this.$props.expenditures;
  },
  data(){
    return{
        search: '',
        expen: ''
    }
  },
  computed: {
    resultQuery(){
      if(this.search){
        return this.$props.expenditures.filter((item)=>{
            return this.search.toLowerCase().split(' ').every(v => item.user.name.toLowerCase().includes(v))
        })
      }else{
        return this.$props.expenditures;
      }
    }
  },
  methods: {
    /**
     * Delete selected expenditure
     * @author Diogo C. Coutinho
     * @param Integer id
     */
    deleteExpenditure(id) {
        if (confirm('Quer mesmo deletar este usuário?')) {
            this.$inertia.delete(`expenditures/${id}`)
        }
    },
    formattedDate(date) {
        return moment(date).format('lll');
    },
  }
}
</script>