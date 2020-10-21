var app = new Vue({
	el: ".container",

	data: () => {
		return {
			recipeFiles: [],
			fileToLoad: ""
		};
	},

	methods: {
		OpenEditor(r) {
			var storage = window.localStorage;

			storage.setItem("fileToLoad", r);

			window.location = "https://tannerbabcock.com/homework/wdv321/recipes/edit.html";
		},

		DeleteObject(x) {
			var storage = window.localStorage;
			console.log("Deleting stored recipe object '" + x + "'");
			storage.removeItem(x);
			// this should remove the entry specified in x from recipeFiles

			this.recipeFiles.splice(this.recipeFiles.indexOf(x), 1);
		},

		DeleteAll() {
			var storage = window.localStorage;
			console.log("Deleting all recipes stored in local storage");
			storage.removeItem("fileToLoad");
			this.fileToLoad = "";

			this.recipeFiles.forEach((el, index) => {
				this.DeleteObject(el);
			});

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