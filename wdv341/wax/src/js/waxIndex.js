/*
	waxIndex.js

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
let app = new Vue({
	el: "#home",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			id: 0,
			ajaxError: "",
			inventory: [],
			purchased: []
		};
	},

	methods: {
		FetchAlbums(mode) {
			let userId = new FormData();
			userId.append("id", this.id);

			if (mode === "inventory") {
				this.$http.post("user?mode=inventory", userId).then((response) => {
					this.inventory = response.data;
				}, () => {
					this.ajaxError = "<p class=\"error\">Could not fetch this user's inventory from the server.</p>";
					console.error("Couldn't fetch inventory from user #" + this.id);
				});
			}
			else if (mode === "purchased") {
				this.$http.post("user?mode=purchased", userId).then((response) => {
					this.purchased = response.data;
				}, () => {
					this.ajaxError = "<p class=\"error\">Could not fetch this user's purchased albums from the server.</p>";
					console.error("Couldn't fetch purchased from user #" + this.id);
				});
			}
			else {
				console.error("FetchAlbums() argument error");
			}
		},

		albumhref(i) {
			return "browse?id=" + i;
		},

		nicepurchased(d) {
			let jsDate = new Date(Date.parse(d.replace(/[-]/g,'/')));
			return jsDate.toDateString();
		},

		editbtn(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		},

		deletebtn(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/delete?id=" + i;
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
