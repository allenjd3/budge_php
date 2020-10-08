<template>
  <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
    <div class="flex-1 ml-4">
      <a href="">{{name}}</a>
    </div>
    <div class="w-32 font-bold text-blue-600">${{planned}}</div>
    <div class="w-32 font-bold text-green-600">${{spent}}</div>
  </div>
</template>
<script>
export default {
    props : ['planned', 'spent', 'name']

};
</script>