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
		Register() {
			if (this.userinfo.password !== this.password2) {
				this.ajaxResult = "<p class=\"error\">The two passwords do not match.</p>";
			}
			let form_data = new FormData();
			form_data.append("username", this.userinfo.username);
			form_data.append("password", this.userinfo.password);
			form_data.append("email", this.userinfo.email);
			form_data.append("country", this.userinfo.country);

			this.$http.post("register", form_data).then((response) => {
				this.ajaxResult = response.data;
				document.querySelector(".go").disabled = true;
			}, () => {
				this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
			});
		}
	},

	mounted() {

	}
})
