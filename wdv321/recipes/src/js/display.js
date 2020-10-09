/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
require('./ingredient.js');

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
			recipes: [
				{
					numberOfIngreds: 3,
					numberOfSteps: 3,
					name: "",
					image: "",
					serves: 0,
					difficulty: "",
					preparation: {
						quantity: "25",
						measurement: "minutes"
					},
					cooking: {
						quantity: "6",
						measurement: "hours"
					},
					ingredients: [
						{
							quantity: "",
							measurement: "",
							name: "",
							opt: "",
						},
						{
							quantity: "",
							measurement: "",
							name: "",
							opt: "",
						},
						{
							quantity: "",
							measurement: "",
							name: "",
							opt: "",
						}
					],
					steps: [
						"This is step one",
						"This is step two"
					]
				}
			],
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

				this.ingredients = object.numberOfIngreds;
				this.steps = object.numberOfSteps;
				this.lastStorageItem = x;
				this.recipes = [];
				this.recipes[0] = object;
			}
			else {
				console.error("Could not load specified item " + x + " from local storage");
			}
		},
	},

	mounted() {
		console.log(this.test);
	}
})