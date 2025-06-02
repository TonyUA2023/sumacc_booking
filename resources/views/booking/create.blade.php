@extends('public.layout')

@section('content')
    <div
        class="max-w-7xl mx-auto mt-16 mb-16 px-4 sm:px-6 lg:px-8"
        x-data='{
            selectedVehicleType: {!! json_encode(old('vehicle_type_id', null)) !!},
            extras: {!! json_encode(old('extras', [])) !!},

            first_name: {{ old('first_name') ? json_encode(old('first_name')) : '""' }},
            last_name: {{ old('last_name') ? json_encode(old('last_name')) : '""' }},
            email: {{ old('email') ? json_encode(old('email')) : '""' }},
            phone: {{ old('phone') ? json_encode(old('phone')) : '""' }},
            street: {{ old('street') ? json_encode(old('street')) : '""' }},
            city: {{ old('city') ? json_encode(old('city')) : '""' }},
            state_province: {{ old('state') ? json_encode(old('state')) : '""' }},
            postal_code: {{ old('postal_code') ? json_encode(old('postal_code')) : '""' }},
            notes: {{ old('notes') ? json_encode(old('notes')) : '""' }},

            vehicleTypeNames: {!! json_encode($vehicleTypes->pluck("name", "id")) !!},
            serviceVehiclePrices: {!! json_encode($serviceVehiclePrices) !!},
            extraServiceDetails: {!! json_encode($extraServiceDetails) !!},
            
            basePrice: 0,
            extrasTotal: 0,
            totalPrice: 0,

            date: {!! json_encode(old('date', '')) !!},
            time: {!! json_encode(old('time', '')) !!},
            allPossibleTimes: ["06:00", "07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00"],
            unavailableTimes: [],
            isLoadingTimes: false,

            currentMonth: null, 
            currentYear: null,
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            dayShortNames: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            daysInCalendarGrid: [],
            today: new Date(),

            initCalendar() {
                let initialDateToUse;
                if (this.date) {
                    const parts = this.date.split("-");
                    if (parts.length === 3) {
                        initialDateToUse = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1, parseInt(parts[2]));
                        if (isNaN(initialDateToUse.getTime())) initialDateToUse = new Date();
                    } else {
                         initialDateToUse = new Date();
                    }
                } else {
                    initialDateToUse = new Date();
                }
                if (!(initialDateToUse instanceof Date && !isNaN(initialDateToUse))) {
                    initialDateToUse = new Date();
                }

                this.currentMonth = initialDateToUse.getMonth();
                this.currentYear = initialDateToUse.getFullYear();
                this.today.setHours(0, 0, 0, 0); 
                this.generateCalendarGrid();
                if(this.date) this.fetchUnavailableTimes();
                this.updatePrices();
            },

            generateCalendarGrid() {
                this.daysInCalendarGrid = [];
                const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1);
                const lastDayOfMonth = new Date(this.currentYear, this.currentMonth + 1, 0);
                const numDaysInMonth = lastDayOfMonth.getDate();
                
                let dayOfWeekForFirstDay = firstDayOfMonth.getDay(); 
                if (dayOfWeekForFirstDay === 0) dayOfWeekForFirstDay = 6; 
                else dayOfWeekForFirstDay -= 1; 

                const prevMonthEndDate = new Date(this.currentYear, this.currentMonth, 0); 
                const prevMonth = prevMonthEndDate.getMonth();
                const prevYear = prevMonthEndDate.getFullYear();

                for (let i = dayOfWeekForFirstDay - 1; i >= 0; i--) {
                    const day = prevMonthEndDate.getDate() - i;
                    const dateObj = new Date(prevYear, prevMonth, day);
                    this.daysInCalendarGrid.push({
                        day: day, monthType: "prev", dateString: this.formatDateObj(dateObj), isPast: true
                    });
                }

                for (let i = 1; i <= numDaysInMonth; i++) {
                    const dateObj = new Date(this.currentYear, this.currentMonth, i);
                    dateObj.setHours(0,0,0,0);
                    const dateStr = this.formatDateObj(dateObj);
                    this.daysInCalendarGrid.push({
                        day: i, monthType: "current", dateString: dateStr,
                        isToday: dateStr === this.formatDateObj(this.today),
                        isSelected: dateStr === this.date,
                        isPast: dateObj < this.today
                    });
                }
                const cellsSoFar = this.daysInCalendarGrid.length;
                const totalCells = this.daysInCalendarGrid.length > 35 ? 42 : 35;
                const daysToAddFromNextMonth = totalCells - cellsSoFar;
                const nextMonthStartDate = new Date(this.currentYear, this.currentMonth + 1, 1);
                const nextMonth = nextMonthStartDate.getMonth();
                const nextYear = nextMonthStartDate.getFullYear();

                for (let i = 1; i <= daysToAddFromNextMonth; i++) {
                    const dateObj = new Date(nextYear, nextMonth, i);
                    this.daysInCalendarGrid.push({
                        day: i, monthType: "next", dateString: this.formatDateObj(dateObj), isPast: true
                    });
                }
            },

            selectDay(dayObj) {
                if (dayObj.monthType === "prev") {
                    this.changeMonth(-1); return;
                }
                if (dayObj.monthType === "next") {
                    this.changeMonth(1); return;
                }
                if (dayObj.monthType === "current" && !dayObj.isPast) {
                    if (this.date !== dayObj.dateString) { // Only fetch if date actually changes
                        this.time = ""; // Reset time when date changes
                        this.date = dayObj.dateString;
                        this.fetchUnavailableTimes();
                    } else if (!this.unavailableTimes.length && this.date) { // If date is re-selected and times were not fetched
                        this.fetchUnavailableTimes();
                    }
                }
                this.generateCalendarGrid(); 
            },

            fetchUnavailableTimes() {
                if (!this.date) return;
                this.isLoadingTimes = true;
                this.unavailableTimes = [];
                fetch(`{{ route('booking.unavailable_times') }}?date=${this.date}`)
                    .then(response => {
                        if (!response.ok) throw new Error("Network response was not ok");
                        return response.json();
                    })
                    .then(data => {
                        this.unavailableTimes = data;
                        this.isLoadingTimes = false;
                    })
                    .catch(error => {
                        this.isLoadingTimes = false;
                        console.error("Error fetching unavailable times:", error);
                        // Optionally show an error message to the user
                    });
            },

            changeMonth(offset) {
                this.currentMonth += offset;
                if (this.currentMonth < 0) {
                    this.currentMonth = 11; this.currentYear--;
                } else if (this.currentMonth > 11) {
                    this.currentMonth = 0; this.currentYear++;
                }
                this.generateCalendarGrid();
            },

            formatDateObj(dateObj) {
                const year = dateObj.getFullYear();
                const month = (dateObj.getMonth() + 1).toString().padStart(2, "0");
                const day = dateObj.getDate().toString().padStart(2, "0");
                return `${year}-${month}-${day}`;
            },

            getFormattedMonthYear() {
                if (this.currentMonth === null || this.currentYear === null) return "";
                const monthName = this.monthNames[this.currentMonth];
                return monthName.charAt(0).toUpperCase() + monthName.slice(1) + " " + this.currentYear;
            },

            updatePrices() {
                this.basePrice = 0;
                if (this.selectedVehicleType && this.serviceVehiclePrices && typeof this.serviceVehiclePrices === "object" && this.serviceVehiclePrices.hasOwnProperty(this.selectedVehicleType)) {
                    this.basePrice = parseFloat(this.serviceVehiclePrices[this.selectedVehicleType]) || 0;
                }

                let currentExtrasTotal = 0;
                if (Array.isArray(this.extras)) {
                    this.extras.forEach(extraId => {
                        if (this.extraServiceDetails && typeof this.extraServiceDetails === "object" && this.extraServiceDetails.hasOwnProperty(extraId) && this.extraServiceDetails[extraId] && typeof this.extraServiceDetails[extraId].price !== "undefined") {
                            currentExtrasTotal += parseFloat(this.extraServiceDetails[extraId].price) || 0;
                        }
                    });
                }
                this.extrasTotal = currentExtrasTotal;
                this.totalPrice = this.basePrice + this.extrasTotal;
            },

            getFormattedPrice(value) {
                if (typeof value !== "number") value = 0;
                return value.toLocaleString("en-US", { style: "currency", currency: "USD" });
            },

            isTimeSlotUnavailable(slot) { // Keep this helper for the getter
                return this.unavailableTimes.includes(slot);
            },

            get displayableTimes() { // Getter for available time slots
                if (!this.date) return []; // No date selected, so no times to display yet
                return this.allPossibleTimes.filter(slot => !this.isTimeSlotUnavailable(slot));
            }
        }'
        x-init="
            initCalendar();
            $watch('selectedVehicleType', () => updatePrices());
            $watch('extras', () => updatePrices());
            // Watcher for date is implicitly handled by selectDay now for fetching times
        "
    >
        @if(session('success'))
            <div class="bg-green-500 border border-green-600 text-white px-4 py-3 rounded-lg shadow-md mb-12">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

            <main class="lg:col-span-2">
                <div class="bg-slate-800 rounded-xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-5 sm:px-8 sm:py-6">
                        <h1 class="text-3xl font-bold text-white tracking-tight">
                            Schedule Appointment for: <span class="capitalize">{{ $service->name }}</span>
                        </h1>
                        <p class="mt-1 text-blue-100">Complete the following steps to confirm your appointment.</p>
                    </div>

                    <div class="px-6 py-8 sm:px-8 bg-slate-900">
                        <div class="space-y-10">
                            <section aria-labelledby="vehicle-type-heading">
                                <div class="flex items-center mb-5">
                                    <span class="bg-blue-500 text-white text-xl font-semibold rounded-full h-10 w-10 flex items-center justify-center mr-4 shadow-md">1</span>
                                    <h2 id="vehicle-type-heading" class="text-xl font-semibold text-slate-100">
                                        Select Vehicle Type
                                    </h2>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                                    @foreach($vehicleTypes as $vt)
                                        <label
                                            class="cursor-pointer bg-slate-800 border-2 rounded-lg overflow-hidden flex flex-col items-center p-4 transition-all duration-200 ease-in-out hover:border-blue-500 hover:shadow-lg"
                                            :class="selectedVehicleType == {{ $vt->id }} ? 'border-blue-500 ring-2 ring-blue-400 shadow-xl' : 'border-slate-700'"
                                        >
                                            <input
                                                type="radio"
                                                name="vehicle_type_selector_main_form_visual"
                                                class="sr-only"
                                                value="{{ $vt->id }}"
                                                @click="selectedVehicleType = {{ $vt->id }}"
                                                aria-labelledby="vehicle-type-{{ $vt->id }}-label"
                                                :checked="selectedVehicleType == {{ $vt->id }}"
                                            />
                                            @if(isset($vt->image_url) && $vt->image_url)
                                            <img
                                                src="{{ asset($vt->image_url) }}"
                                                alt="{{ $vt->name }}"
                                                class="w-full h-28 sm:h-32 object-contain mb-3"
                                            />
                                            @else
                                            <div class="w-full h-28 sm:h-32 flex items-center justify-center mb-3 text-slate-500">
                                                 <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.124 3.093a.75.75 0 01.626-.036l10.5 6a.75.75 0 010 1.286l-10.5 6A.75.75 0 016 15.75V4.5a.75.75 0 01.124-.407zM8.25 6.32L15.903 10.5 8.25 14.68V6.32z" clip-rule="evenodd" /><path d="M2.25 3a.75.75 0 00-.75.75v16.5a.75.75 0 00.75.75h19.5a.75.75 0 00.75-.75V3.75a.75.75 0 00-.75-.75H2.25zm19.5 1.5V12H6.655L2.25 9.332V4.5h19.5zm0 9V19.5H2.25V13.5h19.5z" /></svg>
                                            </div>
                                            @endif
                                            <span id="vehicle-type-{{ $vt->id }}-label" class="text-center text-sm font-medium text-slate-200">
                                                {{ $vt->name }}
                                            </span>
                                            <div x-show="selectedVehicleType == {{ $vt->id }}" class="mt-2 text-blue-400">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <template x-if="!selectedVehicleType">
                                    <p class="mt-4 text-sm text-slate-400">
                                        Please select a vehicle type to continue.
                                    </p>
                                </template>
                                 @error('vehicle_type_id')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </section>

                            <form
                                action="{{ route('appointments.store') }}"
                                method="POST"
                                class="space-y-10"
                                x-show.transition.opacity.duration.500ms="selectedVehicleType !== null"
                                :style="selectedVehicleType === null ? 'display: none;' : ''"
                            >
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}" />
                                <input type="hidden" name="vehicle_type_id" :value="selectedVehicleType" />

                                <section aria-labelledby="extras-heading">
                                    <div class="flex items-center mb-5">
                                        <span class="bg-blue-500 text-white text-xl font-semibold rounded-full h-10 w-10 flex items-center justify-center mr-4 shadow-md">2</span>
                                        <h2 id="extras-heading" class="text-xl font-semibold text-slate-100">
                                            Extra Services <span class="text-sm text-slate-400">(Optional)</span>
                                        </h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 bg-slate-800 p-5 rounded-lg border border-slate-700">
                                        @forelse($extraServices as $extra)
                                            <label class="flex items-center space-x-3 p-3 rounded-md hover:bg-slate-700 transition-colors cursor-pointer">
                                                <input
                                                    type="checkbox" name="extras[]" value="{{ $extra->id }}" x-model="extras"
                                                    class="form-checkbox h-5 w-5 text-blue-500 bg-slate-700 border-slate-600 rounded focus:ring-blue-500 focus:ring-offset-slate-800"
                                                />
                                                <span class="text-slate-200">
                                                    {{ $extra->name }}
                                                    @if(isset($extra->price) && $extra->price > 0)
                                                        <span class="text-sm text-green-400 ml-1">(+ <span x-text="getFormattedPrice({{ $extra->price }})"></span>)</span>
                                                    @endif
                                                </span>
                                            </label>
                                        @empty
                                            <p class="text-slate-400 text-sm col-span-full">No extra services available.</p>
                                        @endforelse
                                    </div>
                                    @error('extras.*') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                                </section>

                                <section aria-labelledby="datetime-heading">
                                    <div class="flex items-center mb-5">
                                        <span class="bg-blue-500 text-white text-xl font-semibold rounded-full h-10 w-10 flex items-center justify-center mr-4 shadow-md">3</span>
                                        <h2 id="datetime-heading" class="text-xl font-semibold text-slate-100">Choose Date and Time</h2>
                                    </div>
                                    <div class="bg-slate-800 p-5 rounded-lg border border-slate-700 space-y-6">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-300 mb-2">Booking Date</label>
                                            <div class="bg-slate-700 p-4 rounded-lg shadow-md">
                                                <div class="flex justify-between items-center mb-4">
                                                    <button @click="changeMonth(-1)" type="button" title="Previous Month" class="p-2 rounded-full hover:bg-slate-600 transition-colors">
                                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                                    </button>
                                                    <h3 class="text-lg font-semibold text-slate-100" x-text="getFormattedMonthYear()"></h3>
                                                    <button @click="changeMonth(1)" type="button" title="Next Month" class="p-2 rounded-full hover:bg-slate-600 transition-colors">
                                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-7 gap-1 text-center text-xs text-slate-400 mb-2">
                                                    <template x-for="dayName in dayShortNames" :key="dayName">
                                                        <span x-text="dayName"></span>
                                                    </template>
                                                </div>
                                                <div class="grid grid-cols-7 gap-1">
                                                    <template x-for="(dayObj, index) in daysInCalendarGrid" :key="index">
                                                        <button type="button"
                                                            @click="selectDay(dayObj)"
                                                            :disabled="dayObj.monthType !== 'current' || dayObj.isPast"
                                                            :class="{
                                                                'bg-blue-500 text-white font-bold shadow-lg': dayObj.isSelected && dayObj.monthType === 'current',
                                                                'hover:bg-blue-400 hover:text-white dark:hover:bg-slate-600': dayObj.monthType === 'current' && !dayObj.isPast && !dayObj.isSelected,
                                                                'text-slate-100': dayObj.monthType === 'current' && !dayObj.isPast,
                                                                'text-slate-500 cursor-default': dayObj.monthType !== 'current' || dayObj.isPast,
                                                                'font-semibold border border-blue-400 dark:border-blue-500': dayObj.isToday && !dayObj.isSelected && dayObj.monthType === 'current'
                                                            }"
                                                            class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg flex items-center justify-center text-sm transition-all duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-slate-700 disabled:opacity-50 disabled:hover:bg-transparent"
                                                        >
                                                            <span x-text="dayObj.day"></span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>
                                            <input type="hidden" name="date" :value="date">
                                            @error('date') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-slate-300 mb-2">Booking Time</label>
                                            <div x-show="isLoadingTimes" class="text-slate-400 text-sm py-2">Loading available times...</div>
                                            <div x-show="!isLoadingTimes && !date" class="text-slate-400 text-sm py-2">Please select a date to see available times.</div>
                                            <div x-show="!isLoadingTimes && date && displayableTimes.length === 0" class="text-slate-400 text-sm py-2">
                                                No available times for this date. Please select another date.
                                            </div>
                                            <div x-show="!isLoadingTimes && date && displayableTimes.length > 0" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3">
                                                <template x-for="slot in displayableTimes" :key="slot">
                                                    <button
                                                        type="button"
                                                        @click="time = slot"
                                                        :class="{
                                                            'bg-blue-600 hover:bg-blue-700 text-white font-semibold ring-2 ring-blue-400 ring-offset-2 ring-offset-slate-800': time === slot,
                                                            'bg-slate-700 hover:bg-slate-600 text-slate-200': time !== slot
                                                        }"
                                                        class="px-3 py-2.5 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-blue-500 transition-colors duration-150 ease-in-out"
                                                    >
                                                        <span x-text="slot"></span>
                                                    </button>
                                                </template>
                                            </div>
                                            <input type="hidden" name="time" :value="time">
                                            @error('time') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </section>

                                <section aria-labelledby="customer-info-heading">
                                    <div class="flex items-center mb-5">
                                        <span class="bg-blue-500 text-white text-xl font-semibold rounded-full h-10 w-10 flex items-center justify-center mr-4 shadow-md">4</span>
                                        <h2 id="customer-info-heading" class="text-xl font-semibold text-slate-100">Contact and Address Information</h2>
                                    </div>
                                    <div class="space-y-6 bg-slate-800 p-5 rounded-lg border border-slate-700">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                                            <div>
                                                <label for="first_name" class="block text-sm font-medium text-slate-300 mb-1">First Name</label>
                                                <input type="text" name="first_name" id="first_name" x-model="first_name" placeholder="e.g., John"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="first_name-error"/>
                                                @error('first_name') <p id="first_name-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="last_name" class="block text-sm font-medium text-slate-300 mb-1">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" x-model="last_name" placeholder="e.g., Smith"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="last_name-error"/>
                                                @error('last_name') <p id="last_name-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                                                <input type="email" name="email" id="email" x-model="email" placeholder="e.g., john.smith@example.com"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="email-error"/>
                                                @error('email') <p id="email-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="phone" class="block text-sm font-medium text-slate-300 mb-1">Phone Number</label>
                                                <input type="text" name="phone" id="phone" x-model="phone" placeholder="e.g., +1 555 123 4567"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="phone-error"/>
                                                @error('phone') <p id="phone-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="street" class="block text-sm font-medium text-slate-300 mb-1">Street Address</label>
                                            <input type="text" name="street" id="street" x-model="street" placeholder="e.g., 123 Main St"
                                                   class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="street-error"/>
                                            @error('street') <p id="street-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
                                            <div>
                                                <label for="city" class="block text-sm font-medium text-slate-300 mb-1">City</label>
                                                <input type="text" name="city" id="city" x-model="city" placeholder="e.g., Springfield"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required aria-describedby="city-error"/>
                                                @error('city') <p id="city-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="state_province" class="block text-sm font-medium text-slate-300 mb-1">State / Province (Optional)</label>
                                                <input type="text" name="state" id="state_province" x-model="state_province" placeholder="e.g., CA"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" aria-describedby="state-error"/>
                                                @error('state') <p id="state-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                            <div>
                                                <label for="postal_code" class="block text-sm font-medium text-slate-300 mb-1">ZIP / Postal Code (Optional)</label>
                                                <input type="text" name="postal_code" id="postal_code" x-model="postal_code" placeholder="e.g., 90210"
                                                       class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" aria-describedby="postal_code-error"/>
                                                @error('postal_code') <p id="postal_code-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <label for="notes" class="block text-sm font-medium text-slate-300 mb-1">Additional Notes (Optional)</label>
                                            <textarea name="notes" id="notes" x-model="notes" rows="3" placeholder="e.g., Gate code is #1234. Please call upon arrival."
                                                      class="w-full bg-slate-700 border-slate-600 text-slate-100 rounded-md shadow-sm px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" aria-describedby="notes-error"></textarea>
                                            @error('notes') <p id="notes-error" class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </section>

                                <div class="pt-6 text-center">
                                    <button
                                        type="submit"
                                        class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-3 px-10 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out text-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-blue-500"
                                    >
                                        Confirm Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>

            <aside class="lg:col-span-1">
                <div class="bg-slate-800 rounded-lg shadow-xl p-6 text-slate-200 sticky top-24 border border-slate-700">
                    <h3 class="text-xl font-semibold mb-6 pb-3 border-b border-slate-700 text-white">Your Appointment Summary</h3>
                    
                    <div x-show="selectedVehicleType" class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Service:</span>
                            <span class="text-right">{{ $service->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Vehicle:</span>
                            <span x-text="selectedVehicleType && vehicleTypeNames[selectedVehicleType] ? vehicleTypeNames[selectedVehicleType] : '---'" class="text-right capitalize"></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Base Price:</span>
                            <span x-text="getFormattedPrice(basePrice)" class="text-right"></span>
                        </div>

                        <div>
                            <span class="font-medium text-slate-400">Extras:</span>
                            <template x-if="extras.length > 0">
                                <ul class="list-none mt-1 pl-1 space-y-0.5">
                                    <template x-for="extraId in extras" :key="extraId">
                                        <li class="flex justify-between">
                                            <span x-text="extraServiceDetails[extraId] && extraServiceDetails[extraId].name ? extraServiceDetails[extraId].name : 'Unknown Extra'" class="text-slate-300 capitalize"></span>
                                            <span x-text="extraServiceDetails[extraId] && typeof extraServiceDetails[extraId].price !== 'undefined' ? '(+ ' + getFormattedPrice(parseFloat(extraServiceDetails[extraId].price)) + ')' : ''" class="text-slate-300"></span>
                                        </li>
                                    </template>
                                </ul>
                            </template>
                            <span x-show="!extras || extras.length === 0" class="text-slate-300 ml-1">None</span>
                        </div>
                        <div class="flex justify-between font-semibold text-lg mt-2 pt-2 border-t border-slate-700">
                            <span class="text-white">Estimated Total Price:</span>
                            <span x-text="getFormattedPrice(totalPrice)" class="text-white"></span>
                        </div>

                        <hr class="border-slate-700 my-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Date:</span>
                            <span x-text="date ? new Date(date.replace(/-/g, '/')).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : '---'" class="text-right"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Time:</span>
                            <span x-text="time || '---'" class="text-right"></span>
                        </div>
                        <hr class="border-slate-700 my-3">
                        <h4 class="font-semibold text-md text-white mt-3 mb-1">Customer Information:</h4>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">First Name:</span>
                            <span x-text="first_name || '---'" class="text-right"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Last Name:</span>
                            <span x-text="last_name || '---'" class="text-right"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Email:</span>
                            <span x-text="email || '---'" class="text-right truncate"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Phone:</span>
                            <span x-text="phone || '---'" class="text-right"></span>
                        </div>
                         <div class="flex justify-between">
                            <span class="font-medium text-slate-400">Address:</span>
                            <span x-text="street || '---'" class="text-right truncate"></span>
                        </div>
                        <div x-show="city" class="flex justify-between">
                            <span class="font-medium text-slate-400">City:</span>
                            <span x-text="city || '---'" class="text-right truncate"></span>
                        </div>
                         <div x-show="state_province" class="flex justify-between">
                            <span class="font-medium text-slate-400">State/Province:</span>
                            <span x-text="state_province || '---'" class="text-right truncate"></span>
                        </div>
                        <div x-show="postal_code" class="flex justify-between">
                            <span class="font-medium text-slate-400">ZIP/Postal Code:</span>
                            <span x-text="postal_code || '---'" class="text-right truncate"></span>
                        </div>
                         <div x-show="notes" class="mt-2">
                            <span class="font-medium text-slate-400">Notes:</span>
                            <p x-text="notes" class="text-slate-300 text-xs whitespace-pre-wrap break-words"></p>
                        </div>
                    </div>

                    <template x-if="!selectedVehicleType">
                         <p class="mt-8 text-center text-slate-400 text-sm bg-slate-700/50 p-3 rounded-md">
                             Complete the form steps to see the detailed summary and price.
                         </p>
                    </template>
                </div>
            </aside>

        </div>
    </div>
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.6) brightness(150%);
        }
        input[type="date"] {
            color-scheme: dark;
        }
    </style>
@endsection