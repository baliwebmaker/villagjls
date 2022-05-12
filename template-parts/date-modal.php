<div 
class="absolute bg-white mt-0 rounded-lg shadow p-4  w-full z-80" 
x-show.transition="datepicker.showDatepicker"
>
<div class="flex flex-col items-center">
    <div class="w-full flex justify-between items-center mb-2">
    
    <div>
        <span x-text="datepicker.MONTH_NAMES[datepicker.month]" class="text-sm font-bold text-gray-800"></span>
        <span x-text="datepicker.year" class="ml-1 text-sm text-gray-600 font-normal"></span>
    </div>

    <div>
        <button 
            type="button"
            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
            @click="if (datepicker.month == 0) {datepicker.year--; datepicker.month=11;} else {datepicker.month--;} datepicker.getNoOfDays()">
            <svg class="h-4 w-4 text-gray-500 inline-flex"  fill="none" viewBox="0 0 20 20" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>  
        </button>        
        <button 
            type="button"
            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" 
            @click="if (datepicker.month == 11) {datepicker.year++; datepicker.month=0;} else {datepicker.month++;} datepicker.getNoOfDays()">
            <svg class="h-4 w-4 text-gray-500 inline-flex"  fill="none" viewBox="0 0 20 20" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>  
        </button>
    </div>            
    </div>
    <div class="w-full flex flex-wrap mb-3 -mx-1">
        <template x-for="(day, index) in datepicker.DAYS" :key="index">    
            <div style="width: 14.26%" class="px-1">
            <div
                x-text="day" 
                class="text-gray-800 font-medium text-center text-xs"
            ></div>
            </div>
        </template>
    </div>
    <div class="flex flex-wrap -mx-1">
        <template x-for="blankday in datepicker.blankdays">
        <div 
        style="width: 14.28%"
        class="text-center border p-1 border-transparent text-sm"   
        ></div>
        </template> 
        <template x-for="(date, dateIndex) in datepicker.no_of_days" :key="dateIndex"> 
            <div style="width: 14.28%" >
                <div
                    @click="datepicker.getDateValue(date, false)"
                    /*@mouseenter="datepicker.getDateValue(date, true)"*/
                    x-text="date"
                    class="p-0 cursor-pointer text-center text-xs leading-loose transition ease-in-out duration-100"
                    :class="{'font-bold': datepicker.isToday(date) == true, 'bg-blue-800 text-white rounded-l-full': datepicker.isDateFrom(date) == true, 'bg-blue-800 text-white rounded-r-full': datepicker.isDateTo(date) == true, 'bg-blue-200': datepicker.isInRange(date) == true }"  
                ></div>
            </div>
        </template>
    </div>
    <div>
        <span class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1" @click="datepicker.unsetDateValues()">Clear</span>
    </div>
    </div>
</div>