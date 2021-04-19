<template>
  <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
    <div class="w-40 md:flex-1 ml-4">
      <a href="">{{name}}</a>
    </div>
    <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-red-600">${{spent}}</div>
    <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-blue-600">{{spent_date}}</div>
    <div class="w-16 md:w-32 text-sm sm:text-base font-bold text-gray-800">{{itemFirst}}</div>
  </div>
</template>
<script>
export default {
    props : ['name', 'spent', 'spent_date', 'itemFirst'],
    computed : {
    }

};
</script>
