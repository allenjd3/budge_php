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
                        <form @submit.prevent="submitCsv">
                            <div class="my-2">
                                <label for="csvimport" class="font-bold">Select File (.csv or .xls): </label>
                                <div>
                                    <input type="file" id="csvimport" @input="csvimport = $event.target.files[0]" class="border p-2 rounded">
                                    <div v-if="errors.csvimport" v-text="errors.csvimport" class="text-md text-red-400 font-bold"></div>
                                </div>
                                <input type="hidden" name="month" :value="month.id">
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
                        <div v-if="csvimports.length > 0">
                            <h2 class="text-xl">Currently Imported Csv files</h2>
                            <div v-for="csv in csvimports" :key="csv.id" class="flex justify-between items-center">
                                <a :href="`/month/${month.id}/transactions/import/${csv.id}`"><div v-text="csv.file_path"></div></a>
                                <div>
                                    <form @submit.prevent="deleteCsvFile(csv.id)">
                                        <button type="submit" class="px-4 py-2 border rounded-lg">Delete Import</button>
                                    </form>
                                </div>
                            </div>
                        </div>

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
            csvimport: '',
        }

    },
    props : ['month', 'errors', 'csvimports'],
    mounted(){
        console.log(this.csvimports)
    },
    methods : {
        submitCsv() {
            let data = new FormData();
            data.append('csvimport', this.csvimport);
            Inertia.post(`/month/${this.month.id}/transactions/import`, data, {
                onSuccess : (data) => {
                    console.log(data);
                },
                onError : (error) => {
                    console.error(error)
                },
            });

        },
        deleteCsvFile(id) {
            Inertia.delete(`/month/${this.month.id}/transactions/import/${id}/delete`, {
                onSuccess : (deleted) => {
                    console.log(deleted);
                },
                onError : (error) => {
                    console.error(error)
                }
            });

        }

    },


};
</script>
