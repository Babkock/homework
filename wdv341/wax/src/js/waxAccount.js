/*
	waxAccount.js

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require("../css/waxchange.scss");
require("../css/waxMobile.scss");
require("../css/waxLandscape.scss");

import Album from "../vue/album.vue";
Vue.component('album', Album)

Vue.mixin({
	methods: {
		BuyAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/buy?id=" + i;
		},

		EditAlbum(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		},
		
		Register() {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/register";
		},

		AlbumHref(i) {
			return "browse?id=" + i;
		},

		ConditionExpand(cond) {
			let co = "";
			switch (cond.toLowerCase()) {
				case "m":
					co = "Mint";
					break;
				case "nm":
					co = "Near Mint";
					break;
				case "vg":
					co = "Very Good";
					break;
				case "g":
					co = "Good";
					break;
				case "f":
					co = "Fair";
					break;
				case "p":
					co = "Poor";
					break;
			}
			return co;
		},

		CurrencySymbol(c) {
			let cu = "";
			switch (c.toLowerCase()) {
				case "usd": case "cad": case "aud": case "mxn":
					cu = "$";
					break;
				case "gbp":
					cu = "&pound;";
					break;
				case "eur":
					cu = "&euro;";
					break;
				case "rub":
					cu = "&#x20bd;";
					break;
				case "dkk": case "sek": case "isk": case "nok":
					cu = "kr.";
					break;
				case "chf":
					cu = "CHF";
					break;
				case "jpy": case "cny":
					cu = "&yen;";
					break;
				case "ang":
					cu = "&fnof;";
					break;
				case "krw":
					cu = "&#8361;";
					break;
				case "pln":
					cu = "z&lstrok;";
					break;
				default:
					cu = "?";
					break;
			}
			return cu;
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
			purchased: [],
			sold: []
		};
	},

	methods: {
		FetchAlbums(mode) {
			let userId = new FormData();
			userId.append("id", this.id);

			if (mode === "sold") {
				this.$http.post("user?mode=sold", userId).then((response) => {
					this.sold = response.data;
				}, () => {
					this.ajaxError = "<p class=\"error\">Could not fetch this user's sold albums from the server.</p>";
					console.error("Couldn't fetch sold albums for user #" + this.id);
				});
			}
			else if (mode === "inventory") {
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
		this.FetchAlbums("sold");
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
