<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Import Transactions
            </h2>
        </template>
        <div class="relative">
            <div class="pt-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-8">
                        <p class="mb-4">Here we can upload a file. The file needs to have the following headings - (name, description, date)</p>
                        <form @submit.prevent="submitCsv" enctype="multipart/form-data">
                            <div class="my-2">
                                <label for="csvimport" class="font-bold">Select File (.csv or .xls): </label>
                                <div>
                                    <input type="file" id="csvimport" :name="csvimport" class="border p-2 rounded">
                                </div>
                            </div>
                            <div class="my-2">
                                <button
                                    type="submit"
                                    class="bg-indigo-500 text-white font-bold h-10 w-full md:w-64 rounded-lg hover:bg-indigo-600"
                                    >
                                    Upload File
                                </button>
                            </div>
                            

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from "./../Layouts/AppLayout";
import {Inertia} from "@inertiajs/inertia";
export default {
    components : {
        AppLayout
    },
    data() {
        return {
            'csvimport': ''

        }

    },
    methods : {
        submitCsv() {
            let data = new FormData();
            data.append('csvimport', this.csvimport);
            Inertia.post('transaction-importer', data, {
                onSuccess : (data) => {
                    console.log(data);
                }

            });

        }

    },


};
</script>
