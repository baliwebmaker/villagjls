<form 
    method="post" 
    id="form-reservation" 
    data-nonce="<?php echo wp_create_nonce('submit_reservation_form_nonce');?>"
    @submit.prevent="submitForm"
    x-data="ReservationForm"
>
<!--modal success -->
<?php get_template_part('template-parts/success-modal');?>

<input type="hidden" name="subject" value="Reservation for <?php the_title() ?>" />
<div class="mt-8 max-w-md">
     <div class="grid grid-cols-1 gap-6 text-sm">
        <label class="block">
            <span class="text-gray-700">Full name *</span>
            <input type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm 
            focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            name="fullname" autocomplete="off" placeholder="" x-model="formData.fullname" x-ref="fullname"/>
            <p 
            class="text-xs text-red-600"
            x-text="errors.fullname?'Please fill fullname':''" 
            >
            </p><span class="text-lg font-bold"></span>
        </label>
        <label class="block">
            <span class="text-gray-700">Email address *</span>
            <input type="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 placeholder-gray-400"
                name="email" autocomplete="off"
                placeholder="hello@test.local"
                x-model="formData.email" 
                x-ref="email"
            />
            <p 
            class="text-xs text-red-600"
            x-text="errors.email?'Please fill email':''"
            >
            </p>
        </label>
        <label class="block">
            <span class="text-gray-700">Phone *</span>
            <input type="text"                   
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
             name="phone" placeholder="" x-model="formData.phone" x-ref="phone"/>
            <p 
            class="text-xs text-red-600"
            x-text="errors.phone?'Please fill phone':''"
            >
            </p>
        </label>
        <div class="relative" @keydown.escape="datepicker.closeDatepicker()" @click.away="datepicker.closeDatepicker()">
        <label class="block">
            <span class="text-gray-700">Check IN</span>
            <input type="text"                
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
                name="checkin" autocomplete="off"
                @click="datepicker.endToShow = 'from'; datepicker.initDate(); datepicker.showDatepicker = true" 
                x-model="datepicker.dateFromValue" x-ref="checkin"
                :class="{'font-semibold': datepicker.endToShow == 'from' }"
                />
        </label>
        <p 
          class="text-xs text-red-600"
          x-text="errors.checkin?'Please select date':''"
        >
        </p>
        <label class="block">
            <span class="text-gray-700">Check Out</span>
            <input type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="checkout" autocomplete="off"
                @click="datepicker.endToShow = 'to'; datepicker.initDate(); datepicker.showDatepicker = true" 
                x-model="datepicker.dateToValue" 
                :class="{'font-semibold': datepicker.endToShow == 'to' }"
                />
        </label>
        <?php get_template_part( 'template-parts/date-modal');?>
        </div>
        <label class="block">
            <span class="text-gray-700">Number of guests</span>
            <input type="number" min="0" step="1"             
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                name="number_of_guest" placeholder="" x-model="formData.number_of_guest"/>
        </label>
        <label class="block">
            <span class="text-gray-700">Request</span>
            <textarea                
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm
                focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 placeholder-gray-400"
                rows="6" 
                name="request"
                placeholder="Please advise flight details for airport pick-up, or estimated arrival time at Villa, if travelling with infant(s), and any special requests, eg kid’s equipment / dietary needs / villa set-up."
                x-model="formData.request"
            ></textarea>
        </label>
        <button 
        type="submit" 
        value="Reserve Now"
        class="px-4 py-2 bg-blue-600 shadow-lg border rounded-lg text-white uppercase text-sm tracking-wider focus:outline-none focus:shadow-outline hover:bg-blue-800 active:bg-blue-400"
        x-text="buttonLabel" 
        :disabled="loading"
        >
        </button>
    </div>
</div>
</form>