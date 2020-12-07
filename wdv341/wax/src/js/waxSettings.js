/*
	waxSettings.js

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
let app = new Vue({
	el: "#settings",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			id: 0,
			file: false,
			saved: false,
			userinfo: {
				oldpassword: "",
				newpassword: "",
				newpassword2: "",
				country: "{{COUNTRY}}",
				showemail: "{{SHOWEMAIL}}",
				biography: "{{BIOGRAPHY}}"
			},
			ajaxResult: ""
		};
	},

	methods: {
		SubmitSettings() {
			if (this.file) {
				this.ajaxResult = "<p class=\"success\">Your new avatar is being uploaded...</p>";
			}
			else {
				this.ajaxResult = "<p class=\"success\">Your preferences are being saved...</p>";
			}
			if ((this.userinfo.newpassword.length > 0) && (this.userinfo.newpassword !== this.userinfo.newpassword2)) {
				this.ajaxResult = "<p class=\"error\">The two passwords do not match.</p>";
			}
			else {
				let formData = new FormData();

				if (this.file) {
					formData.append("image", this.$refs.image.files[0]);
				}
				formData.append("oldpassword", this.oldpassword);
				formData.append("newpassword", this.newpassword);
				formData.append("country", this.country);
				if (this.showemail === "one")
					formData.append("showemail", 1);
				else if (this.showemail === "two")
					formData.append("showemail", 2);
				else if (this.showemail === "three")
					formData.append("showemail", 3);
				
				formData.append("biography", this.biography);
				this.$http.post("settings", formData).then((response) => {
					this.ajaxResult = response.data;
					this.saved = true;
				}, () => {
					this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
				});
			}
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
	}
})
