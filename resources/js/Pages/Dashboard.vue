<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>
    <div class="pt-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <h1 class="text-3xl m-4">Budget for October 2020</h1>
          <div>
              <div class="inline-block relative w-64 ml-4">
                  <select class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline">
                      <option>Really long option that will likely overlap the chevron</option>
                      <option>Option 2</option>
                      <option>Option 3</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                      <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                  </div>
              </div>
          </div>
          <h2 class="text-2xl m-4">Paychecks</h2>
          <item-component name="First Paycheck" planned="2000.00" spent="34.00"/>
          <div class="flex justify-around my-8">
              <div class="mx-2 text-center pt-4 pb-8 bg-teal-100 w-64 rounded-lg">
                  <h3 class="text-lg">Total Planned</h3>
                  <p class="text-3xl">230.00</p>
              </div>
              <div class="mx-2 text-center pt-4 pb-8 bg-indigo-100 w-64 rounded-lg">
                  <h3 class="text-lg">Total Paid</h3>
                  <p class="text-3xl">230.00</p>
              </div>
              <div class="mx-2 text-center pt-4 pb-8 bg-purple-100 w-64 rounded-lg">
                  <h3 class="text-lg">Amount Left</h3>
                  <p class="text-3xl">230.00</p>
              </div>
          </div>

            
        </div>
      </div>
    </div>

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
