/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
require('./ingredient.js');

var app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			ingredients: 3,
			steps: 3,
			recipe: {
				numberOfIngreds: 3,
				numberOfSteps: 3,
				name: "",
				image: "",
				serves: 0,
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

		submitData() {
			this.ajaxResult = "";

			var form = document.querySelector("form");
			var data = new FormData(form);

			this.$http.post("", data).then((response) => {
				this.ajaxResult = response.data;
			}, () => {
				this.ajaxResult = "<p style=\"color:red;\">Communication with the server failed. Please try again later.</p>";
			});
		},

		StoreObjectAs(x) {
			var storage = window.localStorage;
			console.log("Storing object in local storage");
			storage.setItem(x, JSON.stringify(this.recipe));
		},

		LoadObject() {
			
		}
	}
})