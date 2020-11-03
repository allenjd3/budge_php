<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Create Month
      </h2>
    </template>
    <div class="pt-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
          <h1 class="text-2xl">Create New</h1>
          <form @submit.prevent="submitMonth">
            <div class="inline-block relative w-32 ml-4 mr-2 my-4">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                v-model="month"
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
            <div class="inline-block relative w-32 mr-2 my-4">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                v-model="year"
              >
                <option></option>
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option>2023</option>
                <option>2024</option>
                <option>2025</option>
                <option>2026</option>
                <option>2027</option>
                <option>2028</option>
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
            <div class="my-2">
                <label class="font-bold">Copy Categories and Items from:</label>
            </div>
            <template v-if="months === undefined || months == 0">
            </template>
            <template v-else>
            <div class="inline-block relative w-32 mr-2 my-4">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                v-model="copymonth"
              >
                <option v-for="m in months" :key="m.id" :value="m.id">{{m.month}} {{m.year}}</option>
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
            </template>

            <div class="my-4">
              <button
                type="submit"
                class="p-4 bg-gray-900 text-gray-100 font-bold"
              >
                Create New Month
              </button>
            </div>
          </form>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 my-8">
          <h2 class="text-xl">Most Recent Months</h2>
          <table class="table-fixed w-full">
            <tr>
              <th class="w-3/4 border p-2">Month/Year</th>
              <th class="border p-2">Delete</th>
            </tr>
            <tr v-for="month in months" :key="month.id">
              <td class="border p-2">{{month.month}} {{month.year}}</td>
              <td class="border p-2">Delete</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import AppLayout from './../Layouts/AppLayout'
import {Inertia} from '@inertiajs/inertia'
export default {
    props: ['months'],
    components : {
        AppLayout
    },
    data() {
        return {
                month : null,
                year : null,
                copymonth : null
            }
    },
    methods : {
        submitMonth() {
            Inertia.post('/months', {'month':this.month, 'year': this.year, 'copymonth' : this.copymonth})
        }
    }

    
}
</script>
