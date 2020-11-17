/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
require("../css/waxchange.scss")

import Album from "../vue/album.vue";
Vue.component('album', Album)

var app = Vue.app({
	el: "#account",

})
