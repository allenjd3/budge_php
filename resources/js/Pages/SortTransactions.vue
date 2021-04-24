<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sort Imported Transactions
            </h2>
        </template>
        <div class="relative">
            <div class="pt-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg py-8 px-2">
                        <template v-if="transactions.length > 0">
                            <div  v-for="transaction in transactions" :key="transaction.id">
                                <transaction-category-component :name="transaction.name" :spent="transaction.spent" :spent_date="transaction.spent_date" :items="items" :monthId="month.id" :transactionId="transaction.id" v-on:removeTransaction="removeTransaction(transaction.id)"></transaction-category-component>
                            </div>
                        </template>
                        <template v-else>
                            <div class="text-xl m-4">
                                No current Transactions
                            </div>
                            <div class="flex items-center">
                                <inertia-link :href="`/dashboard/${month.id}`" class="block px-4 py-2 bg-gray-800 text-gray-100 mx-2">Dashboard</inertia-link><inertia-link :href="`/create-transaction/${month.id}`" class="px-4 py-2 block bg-gray-800 text-gray-100 mx-2">View Transactions</inertia-link>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "./../Layouts/AppLayout";
import TransactionCategoryComponent from '../Components/TransactionCategoryComponent'
export default {
    components : {
        AppLayout,
        TransactionCategoryComponent
    },
    data() {
        return {
        }

    },
    props : ['transactions', 'items', 'month'],
    mounted(){
        console.log(this.transactions.length)
    },
    methods : {
        removeTransaction(id) {
            this.$delete(this.transactions, id )
        }
    },
};
</script>
