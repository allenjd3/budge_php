<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <h2 class="text-2xl m-4">Food</h2>
          <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
            <div class="flex-1 ml-4">
              <a href=""> First Item </a>
            </div>
            <div class="w-32 font-bold text-blue-600">$100.00</div>
            <div class="w-32 font-bold text-green-600">$120.00</div>
          </div>
          <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
            <div class="flex-1 ml-4">First Item</div>
            <div class="w-32 font-bold text-blue-600">$100.00</div>
            <div class="w-32 font-bold text-green-600">$120.00</div>
          </div>
          <div class="flex h-16 items-center shadow bg-gray-100 mx-8 my-4">
            <div class="flex-1 ml-4">First Item</div>
            <div class="w-32 font-bold text-blue-600">$100.00</div>
            <div class="w-32 font-bold text-red-600">$80.00</div>
          </div>
          <item-component name="My First Thing" planned="200.00" spent="34.00"/>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import ItemComponent from "./../Components/ItemComponent"

export default {
  components: {
    AppLayout,
    ItemComponent
  },
};
</script>
