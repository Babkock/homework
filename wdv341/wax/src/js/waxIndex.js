/*
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
			inventory: "",
			purchased: ""
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
					this.inventory = "<p class=\"error\">Could not fetch this user's inventory from the server.</p>";
				});
			}
			else if (mode === "purchased") {
				this.$http.post("user?mode=purchased", userId).then((response) => {
					this.purchased = response.data;
				}, () => {
					this.purchased = "<p class=\"error\">Could not fetch this user's purchased albums from the server.</p>";
				});
			}
			else {
				console.log("FetchAlbums() argument error");
			}
		},

		albumhref(id) {
			return "browse?b=" + id;
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
