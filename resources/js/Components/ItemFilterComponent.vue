<template>
  <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
    <div class="w-40 md:flex-1 ml-4">
        <span>{{name}}</span>
    </div>
    <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-blue-600">${{getPlanned}}</div>
    
    <template v-if="spent >= 0">
      <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-green-600">${{getSpent}}</div>
    </template>
    <template v-if="spent < 0">
      <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-red-600">${{getSpent}}</div>
    </template>
  </div>
</template>
<script>
export default {
    props : ['planned', 'spent', 'name', 'monthId'],
    computed : {
        getPlanned() {
            return (this.planned / 100).toFixed(2);
        },
        getSpent(){
            return (this.spent / 100).toFixed(2);
        }
    },
    mounted() {

    }

};
</script>
