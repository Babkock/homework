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
		BuyAlbum(id) {
			// what happens when the album is bought?
		}
	}
})

var app = new Vue({
	el: "#account",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			id: 0,
			inventoryAlbums: [],
			purchasedAlbums: [],
			ajaxError: ""
		};
	},

	methods: {
		FetchAlbums(mode) {
			let userId = new FormData();
			userId.append("id", this.id);

			if (mode === "inventory") {
				this.$http.post("user?mode=inventory", userId).then((response) => {
					this.inventoryAlbums = JSON.parse(response.data);
				}, () => {
					this.inventoryAlbums = [];
					this.ajaxError = "<p class=\"error\">Could not fetch this user's inventory from the server.</p>";
				});
			}
			else if (mode === "purchased") {
				this.$http.post("user?mode=purchased", userId).then((response) => {
					this.purchasedAlbums = JSON.parse(response.data);
				}, () => {
					this.purchasedAlbums = [];
					this.ajaxError = "<p class=\"error\">Could not fetch this user's purchased albums from the server.</p>";
				});
			}
			else {
				this.ajaxError = "<p class=\"error\">Invalid argument supplied to FetchAlbums().</p>";
			}
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
