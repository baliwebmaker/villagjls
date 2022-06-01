'use strict';

window.ReservationForm  = function () {
	
	const formReservation = document.getElementById('form-reservation');
	let nonce = formReservation.dataset.nonce;
	let fields = ['fullname','email','phone','checkin','checkout','number_of_guest','request'];
	let datepicker = new datePicker();
	
	let captcha = document.getElementById('recaptchaToken');

	grecaptcha.ready(() => {
		grecaptcha.execute('6Ld0SAEgAAAAACz-EBJRejBqSgXZnVNo768gX5Lo', {action: 'submit_reservation_form'})
		.then((token) => {
			this.$refs.recaptchaToken.value = token;
		});
		// refresh token every minute to prevent expiration
		setInterval(() => {
		grecaptcha.execute('6Ld0SAEgAAAAACz-EBJRejBqSgXZnVNo768gX5Lo', {action: 'submit_reservation_form'})
		.then((token) => {
			this.$refs.recaptchaToken.value = token;
		});
		}, 60000);
	});

	return {

	   	buttonLabel: 'Submit',
	   	loading: false,
	   	status: false,

	   	modalHeaderText:'',
	   	modalBodyText:'',

	   	datepicker,

	   	//create formdata objects from array fields
	   	formData: Object.assign({}, ...Object.entries({...fields}).map(([a,b]) => ({ [b]: '' }))),

	   	//create errors objects from array fields
       	errors : Object.assign({}, ...Object.entries({...fields}).map(([a,b]) => ({ [b]: false }))),

       	isEmail(email){
        	const rgx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        	return rgx.test(email);
       	},

       	validation(q,w){
        	var validate=false;
        	if (!q){
        		this.errors[w] = true;
        		this.$refs[w].scrollIntoView();
        		validate=true;
        	}else{
        		this.errors[w]= false;
        	}
        	return validate;
       	},
		submitForm() {  
			//compensate height of reservation when error messages display
			this.$refs.reservation.style.maxHeight = '100%';

			//validations
			if(
				this.validation(this.formData.fullname.length>0, 'fullname')||
				this.validation(this.isEmail(this.formData.email), 'email')||
				this.validation(this.formData.phone.length > 0, 'phone')||
				this.validation(this.datepicker.dateFromValue.length > 0, 'checkin')
			){ return; }
 
			this.formData.checkin = this.datepicker.dateFromValue;
			this.formData.checkout = this.datepicker.dateToValue;

			this.buttonLabel = 'Submitting...';
    		this.loading = true;

			fetch( SiteParameters.ajax_url, {
	            method: "POST",
	            headers: { 
	            	'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8',
	            	'Cache-Control': 'no-cache',
	            	'Accept': 'application/json' 
	            },
	            credentials: 'same-origin',
	            body: 'action=submit_reservation_form&nonce='+ nonce +'&formdata='+ JSON.stringify( this.formData )+'&captcha='+captcha.value ,
	        })
	        .then( async (response) => {
                let data = await response.json(); console.log(data);

                if (data.status == 'true') {
                	this.$nextTick(() => {
                		//scroll up reservation form container
                		this.$refs.reservationbutton.dispatchEvent(new Event("click"));
                		this.status = true;
                		this.modalHeaderText = "Thank You!";
                		this.modalBodyText = "Your form have been successfully submited!";
                	});
                 } else {
                 	throw new Error("Your registration failed");
                 }
                 //clear forms data after form submitted
                 Object.keys(this.formData).forEach(key => this.formData[key]='');
                 //clear submitted date picker
                 this.datepicker.unsetDateValues();
                		 
            })
	        .catch((err) => {
	        	alert(err);
	        })
	        .finally(() => {
	        	this.loading = false;
            	this.buttonLabel = 'Submit'
            	this.status = false;
            	document.getElementById("form-reservation").reset();
	        });        
	    },
	}
}