/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
var app = new Vue({
	el: ".container",

	data: () => {
		return {
			status: "",
			recipeFiles: [],
			fileToLoad: ""
		};
	},

	methods: {
		/* Prep the Recipe Editor for a new recipe */
		NewRecipe() {
			var storage = window.localStorage;
			storage.removeItem("fileToLoad");

			this.status = "<p class=\"success\">Starting new recipe...</p>";

			window.location = "https://tannerbabcock.com/homework/wdv321/recipes/edit.html";
		},

		/* Open filename 'r' in the Recipe Editor */
		OpenEditor(r) {
			var storage = window.localStorage;
			storage.setItem("fileToLoad", r);

			this.status = "<p class=\"success\">Loading recipe <b>" + r + "</b>...</p>";

			window.location = "https://tannerbabcock.com/homework/wdv321/recipes/edit.html";
		},

		/* Delete recipe object 'x' from local storage */
		DeleteObject(x) {
			var storage = window.localStorage;
			console.log("Deleting stored recipe object '" + x + "'");
			storage.removeItem(x);

			this.status = "<p class=\"error\">Deleted recipe <b>" + x + "</b> successfully.</p>";
			this.recipeFiles.splice(this.recipeFiles.indexOf(x), 1);
			storage.setItem("recipeFiles", JSON.stringify(this.recipeFiles));

			console.log(JSON.stringify(this.recipeFiles));
		},

		/* Delete all recipes in local storage */
		DeleteAll() {
			var storage = window.localStorage;
			console.log("Deleting all recipes stored in local storage");
			storage.removeItem("fileToLoad");

			this.status = "<p class=\"error\">Well shit. You deleted all of the recipes.</p>";

			var recipefiles = storage.getItem("recipeFiles");
			recipefiles.forEach((el) => {
				storage.removeItem(el);
			});
			storage.removeItem("recipeFiles");

			this.fileToLoad = "";
			this.recipeFiles = [];
		}
	},

	mounted() {
		var storage = window.localStorage;
		var toLoad = storage.getItem("fileToLoad");
		var recipes = storage.getItem("recipeFiles");

		if (!recipes) {
			console.log("No recipeFiles detected, creating new one");
			this.recipeFiles = ["hello"];
		}
		else {
			console.log("recipeFiles detected");
			this.recipeFiles = JSON.parse(recipes);
		}
		if (toLoad) {
			storage.removeItem("fileToLoad");
		}
	}
});