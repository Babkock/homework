/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
var app = new Vue({
	el: "#register",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			password2: "",
			userinfo: {
				username: "",
				password: "",
				email: "",
				country: ""
			},
			ajaxResult: ""
		};
	},

	methods: {
		submitForm() {

		}
	},

	mounted() {

	}
})
