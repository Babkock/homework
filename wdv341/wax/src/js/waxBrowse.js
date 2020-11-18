/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import Album from "../vue/album.vue";
Vue.component('album', Album)

var app = new Vue({
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