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
					name: "Test Recipe Hellow",
					image: "../../wdv341/productImages/flashDrive.jpg",
					serves: 0,
					difficulty: "",
					preparation: new TimeIs("25", "minutes"),
					cooking: new TimeIs("6", "hours"),
					ingredients: [
						new Ingredient("chili powder", 2, "cups", false),
						new Ingredient("sugar", 9, "gallons", false)
					/*
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
					*/
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