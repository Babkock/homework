/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/

var app = new Vue({
	el: "#home",

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
		FetchAlbum(mode) {

		}
	},

	mounted() {
		
	}
})
