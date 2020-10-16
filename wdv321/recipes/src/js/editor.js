/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/

import Ingredient from "../vue/ingredient.vue";
Vue.component('ingredient', Ingredient)

Vue.mixin({
	methods: {
		/* Store current recipe object using lastStorageItem */
		StoreObject() {
			var storage = window.localStorage;
			console.log("Updating storage object '" + this.lastStorageItem + "'");
			storage.removeItem(this.lastStorageItem);
			storage.setItem(this.lastStorageItem, JSON.stringify(this.recipe));
			console.log(JSON.stringify(this.recipe));
		},

		/* Store current recipe object under new name */
		StoreObjectAs(x) {
			var storage = window.localStorage;
			console.log("Storing object '" + x + "' in local storage");
			storage.setItem(x, JSON.stringify(this.recipe));
			console.log(JSON.stringify(this.recipe));

			this.lastStorageItem = x;
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
					this.recipe.ingredients.push(new Ingredient(ing.name, ing.quantity, ing.measurement, ing.opt));
				});

				this.recipe.steps = [];
				object.steps.forEach((st, index) => {
					this.recipe.steps.push(st);
				});
			}
			else {
				console.error("Could not load specified item '" + x + "' from local storage");
			}
		},

		DeleteObject(x) {
			var storage = window.localStorage;
			console.log("Deleting stored recipe object '" + x + "'");
			storage.removeItem(x);
			this.lastStorageItem = "";
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
			ajaxResult: "",
			ingredients: 3,
			steps: 3,
			lastStorageItem: "",
			recipe: {
				numberOfIngreds: 3,
				numberOfSteps: 3,
				title: "",
				image: "",
				filename: "test",
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
			this.recipe.numberOfIngreds = parseInt(this.recipe.numberOfIngreds);
		},

		RemoveIngredient() {
			this.recipe.ingredients.splice(this.ingredients-1, 1);
			this.ingredients = parseInt(this.ingredients) - 1;
			this.recipe.numberOfIngreds = parseInt(this.recipe.numberOfIngreds) - 1;
		},

		AddStep() {
			this.recipe.steps.push("");
			this.steps = parseInt(this.steps) + 1;
			this.recipe.numberOfSteps = parseInt(this.recipe.numberOfSteps) + 1;
		},

		RemoveStep() {
			this.recipe.steps.splice(this.steps-1, 1);
			this.steps = parseInt(this.steps) - 1;
			this.recipe.numberOfSteps = parseInt(this.recipe.numberOfSteps) - 1;
		}
	},

	mounted() {		
		var filename = prompt("Which file would you like to edit? Enter nothing for new file");

		if (filename) {
			this.LoadObject(filename);
		}
		else {
			this.recipe.title = "New Recipe Title!";
		}
	}
})