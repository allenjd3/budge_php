<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        New Transaction
      </h2>
    </template>
    <div class="pt-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <form>
            <div class="flex">
              <div class="mr-4">
                <label>Date</label>
                <div>
                  <input type="date" class="w-64 border p-2" />
                </div>
              </div>
              <div class="ml-4">
                <div>
                  <label>Category</label>
                </div>
                <div class="inline-block relative w-32 mr-2">
                  <select
                    class="block appearance-none p-2 w-full bg-white border border-gray-300 hover:border-gray-500 rounded leading-tight focus:outline-none focus:shadow-outline h-10"
                  >
                    <option></option>
                    <option>January</option>
                    <option>February</option>
                    <option>March</option>
                    <option>April</option>
                    <option>May</option>
                    <option>June</option>
                    <option>July</option>
                    <option>August</option>
                    <option>September</option>
                    <option>October</option>
                    <option>November</option>
                    <option>December</option>
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
                <input type="text" class="w-full border p-2" />
              </div>
              <div class="my-2 ml-2 w-1/2">
                <label>Spent</label>
                <input type="number" step="0.01" class="w-full border p-2" />
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
    <div class="pt-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <table class="table-fixed w-full">
            <tr>
              <th class="border w-1/2 p-2">Name</th>
              <th class="border p-2">Spent</th>
              <th class="border p-2">Category</th>
              <th class="border p-2">Date</th>
            </tr>
            <tr>
              <td class="border p-2 font-bold">My amazing first Transaction</td>
              <td class="border p-2 font-bold">23.34</td>
              <td class="border p-2 font-bold">Restaurants</td>
              <td class="border p-2 font-bold">02-23-2020</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from "./../Layouts/AppLayout";
export default {
  components: {
    AppLayout,
  },
};
</script>