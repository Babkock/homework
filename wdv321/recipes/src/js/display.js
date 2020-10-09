/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
import Recipe from "../vue/recipe.vue";
Vue.component('recipe', Recipe);

var app = new Vue({
	el: "#displaySlider",

	http: {
		emulateHTTP: true,
		emulateJSON: true
	},

	data: () => {
		return {
			numberOfRecipes: 0,
			recipes: [],
			ajaxResult: ""
		};
	},

	methods: {
		LoadObject: function(x) {
			var storage = window.localStorage;
			console.log("Loading object " + x);
			var jso = {};
			var object = {};

			if (jso = storage.getItem(x)) {
				object = JSON.parse(jso);

				this.recipes.push(object);
				this.numberOfRecipes++;
			}
			else {
				console.error("Could not load specified item " + x + " from local storage");
			}
		},
	},

	mounted() {
		
	}
})