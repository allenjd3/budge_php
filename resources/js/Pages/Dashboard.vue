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
          <h1 class="text-3xl m-4">Budget for {{month.month}} {{month.year}}</h1>
          <div class="flex flex-wrap items-center px-2 md:p-0">
            <div class="md:mr-4 mt-2 md:ml-4">Month</div>
            <div class="inline-block relative w-full md:w-32 mr-2">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                v-model="goTo.month"
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
            <div class="md:mr-4 mt-4">Year</div>
            <div class="inline-block relative w-full md:w-32 mr-2">
              <select
                class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                v-model="goTo.year"
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
            <button
              class="mt-2 md:mt-0 w-32 h-10 bg-indigo-400 text-white font-bold hover:bg-indigo-600 rounded-lg"
              @click.prevent="goToMonth"
              >
              Go to Month
            </button>
          </div>
          <div class="bg-indigo-100 py-4 my-8">
            <div class="ml-4">
              <form @submit.prevent="storeMonthlyPlanned">
                <label class="font-bold">Planned Income</label>
                <div class="inline-block">
                  <input type="number" step="0.01" v-model="monthly_planned" class="w-64 p-2 border rounded" />
                </div>
                <div class="inline-block mt-2 md:mt-0">
                  <button type="submit" class=" p-2 bg-indigo-400 text-white font-bold rounded-lg hover:bg-indigo-600">Add Planned Income</button>
                </div>
              </form>
            </div>
          </div>
          <h2 class="text-2xl m-4">Paychecks</h2>
          <paycheck-component v-for="paycheck in month.paychecks" :name="paycheck.name" :spent="paycheck.payday" :key="paycheck.id" @togglePaycheckModal="createModifyPaycheck(paycheck)"/>
            <div class="ml-4">
              <button
                class="font-bold bg-indigo-400 w-40 h-10 rounded-lg hover:bg-indigo-600 text-gray-100"
                @click="createPaycheck"
                >
                Create Paycheck
              </button>
            </div>
            <div class="flex justify-around my-8 flex-wrap md:flex-no-wrap">
              <div class="mx-2 text-center pt-4 pb-8 bg-teal-100 w-full mb-4 md:mb-0 md:w-1/3 rounded-lg">
                <h3 class="text-lg">Total Planned</h3>
                <p class="text-3xl">{{monthlyPlanned}}</p>
                <h3 class="text-lg">Total Planned Remaining</h3>
                <p class="text-3xl">{{monthlyLeft}}</p>
              </div>
              <div
                class="mx-2 text-center pt-4 pb-8 bg-indigo-100 w-full md:w-1/3 rounded-lg"
                >
                <h3 class="text-lg">Total Paid</h3>
                <p class="text-3xl">{{payAmount}}</p>
                <h3 class="text-lg">Amount Left</h3>
                <p class="text-3xl">{{amountLeft}}</p>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="py-12" v-for="c in month.categories" :key="c.id">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl m-4 cursor-pointer" @click.prevent="createModifyCategory(c)">{{c.name}}</h2>
            <a href="" class="mr-8" @click.prevent="createItemWithCategory(c.id)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a>
          </div>
          <template v-if="c.items">
            <item-component v-for="item in c.items" :key="item.id" :name="item.name" :planned="item.planned" :spent="item.remaining" @toggleModal="createModifyItem(item)"/>
          </template>
        </div>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
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
                <input type="text" class="w-full border p-2" v-model="createItemForm.name"/>
                <div v-if="errors.name" v-text="errors.name" class="text-md text-red-400 font-bold"></div>
              </div>
              <div class="my-2">
                <label>Planned</label>
                <input type="number" step="0.01" class="w-full border p-2" v-model="createItemForm.planned"/>
                <div v-if="errors.planned" v-text="errors.planned" class="text-md text-red-400 font-bold"></div>
              </div>
              <div class="my-2">
                <div>
                  <label>Category</label>
                </div>
                <div class="inline-block relative w-64 mr-2">
                  <select
                    class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                    v-model="createItemForm.category_id" 
                    >
                    <option v-for="c in month.categories" :key="c.id" :value="c.id">{{c.name}}</option>
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
                <div v-if="errors.category_id" v-text="errors.category_id" class="text-md text-red-400 font-bold"></div>
              </div>
              <div class="my-2">
                <input
                  type="checkbox"
                  class="border"
                  v-model="createItemForm.is_fund"
                  />
                <label>Fund?</label>
              </div>
              <div class="my-2">
                <button type="submit"
                        class="bg-indigo-400 text-white w-32 h-10 font-bold hover:bg-indigo-600"
                        >
                        Create New
                </button>
              </div>
            </form>
          </div>
          </Modal>
          <Modal ref="update-item" :show="showModifyItemModal">
          <div class="p-8 relative">
            <div
              class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
              @click="closeModifyItem"
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
            <h1 class="text-2xl">Update Item</h1>
            <form @submit.prevent="updateItem">
              <div class="my-2">
                <label>Name</label>
                <input type="text" class="w-full border p-2" v-model="createItemForm.name"/>
              </div>
              <div class="my-2">
                <label>Planned</label>
                <input type="number" step="0.01" class="w-full border p-2" v-model="createItemForm.planned"/>
              </div>
              <div class="my-2">
                <div>
                  <label>Category</label>
                </div>
                <div class="inline-block relative w-64 mr-2">
                  <select
                    class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
                    v-model="createItemForm.category_id" 
                    >
                    <option v-for="c in month.categories" :key="c.id" :value="c.id">{{c.name}}</option>
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
                  v-model="createItemForm.is_fund"
                  />
                <label>Fund?</label>
              </div>
              <div class="flex justify-between">
                <div class="my-2">
                  <button type="submit"
                          class="bg-indigo-400 text-white w-32 h-10 font-bold hover:bg-indigo-600"
                          >
                          Update
                  </button>
                </div>
                <div class="my-2">
                  <a href="" @click.prevent="deleteItem(itemFormId)" class="flex justify-center items-center block border border-gray-800 text-black w-32 h-10 font-bold hover:bg-gray-800 hover:text-white">Delete</a>
                </div>
              </div>
            </form>
          </div>
          </Modal>
          <Modal ref="new-category" :show="showCategoryModal">
          <div class="p-2 md:p-8 relative">
            <div
              class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
              @click="closeCategory"
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
            <div class="p-8">
              <h1 class="text-2xl">Create New Category</h1>
              <form @submit.prevent="storeCategory">
                <div class="my-2">
                  <label class="font-bold">Name: </label>
                  <input type="text" v-model="createCategoryForm.name" class="p-2 border w-full"/>
                  <div v-if="errors.name" v-text="errors.name" class="text-md text-red-400 font-bold"></div>
                </div>
                <div class="my-2">
                  <button class="bg-indigo-400 text-white w-full md:w-64 h-10 font-bold hover:bg-indigo-600">Create Category</button>
                </div>
              </form>
            </div>
          </div>
          </Modal>
          <Modal ref="new-edit-category" :show="showModifyCategoryModal">
          <div class="p-2 md:p-8 relative">
            <div
              class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
              @click="closeModifyCategory"
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
            <div class="p-8">
              <h1 class="text-2xl">Edit Category</h1>
              <form @submit.prevent="updateCategory">
                <div class="my-2">
                  <label class="font-bold">Name: </label>
                  <input type="text" v-model="createCategoryForm.name" class="p-2 border w-full"/>
                </div>
                <div class="flex flex-col md:flex-row justify-between">
                  <div class="">
                    <button class="bg-indigo-400 text-white w-full md:w-64 h-10 font-bold hover:bg-indigo-600">Update Category</button>
                  </div>
                  <div class="">
                    <a @click.prevent="deleteCategory(categoryFormId)" class="border border-gray-800 text-black w-full mt-2 md:mt-0 md:w-64 h-10 font-bold hover:bg-gray-800 hover:text-white block flex justify-center items-center">Delete Category</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          </Modal>
          <Modal ref="new-paycheck" :show="showPaycheckModal">
          <div class="p-8 relative">
            <div
              class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
              @click="closePaycheck"
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
            <div class="p-8">
              <h1 class="text-2xl">Create New Paycheck</h1>
              <form @submit.prevent="storePaycheck">
                <div class="my-2">
                  <label class="font-bold">Name: </label>
                  <input type="text" v-model="createPaycheckForm.name" class="p-2 border w-full"/>
                  <div v-if="errors.name" v-text="errors.name" class="text-md text-red-400 font-bold"></div>
                </div>
                <div class="my-2">
                  <label class="font-bold">Pay Date: </label>
                  <input type="date" v-model="createPaycheckForm.pay_date" class="p-2 border w-full"/>
                  <div v-if="errors.pay_date" v-text="errors.pay_date" class="text-md text-red-400 font-bold"></div>
                </div>
                <div class="my-2">
                  <label class="font-bold">Amount: </label>
                  <input type="number" step="0.01" v-model="createPaycheckForm.payday" class="p-2 border w-full"/>
                  <div v-if="errors.payday" v-text="errors.payday" class="text-md text-red-400 font-bold"></div>
                </div>
                <div class="my-2">
                  <button class="bg-indigo-400 text-white w-64 h-10 font-bold hover:bg-indigo-600">Create Paycheck</button>
                </div>
              </form>
            </div>
          </div>
          </Modal>
          <Modal ref="update-paycheck" :show="showModifyPaycheckModal">
          <div class="p-8 relative">
            <div
              class="absolute right-0 top-0 mr-2 mt-2 text-gray-700 hover:text-gray-900 cursor-pointer"
              @click="closeUpdatePaycheck"
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
            <div class="p-8">
              <h1 class="text-2xl">Update Paycheck</h1>
              <form @submit.prevent="updatePaycheck">
                <div class="my-2">
                  <label class="font-bold">Name: </label>
                  <input type="text" v-model="createPaycheckForm.name" class="p-2 border w-full"/>
                </div>
                <div class="my-2">
                  <label class="font-bold">Pay Date: </label>
                  <input type="date" v-model="createPaycheckForm.pay_date" class="p-2 border w-full"/>
                </div>
                <div class="my-2">
                  <label class="font-bold">Amount: </label>
                  <input type="number" step="0.01" v-model="createPaycheckForm.payday" class="p-2 border w-full"/>
                </div>
                <div class="my-2">
                  <button class="bg-indigo-400 text-white w-64 h-10 font-bold hover:bg-indigo-600">Update Paycheck</button>
                </div>
              </form>
            </div>
          </div>
          </Modal>
        </div>
      </div>
    </div>
      <div class="h-32 bg-indigo-300 flex items-center">
        <div class="w-3/4 md:w-1/2 flex flex-col md:flex-row justify-center mx-auto">
          <button
            class="w-full mb-2 md:mb-0 bg-gray-900 w-56 h-10 text-gray-100"
            @click="createCategory"
            >
            Create Category
          </button>
            <a
              class="w-full bg-gray-900 w-56 h-10 text-gray-100 ml-0 md:ml-2 flex items-center justify-center"
              :href="'/create-transaction/' + month.id"
              >
              Create/View Transaction
            </a>
        </div>
      </div>
        <div class="w-full h-16 bg-indigo-900 flex justify-center items-end">
          <div class="mb-4 text-gray-100">Copyright {{ new Date().getFullYear()}} All rights reserved</div>
          </div>
  </app-layout>
</template>

<script>
import AppLayout from "./../Layouts/AppLayout";
import ItemComponent from "./../Components/ItemComponent";
import PaycheckComponent from "./../Components/PaycheckComponent";
import Modal from "./../Jetstream/Modal";
import {Inertia} from "@inertiajs/inertia";

export default {
  components: {
    AppLayout,
    ItemComponent,
    Modal,
    PaycheckComponent
  },
  props: {
    month : Object, 
    paid : Number, 
    left : Number, 
    planning : Number, 
    errors : Object
    },
  data() {
    return {
      showItemModal: false,
      showModifyItemModal: false,
      showCategoryModal: false,
      showModifyCategoryModal: false,
      showModifyPaycheckModal: false,
      showPaycheckModal: false,
      itemFormId : null,
      categoryFormId : null,
      paycheckFormId : null,
      goTo : {
        month : this.month.month,
        year : this.month.year
      },
      createItemForm: {
        name : null,
        planned : null,
        category_id : null,
        month_id : null,
        is_fund : 0
      },
      createCategoryForm: {
        name : null,
        month_id : null
      },
      createPaycheckForm: {
        name: null,
        payday : null,
        pay_date: null,
        month_id : null
      },
      item : "",
      monthly_planned : null
    };
  },
  computed : {
    payAmount : {
      get() {
        return ( this.paid / 100 ).toFixed(2);
      }

    },
    amountLeft : {
      get() {

        return (this.left / 100).toFixed(2);
      }

    },
    monthlyPlanned : {
      get() {
        return (this.month.monthly_planned / 100).toFixed(2);
      }

    },
    monthlyLeft : {
      get() {
        return (this.planning / 100).toFixed(2);
      }
    }


  },
  methods: {
    storeMonthlyPlanned() {
      Inertia.post("/modify-planned", {monthly_planned : this.monthly_planned, month_id : this.month.id});
    },
    createItem() {
      this.showItemModal = true;
    },
    createModifyItem(item) {
        this.showModifyItemModal = true;
        this.itemFormId = item.id;
        this.createItemForm.name = item.name;
        this.createItemForm.planned = (item.planned / 100).toFixed(2);
        this.createItemForm.category_id = item.category_id;
        this.createItemForm.month_id = item.month_id;
      
        this.createItemForm.is_fund = (item.is_fund == "0" ? false : true);
    
    },
    createModifyPaycheck(paycheck) {
        this.showModifyPaycheckModal = true;
        this.paycheckFormId = paycheck.id;
        this.createPaycheckForm.name = paycheck.name,
        this.createPaycheckForm.payday = ( ( paycheck.payday )/100 ).toFixed(2),
        this.createPaycheckForm.pay_date = paycheck.pay_date,
        this.createPaycheckForm.month_id = paycheck.month_id
    
    },
    createItemWithCategory(category) {
      this.createItemForm.category_id = category;
      this.showItemModal = true;
    },
    createCategory() {
      this.showCategoryModal = true;
    },
    createModifyCategory(category) {
      this.showModifyCategoryModal = true;
      this.createCategoryForm.month_id = category.month_id;
      this.createCategoryForm.name = category.name;
      this.categoryFormId = category.id;
    },
    createPaycheck() {
      this.showPaycheckModal = true;
    },

    storeItem() {
      this.createItemForm.month_id = this.month.id;
      Inertia.post("/items", this.createItemForm, {preserveState: true, preserveScroll : true}).then(()=>{
        if(typeof this.errors.name !== 'undefined' || typeof this.errors.planned !== 'undefined' || typeof this.errors.category_id !== 'undefined') {
          this.showItemModal = true;
        }
        else {
          this.createItemForm.name = null,
          this.createItemForm.planned = null,
          this.createItemForm.category_id = null,
          this.createItemForm.month_id = null,
          this.createItemForm.is_fund = null,
          this.showItemModal = false;
        }


      });

    },
    updateItem() {
      this.createItemForm.month_id = this.month.id;
      Inertia.put("/items/" + this.itemFormId, this.createItemForm, {preserveScroll : true, preserveState : true}).then(()=>{
        if(typeof this.errors.name !== 'undefined' || typeof this.errors.planned !== 'undefined' || typeof this.errors.category_id !== 'undefined') {
          this.showItemModal = true;
        }
        else {
          this.createItemForm.name = null,
          this.createItemForm.planned = null,
          this.createItemForm.category_id = null,
          this.createItemForm.month_id = null,
          this.createItemForm.is_fund = null,
          this.showItemModal = false;
        }
      });

      this.showModifyItemModal = false;
    },
    storeCategory() {
      this.createCategoryForm.month_id = this.month.id;
      Inertia.post("/categories", this.createCategoryForm, {preserveState: true, preserveScroll : true}).then(()=>{
        if(typeof this.errors.name !== 'undefined') {
          this.showCategoryModal = true;
        }
        else {
          this.createCategoryForm.name = null,
          this.createCategoryForm.month_id = null,
          this.showCategoryModal = false
        }
      });

    },
      updateCategory() {
          Inertia.post("/categories/" + this.categoryFormId, {category : this.createCategoryForm});
          this.showModifyCategoryModal = false;
      
      },
      updatePaycheck() {
          Inertia.put("/paychecks/" + this.paycheckFormId, {paycheck : this.createPaycheckForm});
          this.showModifyPaycheckModal = false;
      },
    storePaycheck() {
      this.createPaycheckForm.month_id = this.month.id;
      Inertia.post("/paychecks", this.createPaycheckForm).then(()=>{
        if(typeof this.errors.name !== 'undefined' || typeof this.errors.payday !== 'undefined' || typeof this.errors.pay_date !== 'undefined') {
          this.showPaycheckModal = true;
        }
        else {
          this.createPaycheckForm.name = null,
          this.createPaycheckForm.payday = null,
          this.createPaycheckForm.pay_date = null,
          this.showPaycheckModal = false
        }
      });
    },
    closeItem() {
      this.errors = Object.assign({name : null, planned : null, category : null});
      this.createItemForm = Object.assign({name : null, planned : null, category_id : null, month_id : null, is_fund : null});

      this.showItemModal = false;
    },
    closeModifyItem() {
      this.createItemForm = Object.assign({name : null, planned : null, category_id : null, month_id : null, is_fund : null});
      this.showModifyItemModal = false;
    },
    closeCategory() {
      this.errors = Object.assign({name : null});
      this.createCategoryForm = Object.assign({name : null});
      this.showCategoryModal = false;
    },
    closeModifyCategory() {
      this.createCategoryForm = Object.assign({name : null});
      this.showModifyCategoryModal = false;
    },
    closeConfirmationModal() {
      this.showConfirmationModal = false;
    },
    closePaycheck() {
      this.errors = Object.assign({name : null, payday : null, pay_date : null});
      this.createPaycheckForm = Object.assign({name : null, payday : null, pay_date : null});
      this.showPaycheckModal = false;
    },
    closeUpdatePaycheck() {
        this.createPaycheckForm = Object.assign({name : null, payday : null, pay_date : null});
        this.showModifyPaycheckModal = false;
    
    },
    goToMonth() {
      window.location = '/month/'+this.goTo.month + '/year/' + this.goTo.year;
    },
    deleteItem(id) {
      Inertia.delete("/items/"+id, {preserveState : true, preserveScroll : true}).then(()=>{
        this.showModifyItemModal = false;
      });
    },
    deleteCategory(id) {
      Inertia.delete("/categories/"+id, {preserveState : true, preserveScroll : true}).then(()=>{
        this.showModifyCategoryModal = false;
      });
    },
    deletePaycheck(id) {
      Inertia.delete("/paychecks/"+id, {preserveState : true, preserveScroll : true}).then(()=>{
        this.showModifyPaycheckModal = false;
      });
    },

  },
};
</script>
