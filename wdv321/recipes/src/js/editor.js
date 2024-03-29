/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
import Ingredient from "../vue/ingredient.vue";
Vue.component('ingredient', Ingredient)

/* Global data and methods for the entire Vue app. Can be accessed from
   components and the initial HTML itself. */
Vue.mixin({
	data: () => {
		return {
			topStatus: "",
			bottomStatus: ""
		};
	}
})

/* This is the actual editor Vue instance. Please note that the initial values for "ingredients", "steps",
   "numberOfIngreds", etc. must actually match the amount of objects and strings, respectively in those
   properties */
var app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	/* Global data for the application. This is passed to Ingredient components through their
	   "props" arrays (attributes) defined in the .vue files. These components then can update
	   these properties by firing events with the $emit() function. The component's markup in the
	   HTML, therefore, must have corresponding event listeners as attributes. */
	/*
	   ______________________________________________________________________
	   |                                     |                              |
	   |  In the component template          |  In the actual HTML response |
	   |-------------------------------------|------------------------------|
	   | $emit('input1', $event.target.value)| @input1="myfield = $event"   |
	   |_____________________________________|______________________________|
	*/
	data: () => {
		return {
			recipeFiles: [],		// This is loaded as its own localStorage file. "recipeFiles"
			fileToLoad: "",			// This localStorage item is set on the view.html page
			ingredients: 3,
			steps: 2,
			showingIngreds: false,
			showingSteps: false,
			saved: false,
			uploaded: false,
			file: false,
			ingredsButton: "Show Ingredients",
			stepsButton: "Show Steps",
			editingText: "Editing",
			imageFilename: "",
			lastStorageItem: "",
			ajaxResult: "",
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
	
	/* Button handlers */
	methods: {
		/* Add a new, empty ingredient to the Recipe */
		AddIngredient() {
			this.recipe.ingredients.push({
				quantity: 0,
				measurement: "",
				name: "",
				opt: ""
			});
			this.ingredients++;
			this.recipe.numberOfIngreds++;
			this.topStatus = "<p class=\"success\">Added ingredient.</p>";
		},

		/* Remove the last ingredient from the Recipe */
		RemoveIngredient() {
			this.recipe.ingredients.splice(this.ingredients-1, 1);
			this.ingredients--;
			this.recipe.numberOfIngreds--;

			this.topStatus = "<p class=\"error\">Removed last ingredient.</p>";
		},

		/* Add a step to the Recipe instructions */
		AddStep() {
			this.recipe.steps.push("");
			this.steps++;
			this.recipe.numberOfSteps++;
			this.bottomStatus = "<p class=\"success\">Added step.</p>";
		},

		/* Remove the last step from the Recipe instructions */
		RemoveStep() {
			this.recipe.steps.splice(this.steps-1, 1);
			this.steps--;
			this.recipe.numberOfSteps--;
			this.bottomStatus = "<p class=\"error\">Removed last step.</p>";
		},

		/* Show or hide list of ingredients */
		ToggleIngreds() {
			this.showingIngreds = ((this.showingIngreds === true) ? false : true);
			this.ingredsButton = ((this.showingIngreds === true) ? "Hide Ingredients" : "Show Ingredients");
		},

		/* Show or hide list of steps */
		ToggleSteps() {
			this.showingSteps = ((this.showingSteps === true) ? false : true);
			this.stepsButton = ((this.showingSteps === true) ? "Hide Steps" : "Show Steps");
		},

		/* ---- from the mixin ---- */
		/* Store current recipe object using lastStorageItem */
		StoreObject() {
			var storage = window.localStorage;
			var go = true;

			this.recipe.ingredients.forEach((ing) => {
				if ((ing.name.length < 2) || (ing.measurement === "") || (ing.quantity < 1)) {
					this.bottomStatus = "<p class=\"error\">One or more fields in the Ingredients list is empty.</p>";
					this.saved = false;
					go = false;
				}
			});
			this.recipe.steps.forEach((st) => {
				if ((st.length < 2) || (st === "")) {
					this.bottomStatus = "<p class=\"error\">One or more steps in the Instructions list is empty.</p>";
					this.saved = false;
					go = false;
				}
			});

			if (go) {
				if ((this.recipe.serves <= 0) || (this.recipe.cooking.quantity <= 0) || (this.recipe.preparation.quantity <= 0) || (this.recipe.ingredients[0].quantity <= 0)) {
					this.bottomStatus = "<p class=\"error\">Sorry, no negative numbers please.</p>";
					this.saved = false;
				}
				else {
					this.recipe.ingredients.forEach((ing) => {
						ing.opt = ((ing.opt === "yes") ? true : false);
					});

					storage.removeItem(this.lastStorageItem);
					storage.setItem(this.lastStorageItem, JSON.stringify(this.recipe));
					console.log(JSON.stringify(this.recipe));
					
					var isInRecipeFiles = false;
					this.recipeFiles.forEach((f) => {
						if (f === this.lastStorageItem)
							isInRecipeFiles = true;
					});
					if (!isInRecipeFiles) {
						this.recipeFiles.push(this.lastStorageItem);
					}
					this.StoreRecipeFiles();

					this.saved = true;
					this.bottomStatus = "<p class=\"success\">Recipe '<b>" + this.lastStorageItem + "</b>' stored successfully. <a href=\"home.html\">See it here</a>.</p>";
				}
			}
		},

		/* Store current recipe object under new filename 'x' */
		StoreObjectAs(x) {
			var storage = window.localStorage;
			var go = true;

			this.recipe.ingredients.forEach((ing) => {
				if ((ing.name.length < 2) || (ing.measurement === "") || (ing.quantity < 1)) {
					this.bottomStatus = "<p class=\"error\">One or more fields in the Ingredients list is empty.</p>";
					this.saved = false;
					go = false;
				}
			});
			this.recipe.steps.forEach((st) => {
				if ((st.length < 2) || (st === "")) {
					this.bottomStatus = "<p class=\"error\">One or more steps in the Instructions list is empty.</p>";
					this.saved = false;
					go = false;
				}
			});

			if (go) {
				if ((this.recipe.serves <= 0) || (this.recipe.cooking.quantity <= 0) || (this.recipe.preparation.quantity <= 0) || (this.recipe.ingredients[0].quantity <= 0)) {
					this.bottomStatus = "<p class=\"error\">Sorry, no negative numbers please.</p>";
					this.saved = false;
				}
				else {
					this.recipe.ingredients.forEach((ing) => {
						ing.opt = ((ing.opt === "yes") ? true : false);
					});

					storage.setItem(x, JSON.stringify(this.recipe));
					console.log(JSON.stringify(this.recipe));

					this.lastStorageItem = x;
					var isInRecipeFiles = false;
					this.recipeFiles.forEach((f) => {
						if (f === this.lastStorageItem)
							isInRecipeFiles = true;
					});
					if (!isInRecipeFiles) {
						this.recipeFiles.push(x);
					}
					this.StoreRecipeFiles();

					this.saved = true;
					this.bottomStatus = "<p class=\"success\">Recipe '<b>" + x + "</b>' stored successfully. <a href=\"home.html\">See it here</a>.</p>";
				}
			}
		},

		/* Load recipe object 'x' into DOM */
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
					console.log("Pushing ingredient " + (index + 1) + ": \"" + ing.quantity + " " + ing.measurement + " " + ing.name + "\"");
				});

				this.recipe.steps = [];
				object.steps.forEach((st) => {
					this.recipe.steps.push(st);
				});

				this.uploaded = true;
			}
			else {
				console.error("Could not load specified item '" + x + "' from local storage");
				this.topStatus = "<p class=\"success\">Starting a new recipe.</p>";

				this.recipe.title = "New Recipe!";
			}
			this.saved = false;
		},

		/* Store the recipeFiles array in local storage, for use with other pages */
		StoreRecipeFiles() {
			var storage = window.localStorage;

			if (this.recipeFiles.length > 0) {
				console.log("Saving recipeFiles array");
				storage.setItem("recipeFiles", JSON.stringify(this.recipeFiles));
			}
			else {
				console.error("Something wrong with this.recipeFiles");
			}
		},

		/* Upload the file using PHP */
		UploadFile(x) {
			this.ajaxResult = "<p class=\"success\">Your file is being uploaded...</p>";
			this.topStatus = "<p class=\"success\">Uploading a new file <b>'" + x + "'</b>.</p>";

			var formData = new FormData();

			if (this.file) {
				formData.append("image", this.$refs.image.files[0], this.$refs.image.files[0].name);
				formData.append("fname", x);
			}

			// this is an AJAX call
			this.$http.post("upload", formData).then((response) => {
				this.ajaxResult = response.data;
				this.topStatus = "<p class=\"success\">Your file has been uploaded!</p>";
				this.recipe.image = "img/" + x;
				this.uploaded = true;
			}, () => {
				this.ajaxResult = "<p class=\"error\">Communication with the server failed.</p>";
				this.topStatus = "<p class=\"error\">Communication with the server failed.</p>";
			});
		}
	},

	mounted() {
		var storage = window.localStorage;
		var toLoad = storage.getItem("fileToLoad");		// view.html should set this when user clicks a button
		var recipes = storage.getItem("recipeFiles");	// view.html should read this and editor should set this

		if (!toLoad) {
			// prompt if not coming from the view page
			var filename = prompt("Which file would you like to edit? Enter nothing for new file");
			this.editingText = "Starting New";
		}
		else {
			this.fileToLoad = toLoad;
			var filename = this.fileToLoad;
			this.editingText = "Editing";
		}
		if (!recipes) {
			this.recipeFiles = ["hello"];
		}
		else {
			var x = JSON.parse(recipes);
			
			if (!x) {
				this.recipeFiles = ["hello"];
			} else {
				this.recipeFiles = x;
			}
		}

		if (filename) {
			this.LoadObject(filename);
			this.topStatus = "<p class=\"success\">Loaded file '<b>" + filename + "</b>' from local storage.</p>";
			this.showingSteps = true;
			this.showingIngreds = true;
			this.stepsButton = "Hide Steps";
			this.ingredsButton = "Hide Ingredients";
		}
		else {
			this.topStatus = "<p class=\"success\">Starting a new recipe.</p>";

			this.recipe.title = "New Recipe Title!";
		}
	}
})