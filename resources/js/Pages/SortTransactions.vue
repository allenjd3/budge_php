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
                        <div v-for="transaction in transactions" :key="transaction.id">
                            <transaction-category-component :name="transaction.name" :spent="transaction.spent" :spent_date="transaction.spent_date" :items="items" :monthId="month.id" :transactionId="transaction.id" v-on:removeTransaction="removeTransaction(transaction.id)"></transaction-category-component>
                        </div>
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
    methods : {
        removeTransaction(id) {
            this.$delete(this.transactions, id )
        }
    },
};
</script>
