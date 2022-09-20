<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  reports: Array,
  drivers: Array,
  weeks: Array,
  current_week: String,
});

const form = useForm({
  driver_id: "",
  monday_hours: null,
  tuesday_hours: null,
  wednesday_hours: null,
  thursday_hours: null,
  friday_hours: null,
  saturday_hours: null,
  sunday_hours: null,
  monday_fixed: null,
  tuesday_fixed: null,
  wednesday_fixed: null,
  thursday_fixed: null,
  friday_fixed: null,
  saturday_fixed: null,
  sunday_fixed: null,
  monday_bonus: 0,
  tuesday_bonus: 0,
  wednesday_bonus: 0,
  thursday_bonus: 0,
  friday_bonus: 0,
  saturday_bonus: 0,
  sunday_bonus: 0,
  food_allowance: null,
  fuel_allowance: null,
  notes: null,
  standard_hours: null,
  total_hours: null,
  net_pay: null,
  overtime: null,
  deductions: null,
  expenses: null,
  gross_pay: null,
  status: 1,
  week_no:props.current_week,
  payslip: null,
  daily_rate: {
    monday: 14,
    tuesday: 14,
    wednesday: 14,
    thursday: 14,
    friday: 14,
    saturday: 15,
    sunday: 15,
  },
});
const calculatePay = () => {
  form.total_hours =
    form.monday_hours +
    form.tuesday_hours +
    form.wednesday_hours +
    form.thursday_hours +
    form.friday_hours +
    form.saturday_hours +
    form.sunday_hours + form.monday_bonus + form.tuesday_bonus + form.wednesday_bonus + form.thursday_bonus + form.friday_bonus + form.saturday_bonus + form.sunday_bonus;
    var overtime=form.total_hours - 39;
    if(overtime<0){
      overtime=0;
    }
    form.overtime=overtime;    
  form.gross_pay =
    form.monday_hours * form.daily_rate.monday +
    form.tuesday_hours * form.daily_rate.tuesday +
    form.wednesday_hours * form.daily_rate.wednesday +
    form.thursday_hours * form.daily_rate.thursday +
    form.friday_hours * form.daily_rate.friday +
    form.saturday_hours * form.daily_rate.saturday +
    form.sunday_hours * form.daily_rate.sunday +
    15 * form.monday_bonus+
    15 * form.tuesday_bonus +
    15 * form.wednesday_bonus +
    15 * form.thursday_bonus +
    15 * form.friday_bonus +
    16 * form.saturday_bonus +
    16 * form.sunday_bonus +    
    form.monday_fixed +
    form.tuesday_fixed +
    form.wednesday_fixed +
    form.thursday_fixed +
    form.friday_fixed +
    form.saturday_fixed +
    form.sunday_fixed +
    form.food_allowance +
    form.fuel_allowance
    + form.overtime * 1;

    form.standard_hours = form.total_hours - form.overtime;
};

function storeReport() {
  form.post("/reports");
}
</script>

<template>
  <AppLayout title="Reports">
    <form
      @submit.prevent="storeReport"
      class="py-12 mx-auto space-y-8 divide-y divide-gray-200 max-w-7xl sm:px-6 lg:px-8"
    >
      <div class="space-y-8 divide-y divide-gray-200">
        <div class="pt-8">
          <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Driver Report
            </h3>
          </div>
          <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-7">
            <div class="sm:col-span-3">
              <label
                for="country"
                class="block text-sm font-medium text-gray-700"
              >
                Driver
              </label>
              <div class="mt-1">
                <select
                  id="driver"
                  name="driver"
                  autocomplete="driver-name"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.driver_id"
                  required
                >
                  <option value="" disabled>Please Select A Driver</option>
                  <option
                    v-for="(driver, key) in drivers"
                    v-bind:key="key"
                    v-bind:value="key"
                  >
                    {{ driver }}
                  </option>
                </select>
              </div>
            </div>

            <div class="sm:col-span-2">
              <div>
                <label
                  for="location"
                  class="block text-sm font-medium text-gray-700"
                  >Status</label
                >
                <select
                  id="status"
                  name="status"
                  v-model="form.status"
                  class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option value="1">New</option>
                  <option value="2">Needs Approval</option>
                  <option value="3">Employee Check</option>
                  <option value="4">Ready for Payroll</option>
                  <option value="5">Paid</option>
                </select>
              </div>
            </div>
            <div class="sm:col-span-2">
              <div>
                <label
                  for="location"
                  class="block text-sm font-medium text-gray-700"
                  >Week no</label
                >
                <select
                  id="week_no"
                  name="week_no"
                  v-model="form.week_no"
                  class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <option
                    v-for="(week_name,week_no) in weeks"
                    v-bind:key="week_no"
                    v-bind:value="week_no"
                  >
                    {{ week_name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Monday <span class="font-bold text-red-500">H</span> £14
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.monday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Tuesday <span class="font-bold text-red-500">H</span> £14
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.tuesday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Wednesday <span class="font-bold text-red-500">H</span> £14
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.wednesday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Thursday <span class="font-bold text-red-500">H</span> £14
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.thursday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Friday <span class="font-bold text-red-500">H</span> £14
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.friday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Saturday <span class="font-bold text-red-500">H</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.saturday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Sunday <span class="font-bold text-red-500">H</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.sunday_hours"
                  @change="calculatePay"
                  placeholder="0"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Monday <span class="font-bold text-orange-500">B</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.monday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Tuesday <span class="font-bold text-orange-500">B</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.tuesday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Wednesday <span class="font-bold text-orange-500">B</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.wednesday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Thursday <span class="font-bold text-orange-500">B</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.thursday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Friday <span class="font-bold text-orange-500">B</span> £15
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.friday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Saturday <span class="font-bold text-orange-500">B</span> £16
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.saturday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Sunday <span class="font-bold text-orange-500">B</span> £16
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.sunday_bonus"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Monday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.monday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Tuesday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.tuesday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Wednesday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.wednesday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Thursday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.thursday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Friday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.friday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label for="city" class="block text-sm font-medium text-gray-700">
                Saturday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="city"
                  id="city"
                  autocomplete="address-level2"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.saturday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-1">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Sunday <span class="font-bold text-violet-500">F</span>
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.sunday_fixed"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-2">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Food Allowance
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.food_allowance"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-2">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Fuel Allowance
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="region"
                  id="region"
                  autocomplete="address-level1"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.fuel_allowance"
                  @change="calculatePay"
                  step="any"
                />
              </div>
            </div>

            <div class="sm:col-span-3">
              <div>
                <label
                  for="comment"
                  class="block text-sm font-medium text-gray-700"
                  >Notes</label
                >
                <div class="mt-1">
                  <textarea
                    rows="4"
                    name="comment"
                    id="comment"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    v-model="form.notes"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="space-y-8 divide-y divide-gray-200">
        <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Standard Hours
            </label>
            <div class="mt-1">
              <input
                disabled
                type="number"
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-100"
                v-model="form.standard_hours"
              />
            </div>
          </div>
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Overtime Hours
            </label>
            <div class="mt-1">
              <input
                disabled
                type="number"
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-100"
                v-model="form.overtime"
              />
            </div>
          </div>
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Total Hours
            </label>
            <div class="mt-1">
              <input
                disabled
                type="number"
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-100"
                v-model="form.total_hours"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-8 divide-y divide-gray-200">
        <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Expenses <span class="font-bold text-green-500">+</span>
            </label>
            <div class="mt-1">
              <input
                type="number"
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                v-model="form.expenses"
                @change="calculatePay"
                step="any"
              />
            </div>
          </div>

          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Deductions <span class="font-bold text-rose-500">-</span>
            </label>
            <div class="mt-1">
              <input
                type="number"
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                v-model="form.deductions"
                @change="calculatePay"
                step="any"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="space-y-8 divide-y divide-gray-200">
        <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Gross Pay
            </label>
            <div class="mt-1">
              <input
                type="number"
                disabled
                name="net-pay"
                class="block w-full border-gray-300 rounded-md shadow-sm bg-slate-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                v-model="form.gross_pay"
              />
            </div>
          </div>
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm font-medium text-gray-700">
              Payslip
            </label>
            <div class="flex space-x-5">
              <div>
                <a
                  :href="payslip"
                  target="_blank"
                  class="inline-flex items-center px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400"
                >
                  <svg
                    class="w-4 h-4 mr-2 fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                  </svg>
                  <span>Download</span>
                </a>
              </div>
              <div class="mt-1">
                <input
                  type="file"
                  name="net-pay"
                  class="block w-full border-gray-300 rounded-md shadow-sm bg-slate-100 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  @input="form.payslip = $event.target.files[0]"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="space-y-8 divide-y divide-gray-200">
          <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
            <div class="sm:col-span-2">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Net Pay
              </label>
              <div class="mt-1">
                <input
                  type="number"
                  name="net-pay"
                  class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  v-model="form.net_pay"
                  @change="calculatePay"
                  step="any"
                />
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
