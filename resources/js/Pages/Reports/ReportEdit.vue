<script setup>
  import AppLayout from "@/Layouts/AppLayout.vue";
  import Welcome from "@/Jetstream/Welcome.vue";
  import { Link, useForm } from "@inertiajs/inertia-vue3";
  import { Inertia } from "@inertiajs/inertia";
  
  const props = defineProps({
    report: Object,
    drivers: Object,
    payslip: String,
  });
  
  
  const form = useForm({
  driver_id: props.report.driver_id,
  monday_hours: props.report.monday_hours,
  tuesday_hours: props.report.tuesday_hours,
  wednesday_hours: props.report.wednesday_hours,
  thursday_hours: props.report.thursday_hours,
  friday_hours: props.report.friday_hours,
  saturday_hours: props.report.saturday_hours,
  sunday_hours: props.report.sunday_hours,
  monday_fixed: props.report.monday_fixed,
  tuesday_fixed: props.report.tuesday_fixed,
  wednesday_fixed: props.report.wednesday_fixed,
  thursday_fixed: props.report.thursday_fixed,
  friday_fixed: props.report.friday_fixed,
  saturday_fixed: props.report.saturday_fixed,
  sunday_fixed: props.report.sunday_fixed,
  monday_bonus: props.report.monday_bonus,
  tuesday_bonus: props.report.tuesday_bonus,
  wednesday_bonus: props.report.wednesday_bonus,
  thursday_bonus: props.report.thursday_bonus,
  friday_bonus: props.report.friday_bonus,
  saturday_bonus: props.report.saturday_bonus,
  sunday_bonus: props.report.sunday_bonus,  
  food_allowance: props.report.food_allowance,
  fuel_allowance: props.report.fuel_allowance,
  notes: props.report.notes,
  total_hours: props.report.total_hours,
  net_pay: props.report.net_pay,
  actual_pay: props.report.actual_pay,
  overtime: props.report.overtime,
  deductions: props.report.deductions,
  expenses: props.report.expenses,
  gross_pay: props.report.gross_pay,
  payslip: props.report.payslip,
  status: props.report.status,
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
  
  function updateReport() {
    Inertia.post(`/report/${props.report.id}`, {
      _method: "put",
      driver_id: form.driver_id,
      status: form.status,
      monday_hours: form.monday_hours,
      tuesday_hours: form.tuesday_hours,
      wednesday_hours: form.wednesday_hours,
      thursday_hours: form.thursday_hours,
      friday_hours: form.friday_hours,
      saturday_hours: form.saturday_hours,
      sunday_hours: form.sunday_hours,
      monday_fixed: form.monday_fixed,
      tuesday_fixed: form.tuesday_fixed,
      wednesday_fixed: form.wednesday_fixed,
      thursday_fixed: form.thursday_fixed,
      friday_fixed: form.friday_fixed,
      saturday_fixed: form.saturday_fixed,
      sunday_fixed: form.sunday_fixed,
      monday_bonus: form.monday_bonus,
      tuesday_bonus: form.tuesday_bonus,
      wednesday_bonus: form.wednesday_bonus,
      thursday_bonus: form.thursday_bonus,
      friday_bonus: form.friday_bonus,
      saturday_bonus: form.saturday_bonus,
      sunday_bonus: form.sunday_bonus,    
      food_allowance: form.food_allowance,
      fuel_allowance: form.fuel_allowance,
      notes: form.notes,
      total_hours: form.total_hours,
      net_pay: form.net_pay,
      actual_pay: form.actual_pay,
      deductions: form.deductions,
      expenses: form.expenses,
      gross_pay: form.gross_pay,
      payslip: form.payslip,
      
    });
  }
  
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

  form.actual_pay = form.net_pay - form.deductions + form.expenses;
};
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
                Driver Report
              </h3>
            </div>
            <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-7">
              <div class="sm:col-span-4">
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
  
              <div class="sm:col-span-3">
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
                    step='any'
                  />
                </div>
              </div>
              <div class="sm:col-span-1">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Monday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label for="city" class="block text-sm font-medium text-gray-700">
                  Tuesday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Wednesday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label for="city" class="block text-sm font-medium text-gray-700">
                  Thursday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Friday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label for="city" class="block text-sm font-medium text-gray-700">
                  Saturday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-1">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Sunday <span class="font-bold text-violet-500">B</span>
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
                    step='any'
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
                    step='any'
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
                    step='any'
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
        <div class="sm:col-span-2">
              <label
                for="region"
                class="block text-sm font-medium text-gray-700"
              >
                Overtime
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
  
        <div class="space-y-8 divide-y divide-gray-200">
          <div class="grid grid-cols-1 mt-6 gap-y-6 gap-x-4 sm:grid-cols-6">
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
              <div>
              <a  :href="payslip" target="_blank" class="inline-flex items-center px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
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

                    step='any'
                  />
                </div>
              </div>
              <div class="sm:col-span-2">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Expenses <span class="font-bold text-green-500">+</span>
                </label>
                <div class="mt-1">
                  <input
                    type="number"
                    name="net-pay"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    v-model="form.expenses"
                    @change="calculatePay"
                    step='any'
                  />
                </div>
              </div>
  
              <div class="sm:col-span-2">
                <label
                  for="region"
                  class="block text-sm font-medium text-gray-700"
                >
                  Deductions <span class="font-bold text-rose-500">-</span>
                </label>
                <div class="mt-1">
                  <input
                    type="number"
                    name="net-pay"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    v-model="form.deductions"
                    @change="calculatePay"
                    step='any'
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
                  Actual Pay
                </label>
                <div class="mt-1">
                  <input
                    disabled
                    type="number"
                    name="net-pay"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-slate-100"
                    v-model="form.actual_pay"
                    step='any'
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