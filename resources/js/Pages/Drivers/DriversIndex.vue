<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Link } from "@inertiajs/inertia-vue3";
const props = defineProps({
  drivers: Array,
});

</script>

<template>
  <AppLayout title="Drivers">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Drivers</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
          <div class="p-12 px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Drivers</h1>
                <p class="mt-2 text-sm text-gray-700">
                  A list of all the drivers.
                </p>
              </div>
              <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <Link
                  as="button"
                  href="/drivers/create"
                  class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                >
                  Create Driver
                </Link>
              </div>
            </div>
            <div class="flex flex-col mt-8">
              <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                  class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                >
                  <div
                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                  >
                    <table class="min-w-full divide-y divide-gray-300">
                      <thead class="bg-gray-50">
                        <tr>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Name
                          </th>
                          <th
                            scope="col"
                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6"
                          >
                            Type
                          </th>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Email
                          </th>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Phone
                          </th>

                          <th
                            scope="col" 
                            class="relative py-3 pl-3 pr-4 sm:pr-6"
                          >
                            <span class="sr-only">Edit</span>
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="driver in drivers" :key="driver.id">
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            {{ driver.name }}
                          </td>
                          <td
                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6"
                          >
                            {{ driver.type }}
                          </td>
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            {{ driver.email }}
                          </td>
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            {{ driver.phone }}
                          </td>

                          <td
                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                          >
                            <Link
                              :href="`/drivers/${driver.id}/edit`"
                              class="mr-4 text-indigo-600 hover:text-indigo-900"
                              >Edit
                            </Link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
