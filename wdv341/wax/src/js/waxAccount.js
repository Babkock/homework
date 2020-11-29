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

let app = new Vue({
	el: "#account",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			id: 0,
			inventoryAjax: "",
			purchasedAjax: ""
		};
	},

	methods: {
		FetchAlbums(mode) {
			let userId = new FormData();
			userId.append("id", this.id);

			if (mode === "inventory") {
				this.$http.post("user?mode=inventory", userId).then((response) => {
					this.inventoryAjax = response.text;
					console.log(this.inventoryAjax);
				}, () => {
					this.inventoryAjax = "<p class=\"error\">Could not fetch this user's inventory from the server.</p>";
				});
			}
			else if (mode === "purchased") {
				this.$http.post("user?mode=purchased", userId).then((response) => {
					this.purchasedAjax = response.text;
					console.log(this.purchasedAjax);
				}, () => {
					this.purchasedAjax = "<p class=\"error\">Could not fetch this user's purchased albums from the server.</p>";
				});
			}
			else {
				console.log("FetchAlbums() argument error");
			}
		}
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
