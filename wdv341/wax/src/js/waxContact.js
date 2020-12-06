/*
	waxContact.js

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
let app = new Vue({
	el: "#contact",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			ajaxResult: "",
			info: {
				fullname: "",
				email: "",
				subject: "",
				message: ""
			}
		};
	},

	methods: {
		
	}
})
