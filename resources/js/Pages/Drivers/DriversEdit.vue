<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
  driver: Object,
});


const form = useForm({ 
  name: props.driver.name,
  email: props.driver.email,
  phone: props.driver.phone,
  type: props.driver.type
});

function updateReport() {
  Inertia.post(`/drivers/${props.driver.id}`, {
    _method: "put",
    name: form.name,
    email: form.email,
    phone: form.phone,
    type: form.type
    
  });
}

</script>

<template>
  <AppLayout title="Reports">
    <form
      @submit.prevent="updateReport"
      class="py-12 mx-auto space-y-8 divide-y divide-gray-200 max-w-7xl sm:px-6 lg:px-8"
    >
      <div class="space-y-8 divide-y divide-gray-200">
        <div class="pt-8">
          <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Update driver
            </h3>
          </div>
          <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-7">

            <div class="sm:col-span-4">
              <label
                for="country"
                class="block text-sm font-medium text-gray-700"
              >
                Name
              </label>
              <div class="mt-1">
                <input
                  type="text"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.name"
                  placeholder="Enter Name"
                />
              </div>
            </div>
            <div class="sm:col-span-4">
              <label
                class="block text-sm font-medium text-gray-700"
              >
                Email
              </label>
              <div class="mt-1">
                <input
                  type="email"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.email"
                  placeholder="Enter email"
                />
              </div>
            </div>
            <div class="sm:col-span-4">
              <label
                class="block text-sm font-medium text-gray-700"
              >
                Phone
              </label>
              <div class="mt-1">
                <input
                  type="text"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.phone"
                  placeholder="Enter phone no"
                />
              </div>
            </div>
            <div class="sm:col-span-3">
              <div>
                <label
                  for="location"
                  class="block text-sm font-medium text-gray-700"
                  >Type</label
                >
                <select
                  id="Type"
                  name="Type"
                  v-model="form.type"
                  class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option value="1">Employed</option>
                  <option value="2">Self employed</option>
                </select>
              </div>
            </div>


          </div>
        </div>
      </div>


      <div class="pt-5">
        <div class="flex justify-end">
          <button
            type="button"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="inline-flex justify-center px-4 py-2 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Save
          </button>
        </div>
      </div>
    </form>
  </AppLayout>
</template>