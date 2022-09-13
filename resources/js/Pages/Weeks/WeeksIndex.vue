<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";

const props = defineProps({
  weeks: Array,
});
</script>

<template>
  <AppLayout title="Weeks">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Weeks</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
          <div class="p-12 px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
              <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Weeks</h1>
                <p class="mt-2 text-sm text-gray-700">
                  A list of all the weeks.
                </p>
              </div>
              <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button
                  type="button"
                  class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                >
                  Add Week
                </button>
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
                            class="py-3 pl-4 pr-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase sm:pl-6"
                          >
                            Number
                          </th>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Month
                          </th>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Year
                          </th>
                          <th
                            scope="col"
                            class="px-3 py-3 text-xs font-medium tracking-wide text-left text-gray-500 uppercase "
                          >
                            Total Wages
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
                        <tr v-for="week in weeks" :key="week.id">
                          <td
                            class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6"
                          >
                            Week {{ week.week_number }}
                          </td>
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            {{ week.month }}
                          </td>
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            {{ week.year }}
                          </td>
                          <td
                            class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap"
                          >
                            £0
                          </td>

                          <td
                            class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-6"
                          >
                            <Link
                              as="button"
                              href="/report/view/{{ report.id }}"
                              class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                              View Week
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
