/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import Album from "../vue/album.vue";
Vue.component('album', Album)

Vue.mixin({
	methods: {
		BuyAlbum(id) {
			window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/buy?id=" + id;
		}
	}
})

let app = new Vue({
	el: "#browse",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		
	},

	methods: {

	}
})