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
          <div class="flex items-center">
            <div class="inline-block relative w-32 ml-4 mr-2">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
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
            <div class="mr-4">Month</div>
            <div class="inline-block relative w-32 mr-2">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
              >
                <option></option>
                <option>2018</option>
                <option>2019</option>
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
            <div class="mr-4">Year</div>
            <button
              class="w-32 h-10 bg-indigo-400 text-white font-bold hover:bg-indigo-600 rounded-lg"
            >
              Go to Month
            </button>
          </div>
          <h2 class="text-2xl m-4">Paychecks</h2>
          <item-component
            name="First Paycheck"
            planned="2000.00"
            spent="34.00"
          />
          <div class="flex justify-around my-8">
            <div class="mx-2 text-center pt-4 pb-8 bg-teal-100 w-64 rounded-lg">
              <h3 class="text-lg">Total Planned</h3>
              <p class="text-3xl">230.00</p>
            </div>
            <div
              class="mx-2 text-center pt-4 pb-8 bg-indigo-100 w-64 rounded-lg"
            >
              <h3 class="text-lg">Total Paid</h3>
              <p class="text-3xl">230.00</p>
            </div>
            <div
              class="mx-2 text-center pt-4 pb-8 bg-purple-100 w-64 rounded-lg"
            >
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
          <item-component
            name="My First Thing"
            planned="200.00"
            spent="34.00"
          />
          <Modal ref="new-item" :show="showItemModal">
            <div class="p-8 relative">
              <div
                class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
                @click="closeItem"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-x"
                >
                  <line x1="18" y1="6" x2="6" y2="18"></line>
                  <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
              </div>
              <h1 class="text-2xl">Create New Item</h1>
              <form @submit.prevent="storeItem">
                <div class="my-2">
                  <label>Name</label>
                  <input
                    type="text"
                    class="w-full border p-2"
                    v-model="createItemForm.name"
                  />
                </div>
                <div class="my-2">
                  <div>
                    <label>Category</label>
                  </div>
                  <div class="inline-block relative w-64 mr-2">
                    <select
                      class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                      v-model="createItemForm.category"
                    >
                      <option>Food</option>
                      <option>Transportation</option>
                      <option>Music</option>
                      <option>Miscellaneous</option>
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
                <div class="my-2">
                  <input
                    type="checkbox"
                    class="border"
                    v-model="createItemForm.isFund"
                  />
                  <label>Fund?</label>
                </div>
                <div class="my-2">
                  <button
                    class="bg-indigo-400 text-white w-32 h-10 font-bold hover:bg-indigo-600"
                  >
                    Create New
                  </button>
                </div>
              </form>
            </div>
          </Modal>
          <button
            class="bg-gray-900 w-32 h-10 text-gray-100"
            @click="createItem"
          >
            Create Item
          </button>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import ItemComponent from "./../Components/ItemComponent";
import Modal from "./../Jetstream/Modal";
import {Inertia} from "@inertiajs/inertia";

export default {
  components: {
    AppLayout,
    ItemComponent,
    Modal,
  },
  data() {
    return {
      showItemModal: false,
      createItemForm: {
        name : null,
        category : null,
        isFund : null
      },
      item : ""
    };
  },
  methods: {
    createItem() {
      console.log('im working...')
      this.showItemModal = true;
    },
    storeItem() {
      Inertia.post("/items", {item : this.createItemForm})
      this.showItemModal = false;
    },
    closeItem() {
      this.showItemModal = false;
    }
  },
};
</script>
