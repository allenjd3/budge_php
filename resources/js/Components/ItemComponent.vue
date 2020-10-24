<template>
  <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
    <div class="flex-1 ml-4">
      <a href="" @click.prevent="$emit('toggleModal')">{{name}}</a>
    </div>
    <div class="w-32 font-bold text-blue-600">${{formattedPlanned}}</div>
    <div class="w-32 font-bold text-green-600">${{formattedSpent}}</div>
  </div>
</template>
<script>
export default {
    props : ['planned', 'spent', 'name'],
    computed : {
      formattedPlanned : {
        get() {
          return (this.planned /100).toFixed(2);
        }
      },
      formattedSpent : {
        get() {
          return (this.spent /100).toFixed(2);
        }
      },

    },


};
</script>
