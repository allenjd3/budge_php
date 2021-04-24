<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Transaction for {{month.month}} {{month.year}}
            </h2>
        </template>
        <div class="relative">
            <div class="pt-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-8">

                        <form @submit.prevent="newTransaction">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:mr-4">
                                    <label for="date">Date</label>
                                    <div>
                                        <input id="date" type="date" v-model="transactionForm.spent_date" class="w-full md:w-64 border p-2 h-10" />
                                    </div>
                                    <div v-if="errors.spent_date" v-text="errors.spent_date" class="text-md text-red-400 font-bold"></div>
                                </div>
                                <div class="mt-2 md:mt-0 md:ml-4">
                                    <div>
                                        <label for="budget_item">Budget Item</label>
                                    </div>
                                    <div class="inline-block relative w-full md:w-64 md:mr-2 z-40">
                                        <v-select id="budget_item" label="name" :options="items" :reduce="name => name.id" v-model="transactionForm.item_id"></v-select>
                                    </div>
                                    <div v-if="errors.item_id" v-text="errors.item_id" class="text-md text-red-400 font-bold"></div>
                                </div>
                            </div>
                            <div class="flex flex-col md:flex-row">
                                <div class="my-2 md:mr-2 w-full md:w-1/2">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" v-model="transactionForm.name" class="w-full border p-2" />
                                    <div v-if="errors.name" v-text="errors.name" class="text-md text-red-400 font-bold"></div>
                                </div>
                                <div class="my-2 md:ml-2 w-full md:w-1/2">
                                    <label for="spent">Spent</label>
                                    <input id="spent" type="number" step="0.01" v-model="transactionForm.spent" class="w-full border p-2" />
                                    <div v-if="errors.spent" v-text="errors.spent" class="text-md text-red-400 font-bold"></div>
                                </div>
                            </div>
                            <div class="my-2">
                                <button
                                    type="submit"
                                    class="bg-indigo-500 text-white font-bold h-10 w-full md:w-64 rounded-lg hover:bg-indigo-600"
                                    >
                                    {{buttonMsg}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="pt-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Filter Transactions 
                        </h2>
                        <div class="my-2">
                            <div class="inline-block relative w-full md:w-64 md:mr-2 z-40">
                                <form @submit.prevent="filterTransactions">
                                    <v-select label="name" :options="items" :reduce="name => name.name" v-model="filterTransaction.name"></v-select>
                                    <div class="my-2">
                                        <button
                                            type="submit"
                                            class="bg-indigo-500 text-white font-bold h-10 w-full md:w-64 rounded-lg hover:bg-indigo-600"
                                            >
                                            Filter Transactions
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <template v-if="filter">
                            <item-filter-component :name=" ( transactions.data[0] ).item.name" :planned="( transactions.data[0] ).item.planned" :spent="( transactions.data[0] ).item.remaining" @toggleModal="createModifyItem(( transactions.data[0] ).item)"/>
                        </template>
                        <a :href="`/month/${month.id}/transactions/import`" class="inline-block flex justify-center items-center bg-indigo-500 text-white font-bold h-10 w-full md:w-64 rounded-lg hover:bg-indigo-600">Import CSV transactions</a>
                    </div>
                </div>
            </div>
            <div id="transactions" class="pt-12 pb-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-scroll md:overflow-hidden shadow-xl sm:rounded-lg p-8">
                        <div v-if="$page.props.message" class="text-red-600">{{$page.props.message}} <a @click="clearFilter" class="ml-4 border p-2 cursor-pointer text-gray-900">Clear Filter</a></div>
                        <div v-if="filter" class="my-2">
                            <span class="text-xl" v-text="'Filtering by: ' + filter"> </span>  <a @click="clearFilter" class="ml-4 border p-2 cursor-pointer">Clear Filter</a>
                        </div>
                        <span>Page <span v-text="transactions.current_page"></span> of <span v-text="transactions.last_page"></span></span>
                        <table class="table-fixed md:w-full">
                            <tr>
                                <th class="border w-1/2 p-2">Name</th>
                                <th class="border p-2">Spent</th>
                                <th class="border p-2">Category</th>
                                <th class="border p-2">Date</th>
                                <th class="border p-2">Delete</th>
                            </tr>
                            <tr v-for="transaction in transactions.data" :key="transaction.id">
                                <td class="border p-2 font-bold cursor-pointer" @click.prevent="transactionEdit(transaction)">{{transaction.name}}</td>
                                <td class="border p-2 font-bold">{{formattedSpent(transaction.spent)}}</td>
                                <td class="border p-2 font-bold">{{transaction.item.name}}</td>
                                <td class="border p-2 font-bold">{{( new Date(transaction.spent_date) ).toLocaleString().split(',')[0]}}</td>
                                <td class="border p-2 font-bold"><a href="" @click.prevent="deleteTransaction(transaction.id)" class="font-bold text-red-400">Delete</a></td>
                            </tr>
                        </table>
                        <div class="flex mt-8">
                            <a class="block border py-2 px-4 font-bold" v-bind:href="transactions.first_page_url">First</a>
                            <a class="block border-t border-b py-2 px-4 font-bold" v-bind:class="transactions.current_page == 1 ? 'text-gray-400 cursor-not-allowed' : 'text-black'" v-bind:href="transactions.prev_page_url">Previous</a>
                            <a class="block border-l border-t border-b py-2 px-4 font-bold" v-bind:href="transactions.next_page_url">Next</a>
                            <a class="block border py-2 px-4 font-bold" v-bind:href="transactions.last_page_url">Last</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "./../Layouts/AppLayout";
import {Inertia} from "@inertiajs/inertia";
import 'vue-select/dist/vue-select.css';
import ItemFilterComponent from "./../Components/ItemFilterComponent";
export default {
    components: {
        AppLayout,
        ItemFilterComponent
    },
    props: { 
        month : Object, 
        items : Array, 
        transactions: Object, 
        errors : Object,
        filter : String,
        userId : Number,
    },
    data() {
        return {
            filterTransaction: {
                name: null
            },
            transactionForm : {
                spent_date: null,
                item_id: null,
                month_id: this.month.id,
                spent: null,
                name: null
            },
            transaction_id : null,
            themessage : {
                message: "",
                open: false
            },

            buttonMsg : "New Transaction",
        }

    },
    methods : {
        newTransaction() {
            if(this.transaction_id){
                Inertia.put('/transactions/'+this.transaction_id, this.transactionForm, {
                    preserveScroll : true, 
                    preserveState : true,
                    onSuccess: () => {
                        this.transactionForm.spent = null;
                        this.transactionForm.name = null;
                        this.transactionForm.spent_date = null;
                        this.transactionForm.item_id = null;
                        this.transactionForm.month_id = null;
                        this.transaction_id = null;
                        this.buttonMsg = "New Transaction";

                    }
                })

            }else {
                Inertia.post('/transactions', this.transactionForm, {
                    preserveState : true, 
                    preserveScroll : true,
                    onSuccess: () => {
                        this.transactionForm.spent = null;
                        this.transactionForm.name = null;

                    }
                });
            }



        },
        filterTransactions() {
            Inertia.visit('/create-transaction/'+ this.month.id + "?filter=" + this.filterTransaction.name, {method: 'get', preserveScroll: 'true'});
        },
        clearFilter(){
            Inertia.visit('/create-transaction/' + this.month.id, {method: 'get', preserveScroll: 'true'});
        },
        formattedSpent(spent) {
            return (spent/100).toFixed(2);

        },
        transactionEdit(transaction) {
            this.transactionForm.spent_date = transaction.spent_date;
            this.transactionForm.item_id = transaction.item_id;
            this.transactionForm.month_id = transaction.month_id;
            this.transactionForm.spent = ( transaction.spent/100 ).toFixed(2);
            this.transactionForm.name = transaction.name;
            this.transaction_id = transaction.id;
            this.buttonMsg = "Edit Transaction";


        },
        deleteTransaction(id) {
            Inertia.delete('/transactions/'+id, {preserveScroll : true, preserveState : true});
        }

    },


};
</script>
