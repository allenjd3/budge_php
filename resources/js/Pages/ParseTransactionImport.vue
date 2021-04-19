<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Parse Imported Transactions
            </h2>
        </template>
        <div class="relative">
            <div class="pt-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-8">
                        <div v-for="csv in csvArray" v-bind:key="csv.name">
                            <transaction-component :name="csv.name" :spent="csv.spent" :spent_date="csv.date" :itemFirst="itemFirst"></transaction-component>
                        </div>
                        <div class="flex w-full justify-start border-t h-16 items-center">
                            <a :href="`/month/${monthId}/transactions/import/${csvimport}/confirm`" class="px-4 py-2 border rounded bg-gray-800 text-gray-100">Import Transactions?</a>
                            <a :href="`/month/${monthId}/transactions/import`" class="px-4 py-2 border rounded ml-8">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import TransactionComponent from '../Components/TransactionComponent.vue';
import AppLayout from "./../Layouts/AppLayout";
export default {
    components : {
        AppLayout,
        TransactionComponent
    },
    data() {
        return {
        }
    },
    props : ['csvArray', 'monthId', 'csvimport', 'itemFirst'],
    methods : {

    },
};
</script>