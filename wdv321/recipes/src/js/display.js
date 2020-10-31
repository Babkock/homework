/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
require("../css/recipesProject.scss")
require("../css/mobile.scss")
require("../css/landscape.scss")

import Recipe from "../vue/recipe.vue";
Vue.component('recipe', Recipe)

/* The big comment block is a default recipe object for testing purposes */
Vue.mixin({
	data: () => {
		return {
			numberOfRecipes: 1,
			recipes: [ /*
				{
					title: "Chunks of Hunk... Yum",
					image: "img/pizza.jpg",
					serves: 9,
					difficulty: "Hard",
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
				} */
			],
			recipeFiles: []
		};
	},

	methods: {
		DifficultyStyle(diff) {
			var out = "";
			switch (diff) {
				case "Easy": case "easy":
					out = "<span class=\"easy\">Easy</span>";
					break;
				case "Medium": case "medium":
					out = "<span class=\"medium\">Medium</span>";
					break;
				case "Hard": case "hard":
					out = "<span class=\"hard\">Hard</span>";
					break;
				default:
					out = diff;
					break;
			}
			return out;
		}
	}
})

var app = new Vue({
	el: ".container",

	data: () => {
		return 0;
	},

	methods: {
		/* Load a recipe object from storage with filename 'x' */
		LoadObject(x) {
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
		}
	},

	mounted() {
		var storage = window.localStorage;
		var rfiles = JSON.parse(storage.getItem("recipeFiles"));

		this.recipeFiles = rfiles;
		this.recipeFiles.forEach((el, index) => {
			this.LoadObject(el);
		});
	}
})