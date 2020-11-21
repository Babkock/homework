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
			if (this.userinfo.password !== this.password2) {
				this.ajaxResult = "<p class=\"error\">The two passwords do not match.</p>";
			}
		}
	},

	mounted() {

	}
})
