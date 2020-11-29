/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
let app = new Vue({
	el: "#register",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			userinfo: {
				username: "",
				password: "",
				password2: "",
				email: "",
				country: ""
			},
			ajaxResult: ""
		};
	},

	methods: {
		Register() {
			let form_data = new FormData();
			form_data.append("username", this.userinfo.username);
			form_data.append("password", this.userinfo.password);
			form_data.append("password2", this.userinfo.password2);
			form_data.append("email", this.userinfo.email);
			form_data.append("country", this.userinfo.country);

			this.$http.post("register", form_data).then((response) => {
				this.ajaxResult = response.data;
			}, () => {
				this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
			});
		}
	}
})
