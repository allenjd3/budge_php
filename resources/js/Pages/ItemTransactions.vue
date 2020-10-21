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
            <div class="flex">
              <div class="mr-4">
                <label>Date</label>
                <div>
                  <input type="date" v-model="transactionForm.spent_date" class="w-64 border p-2 h-10" />
                </div>
              </div>
              <div class="ml-4">
                <div>
                  <label>Budget Item</label>
                </div>
                <div class="inline-block relative w-32 mr-2">
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
              </div>
            </div>
            <div class="flex">
              <div class="my-2 mr-2 w-1/2">
                <label>Name</label>
                <input type="text" v-model="transactionForm.name" class="w-full border p-2" />
              </div>
              <div class="my-2 ml-2 w-1/2">
                <label>Spent</label>
                <input type="number" step="0.01" v-model="transactionForm.spent" class="w-full border p-2" />
              </div>
            </div>
            <div class="my-2">
              <button
                type="submit"
                class="bg-indigo-400 text-white font-bold h-10 w-64 rounded-lg hover:bg-indigo-600"
              >
                New Transaction
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="pt-12 mb-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <table class="table-fixed w-full">
            <tr>
              <th class="border w-1/2 p-2">Name</th>
              <th class="border p-2">Spent</th>
              <th class="border p-2">Category</th>
              <th class="border p-2">Date</th>
            </tr>
            <tr v-for="transaction in transactions" :key="transaction.id">
                <td class="border p-2 font-bold">{{transaction.name}}</td>
                <td class="border p-2 font-bold">{{formattedSpent(transaction.spent)}}</td>
                <td class="border p-2 font-bold">{{transaction.item.name}}</td>
                <td class="border p-2 font-bold">{{transaction.spent_date}}</td>
            </tr>
          </table>
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
  props: ['month', 'items', 'transactions'],
    data() {
        return {
            transactionForm : {
                spent_date: null,
                item_id: null,
                month_id: this.month.id,
                spent: null,
                name: null
            }
        
        }
    },
    methods : {
        newTransaction() {
            Inertia.post('/transactions', {'transaction':this.transactionForm}).then(()=>{
                this.transactionForm.spent = null;
                this.transactionForm.name = null;
            
            });

            
        
        },
        formattedSpent(spent) {
          return (spent/100).toFixed(2);

        }

    },


};
</script>
