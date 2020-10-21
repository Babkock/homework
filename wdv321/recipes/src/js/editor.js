/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
// require("../../../../assets/js/ingredient.js");

import Ingredient from "../vue/ingredient.vue";
Vue.component('ingredient', Ingredient)

Vue.mixin({
	data: () => {
		return {
			topStatus: "",
			bottomStatus: ""
		};
	},

	methods: {
		/* Store current recipe object using lastStorageItem */
		StoreObject() {
			var storage = window.localStorage;
			console.log("Updating storage object '" + this.lastStorageItem + "'");
			storage.removeItem(this.lastStorageItem);
			storage.setItem(this.lastStorageItem, JSON.stringify(this.recipe));
			console.log(JSON.stringify(this.recipe));
			
			var isInRecipeFiles = false;
			this.recipeFiles.forEach((f, index) => {
				if (f === this.lastStorageItem)
					isInRecipeFiles = true;
			});
			if (!isInRecipeFiles) {
				this.recipeFiles.push(this.lastStorageItem);
			}
			StoreRecipeFiles();
		},

		/* Store current recipe object under new name */
		StoreObjectAs(x) {
			var storage = window.localStorage;
			console.log("Storing object '" + x + "' in local storage");
			storage.setItem(x, JSON.stringify(this.recipe));
			console.log(JSON.stringify(this.recipe));

			this.lastStorageItem = x;
			var isInRecipeFiles = false;
			this.recipeFiles.forEach((f, index) => {
				if (f === this.lastStorageItem)
					isInRecipeFiles = true;
			});
			if (!isInRecipeFiles) {
				this.recipeFiles.push(x);
			}
			this.StoreRecipeFiles();
		},

		LoadObject(x) {
			var storage = window.localStorage;
			console.log("Loading object '" + x + "'");
			var jso = {};
			var object = {};

			if (jso = storage.getItem(x)) {
				object = JSON.parse(jso);

				this.ingredients = object.ingredients.length;
				this.steps = object.steps.length;
				this.lastStorageItem = x;
				
				// more here......

				this.recipe.numberOfIngreds = object.ingredients.length;
				this.recipe.numberOfSteps = object.steps.length;
				this.recipe.title = object.title;
				this.recipe.image = object.image;
				this.recipe.filename = object.filename;
				this.recipe.serves = object.serves;
				this.recipe.difficulty = object.difficulty;
				this.recipe.cooking.quantity = parseInt(object.cooking.quantity);
				this.recipe.cooking.measurement = object.cooking.measurement;
				this.recipe.preparation.quantity = parseInt(object.preparation.quantity);
				this.recipe.preparation.measurement = object.preparation.measurement;
				this.recipe.ingredients = [];

				object.ingredients.forEach((ing, index) => {
					this.recipe.ingredients.push({
						name: ing.name,
						quantity: ing.quantity,
						measurement: ing.measurement,
						opt: ing.opt
					});
					console.log("Pushing ingredient " + index + ": \"" + ing.quantity + " " + ing.measurement + " " + ing.name + "\"");
				});

				this.recipe.steps = [];
				object.steps.forEach((st, index) => {
					this.recipe.steps.push(st);
				});
			}
			else {
				console.error("Could not load specified item '" + x + "' from local storage");
				this.bottomStatus = "<p class=\"error\">Could not load specified file '<b>" + x + "</b>' from local storage.</p>";
			}
		},

		DeleteObject(x) {
			var storage = window.localStorage;
			console.log("Deleting stored recipe object '" + x + "'");
			storage.removeItem(x);
			this.lastStorageItem = "";
		},

		StoreRecipeFiles() {
			var storage = window.localStorage;
			console.log("Saving recipeFiles array");
			storage.setItem("recipeFiles", this.recipeFiles);
		}
	}
})

var app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			recipeFiles: [],		// This is loaded as its own localStorage file. "recipeFiles"
			fileToLoad: "",			// This localStorage item is set on the view.html page
			ingredients: 3,
			steps: 2,
			lastStorageItem: "",
			recipe: {
				numberOfIngreds: 3,
				numberOfSteps: 2,
				title: "",
				image: "",
				filename: "",
				serves: 0,
				difficulty: "",
				preparation: {
					quantity: 25,
					measurement: "minutes"
				},
				cooking: {
					quantity: 6,
					measurement: "hours"
				},
				ingredients: [
					{
						quantity: 1,
						measurement: "",
						name: "",
						opt: "",
					},
					{
						quantity: 1,
						measurement: "",
						name: "",
						opt: "",
					},
					{
						quantity: 1,
						measurement: "",
						name: "",
						opt: "",
					},
				],
				steps: [
					"This is step one",
					"This is step two"
				]
			},
		};
	},
	
	methods: {
		AddIngredient() {
			this.recipe.ingredients.push({
				quantity: 0,
				measurement: "",
				name: "",
				opt: ""
			});
			this.ingredients = parseInt(this.ingredients) + 1;
			this.recipe.numberOfIngreds = parseInt(this.recipe.numberOfIngreds) + 1;
			this.topStatus = "<p class=\"success\">Added ingredient.</p>";
		},

		RemoveIngredient() {
			this.recipe.ingredients.splice(this.ingredients-1, 1);
			this.ingredients = parseInt(this.ingredients) - 1;
			this.recipe.numberOfIngreds = parseInt(this.recipe.numberOfIngreds) - 1;
			this.topStatus = "<p class=\"error\">Removed last ingredient.</p>";
		},

		AddStep() {
			this.recipe.steps.push("");
			this.steps = parseInt(this.steps) + 1;
			this.recipe.numberOfSteps = parseInt(this.recipe.numberOfSteps) + 1;
			this.bottomStatus = "<p class=\"success\">Added step.</p>";
		},

		RemoveStep() {
			this.recipe.steps.splice(this.steps-1, 1);
			this.steps = parseInt(this.steps) - 1;
			this.recipe.numberOfSteps = parseInt(this.recipe.numberOfSteps) - 1;
			this.bottomStatus = "<p class=\"error\">Removed last step.</p>";
		}
	},

	mounted() {
		var storage = window.localStorage;
		var toLoad = storage.getItem("fileToLoad");		// view.html should set this when user clicks a button
		var recipes = storage.getItem("recipeFiles");	// view.html should read this and editor should set this

		if (!toLoad) {
			// prompt if not coming from the view page
			var filename = prompt("Which file would you like to edit? Enter nothing for new file");
		}
		else {
			this.fileToLoad = toLoad;
			var filename = this.fileToLoad;
		}
		if (!recipes) {
			this.recipeFiles.push("hello");
		}
		else {
			this.recipeFiles = recipes;
		}

		if (filename) {
			this.LoadObject(filename);

			this.topStatus = "<p class=\"success\">Loaded file '<b>" + filename + "</b>' from local storage.</p>";

			for (var i = 0; i < this.recipe.ingredients.length; i++) {
				if (!document.querySelector("input#ingred" + i + "_name")) {
					console.error("DEBUG: It's the name that failed");
				}
				else {
					document.querySelector("input#ingred" + i + "_name").value = this.recipe.ingredients[i].name;
				}
				if (!document.querySelector("input#ingred" + i + "_quantity")) {
					console.error("DEBUG: It's the quantity that failed");
				}
				else {
					document.querySelector("input#ingred" + i + "_quantity").value = this.recipe.ingredients[i].quantity;
				}
				if (!document.querySelector("select#ingred" + i + "_measurement")) {
					console.error("DEBUG: It's the measurement that failed");
				}
				else {
					document.querySelector("select#ingred" + i + "_measurement").value = this.recipe.ingredients[i].measurement;
				}
				if (!document.querySelector("input#ingred" + i + "_opt")) {
					console.error("DEBUG: It's the opt that failed");
				}
				else {
					document.querySelector("input#ingred" + i + "_opt").value = this.recipe.ingredients[i].opt;
				}
			}

			/* this.recipe.ingredients.forEach((ing, index) => {
				document.querySelector("input#ingred" + index + "_name").value = ing.name;
				document.querySelector("input#ingred" + index + "_quantity").value = "" + ing.quantity;
				document.querySelector("select#ingred" + index + "_measurement").value = ing.measurement;
				document.querySelector("input#ingred" + index + "_opt").value = ing.opt;
			}); */
		}
		else {
			this.topStatus = "<p class=\"success\">Starting a new recipe.</p>";

			this.recipe.title = "New Recipe Title!";
		}
	}
})