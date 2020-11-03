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
			fileToView: "",
			recipeFiles: [],
			recipeInitialQuantities: [],
			initialServes: 1,
			initialCooktime: 1,
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
			]
		};
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
		},

		/* Reset the Recipe viewer to show all recipes */
		ViewAllRecipes() {
			var storage = window.localStorage;
			storage.removeItem("fileToView");

			location.reload();
		},

		/* Show only a single recipe, 'x' */
		ViewRecipe(x) {
			this.fileToView = x;
			var storage = window.localStorage;

			storage.setItem("fileToView", x);
			location.reload();
		},

		/* Style the difficulty text based on difficulty 'diff' */
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
		},

		/* Adjust the quantities of ingredients based on user selecting "Half" or "Double" button */
		QuantAdjust(i) {
			if (i == 0) {		/* normal */
				this.recipes[0].ingredients.forEach((ing, index) => {
					ing.quantity = this.recipeInitialQuantities[index];
				});
				this.recipes[0].serves = this.initialServes;
				this.recipes[0].cooking.quantity = this.initialCooktime;
			}

			else if (i == 1) {	/* half */
				this.recipes[0].ingredients.forEach((ing, index) => {
					ing.quantity = this.recipeInitialQuantities[index] / 2;
				});
				this.recipes[0].serves = parseInt(this.initialServes / 2);
				this.recipes[0].cooking.quantity = parseInt(this.initialCooktime / 2);
			}
			
			else if (i == 2) {	/* double */
				this.recipes[0].ingredients.forEach((ing, index) => {
					ing.quantity = this.recipeInitialQuantities[index] * 2;
				});
				this.recipes[0].serves = parseInt(this.initialServes * 2);
				this.recipes[0].cooking.quantity = parseInt(this.initialCooktime * 2);
			}
		},

		/* Open the filename 'r' in the Recipe Editor */
		OpenEditor(r) {
			var storage = window.localStorage;
			storage.setItem("fileToLoad", r);

			window.location = "https://tannerbabcock.com/homework/wdv321/recipes/edit.html";
		}
	},

	mounted() {
		var storage = window.localStorage;
		var file = storage.getItem("fileToView");

		if (file) {
			this.LoadObject(file);
			this.fileToView = file;
			this.recipeInitialQuantities = [];

			this.recipes[0].ingredients.forEach((ing) => {
				this.recipeInitialQuantities.push(ing.quantity);
			});

			this.initialServes = this.recipes[0].serves;
			this.initialCooktime = this.recipes[0].cooking.quantity;
		}
		else {
			var rfiles = JSON.parse(storage.getItem("recipeFiles"));

			this.recipeFiles = rfiles;
			this.recipeFiles.forEach((f) => {
				this.LoadObject(f);
			});

			this.recipeInitialQuantities = [];

			// we won't be using these next two for the present page, but set them just in case
			this.initialServes = this.recipes[0].serves;
			this.initialCooktime = this.recipes[0].cooking.quantity;
		}
	}
})