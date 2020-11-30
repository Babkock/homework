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
			let formData = new FormData();
			formData.append("username", this.userinfo.username);
			formData.append("password", this.userinfo.password);
			formData.append("password2", this.userinfo.password2);
			formData.append("email", this.userinfo.email);
			formData.append("country", this.userinfo.country);

			this.$http.post("register", formData).then((response) => {
				this.ajaxResult = response.data;
			}, () => {
				this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
			});
		}
	}
})
