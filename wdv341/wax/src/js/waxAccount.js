/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require("../css/waxchange.scss")

import Album from "../vue/album.vue";
Vue.component('album', Album)

Vue.mixin({
	methods: {
		BuyAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/buy?id=" + i;
		},

		EditAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		}
	}
})

let app = new Vue({
	el: "#account",

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
					console.error("Couldn't fetch inventory for user #" + this.id);
				});
			}
			else if (mode === "purchased") {
				this.$http.post("user?mode=purchased", userId).then((response) => {
					this.purchased = response.data;
				}, () => {
					this.ajaxError = "<p class=\"error\">Could not fetch this user's purchased albums from the server.</p>";
					console.error("Couldn't fetch purchased for user #" + this.id);
				});
			}
			else {
				console.error("FetchAlbums() argument error");
			}
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
