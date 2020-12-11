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

		AlbumHref(i) {
			return "browse?id=" + i;
		},

		NicePurchased(d) {
			let jsDate = new Date(Date.parse(d.replace(/[-]/g,'/')));
			return jsDate.toDateString();
		},

		EditBtn(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/album?id=" + i;
		},

		DeleteBtn(i) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/delete?id=" + i;
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
	},

	mounted() {
		this.id = parseInt(document.querySelector("#userid").value);
		this.FetchAlbums("inventory");
		this.FetchAlbums("purchased");
	}
})
