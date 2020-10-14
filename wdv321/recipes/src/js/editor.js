/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/

import Ingredient from "../vue/ingredient.vue";
Vue.component('ingredient', Ingredient)

Vue.mixin({
	data: () => {
		return {
			recipeFiles: ["test", "hello", "world"],
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
		/* Store current recipe object using lastStorageItem */
		StoreObject() {
			var storage = window.localStorage;
			console.log("Updating storage object '" + this.lastStorageItem + "'");
			storage.removeItem(this.lastStorageItem);
			storage.setItem(this.lastStorageItem, JSON.stringify(this.recipe));
		},

		/* Store current recipe object under new name */
		StoreObjectAs(x) {
			var storage = window.localStorage;
			console.log("Storing object '" + x + "' in local storage");
			storage.setItem(x, JSON.stringify(this.recipe));

			this.lastStorageItem = x;
			this.recipeFiles.push(x);
			storage.setItem("recipeFiles", this.recipeFiles);
		},

		LoadObject(x) {
			var storage = window.localStorage;
			console.log("Loading object " + x);
			var jso = {};
			var object = {};

			if (jso = storage.getItem(x)) {
				object = JSON.parse(jso);

				this.ingredients = object.numberOfIngreds;
				this.steps = object.numberOfSteps;
				this.lastStorageItem = x;
				this.recipe = object;
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
			ajaxResult: ""
		};
	},
	
	methods: {
		AddIngredient() {
			this.recipe.ingredients.push({
				quantity: "",
				measurement: "",
				name: "",
				opt: ""
			});
			this.ingredients++;
			this.recipe.numberOfIngreds++;
		},

		RemoveIngredient() {
			this.recipe.ingredients.splice(this.ingredients-1, 1);
			this.ingredients--;
			this.recipe.numberOfIngreds--;
		},

		AddStep() {
			this.recipe.steps.push("Enter your next step here");
			this.steps++;
			this.recipe.numberOfSteps++;
		},

		RemoveStep() {
			this.recipe.steps.splice(this.steps-1, 1);
			this.steps--;
			this.recipe.numberOfSteps--;
		},

		editurl(x) {
			return "edit?fname=" + x;
		}
	},

	mounted() {
		var storage = window.localStorage;
		this.recipeFiles = storage.getItem("recipeFiles");
		if (!this.recipeFiles) {
			console.error("Could not load recipeFiles");
		}
	}
})