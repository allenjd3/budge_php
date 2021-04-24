<template>
  <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
    <div class="w-40 md:flex-1 ml-4">
      <a href="">{{name}}</a>
    </div>
    <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-red-600">${{spentMoney}}</div>
    <div class="w-16 w-32 md:w-32 hidden sm:inline-block text-sm sm:text-base font-bold text-blue-600">{{( new Date( spent_date ) ).toLocaleString().split(',')[0]}}</div>
    <div class="w-16 w-32 md:w-64 text-sm sm:text-base font-bold text-gray-800">
        <v-select label="name" @input="submitSort" :options="items" :reduce="name => name.name" v-model="sortTransaction.name" class="bg-white mx-4"></v-select>
    </div>
  </div>
</template>
<script>
import 'vue-select/dist/vue-select.css';
import {Inertia} from "@inertiajs/inertia";

export default {

    data() {
      return {
        sortTransaction : {
          name : '',
          transaction_id : this.transactionId,
          month_id : this.monthId
        }
      }

    },
    props : ['name', 'spent', 'spent_date', 'items', 'monthId', 'transactionId'],
    methods : {
      submitSort() {
        Inertia.put(`/month/${this.monthId}/transactions/sort`, this.sortTransaction, {
          onSuccess: () => {
            console.log('success')
            this.$emit( 'removeTransaction' )
            this.sortTransaction.name = null;
            this.sortTransaction.transaction_id = null;
          },
          onError: (errors) => {
            console.error('error');
            console.log(errors)
          }
        })

      }
    },
    computed : {
      spentMoney() {
        return ( this.spent / 100 ).toFixed(2)
      }
    }

};
</script>