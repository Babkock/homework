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
			sent: false,
			message: {
				fullname: "",
				email: "",
				subject: "",
				message: ""
			}
		};
	},

	methods: {
		SubmitMessage() {
			let formData = new FormData();
			formData.append("fullname", this.message.fullname);
			formData.append("email", this.message.email);
			formData.append("subject", this.message.subject);
			formData.append("message", this.message.message);
			this.$http.post("contact", formData).then((response) => {
				this.sent = true;
				this.ajaxResult = response.data;
			}, () => {
				this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
				console.error("Could not send message with name '" + this.message.fullname + "'");
			});
		}
	}
})
