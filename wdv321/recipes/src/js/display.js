/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
require("../css/recipesProject.scss")

import Recipe from "../vue/recipe.vue";
Vue.component('recipe', Recipe)

Vue.mixin({
	data: () => {
		return {
			numberOfRecipes: 1,
			recipes: [
				{
					title: "Chunks of Hunk... Yum",
					image: "shit.jpg",
					serves: 9,
					preparation: new TimeIs("20 minutes"),
					cooking: new TimeIs("15 hours"),
					ingredients: [
						new Ingredient("chili powder", "1", "tbsp", false),
						new Ingredient("cooking oil", 2, "tbsp.", false),
						new Ingredient("onion", 1, "cup", false),
						new Ingredient("chopped peppers", 1, "cup", false),
						new Ingredient("chili powder", 4, "tbsp.", false),
						new Ingredient("hot chili powder", 1, "tsp.", true),
						new Ingredient("Beef or chicken", 1, "lb", false),
						new Ingredient("red beans", 2, "cans", false),
						new Ingredient("kidney beans", 2, "cans", false)
					],
					steps: [
						"Heat cooking oil in 2 quart skillet",
						"Saute onions and peppers for 5 minutes.",
						"Add spices and stir for 30 seconds.",
						"Add meat and cook until browned. Approximately 15 minutes.",
						"Pour contents of skillet into 3 quart crock pot"
					]
				}
			]
		};
	}
})

var app = new Vue({
	el: ".container",

	http: {
		emulateHTTP: true,
		emulateJSON: true
	},

	data: () => {
		return 0;
	},

	methods: {
		LoadObject: function(x) {
			var storage = window.localStorage;
			console.log("Loading recipe " + x);
			var jso = {};
			var object = {};

			if (jso = storage.getItem(x)) {
				object = JSON.parse(jso);

				this.recipes.push(object);
				this.numberOfRecipes++;
			}
			else {
				console.error("Could not load specified recipe '" + x + "' from local storage");
			}
		},

		SaveObject: function(x) {
			var storage = window.localStorage;
			console.log("Saving recipe " + x);
			var obj = JSON.stringify(this.recipes);

			storage.setItem(x, obj);
		}
	},

	mounted() {
		
	}
})