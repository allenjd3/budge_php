<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Transaction for {{month.month}} {{month.year}}
            </h2>
        </template>
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <form @submit.prevent="newTransaction">
                        <div class="flex flex-col md:flex-row">
                            <div class="md:mr-4">
                                <label>Date</label>
                                <div>
                                    <input type="date" v-model="transactionForm.spent_date" class="w-full md:w-64 border p-2 h-10" />
                                </div>
                                <div v-if="errors.spent_date" v-text="errors.spent_date" class="text-md text-red-400 font-bold"></div>
                            </div>
                            <div class="mt-2 md:mt-0 md:ml-4">
                                <div>
                                    <label>Budget Item</label>
                                </div>
                                <div class="inline-block relative w-full md:w-32 md:mr-2">
                                    <select
                                        class="block appearance-none p-2 w-full bg-white border border-gray-300 hover:border-gray-500 leading-tight focus:outline-none focus:shadow-outline h-10"
                                        v-model="transactionForm.item_id"
                                        >
                                        <option v-for="item in items" :key="item.id" :value="item.id">{{item.name}}</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                                        >
                                        <svg
                                            class="fill-current h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            >
                                            <path
                                                d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                                />
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="errors.item_id" v-text="errors.item_id" class="text-md text-red-400 font-bold"></div>
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row">
                            <div class="my-2 md:mr-2 w-full md:w-1/2">
                                <label>Name</label>
                                <input type="text" v-model="transactionForm.name" class="w-full border p-2" />
                                <div v-if="errors.name" v-text="errors.name" class="text-md text-red-400 font-bold"></div>
                            </div>
                            <div class="my-2 md:ml-2 w-full md:w-1/2">
                                <label>Spent</label>
                                <input type="number" step="0.01" v-model="transactionForm.spent" class="w-full border p-2" />
                                <div v-if="errors.spent" v-text="errors.spent" class="text-md text-red-400 font-bold"></div>
                            </div>
                        </div>
                        <div class="my-2">
                            <button
                                type="submit"
                                class="bg-indigo-400 text-white font-bold h-10 w-full md:w-64 rounded-lg hover:bg-indigo-600"
                                >
                                {{buttonMsg}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="pt-12 mb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-scroll md:overflow-hidden shadow-xl sm:rounded-lg p-8">
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
                            <td class="border p-2 font-bold">{{transaction.spent_date}}</td>
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
    </app-layout>
</template>
<script>
import AppLayout from "./../Layouts/AppLayout";
import {Inertia} from "@inertiajs/inertia";
export default {
    components: {
        AppLayout,
    },
    props: { 
        month : Object, 
        items : Array, 
        transactions: Object, 
        errors : Object 
        },
    data() {
        return {
            transactionForm : {
                spent_date: null,
                item_id: null,
                month_id: this.month.id,
                spent: null,
                name: null
            },
            transaction_id : null,
            buttonMsg : "New Transaction"

        }

    },
    methods : {
        newTransaction() {
            if(this.transaction_id){
                Inertia.put('/transactions/'+this.transaction_id, this.transactionForm, {preserveScroll : true, preserveState : true}).then(()=>{
                    this.transactionForm.spent = null;
                    this.transactionForm.name = null;
                    this.transactionForm.spent_date = null;
                    this.transactionForm.item_id = null;
                    this.transactionForm.month_id = null;
                    this.transaction_id = null;
                    this.buttonMsg = "New Transaction";

                });

            }else {
                Inertia.post('/transactions', this.transactionForm, {preserveState : true, preserveScroll : true}).then(()=>{
                    this.transactionForm.spent = null;
                    this.transactionForm.name = null;

                });
            }



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
