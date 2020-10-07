/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
import RecipeBlock from "../vue/recipe-block.vue";
Vue.component('recipe', RecipeBlock);

class Ingredient {
	constructor(ingName, ingQuantity, ingQuantMst, optional) {
		this.name = ingName;
		this.quantity = ingQuantity;
		this.measurement = ingQuantMst;
		this.optional = optional;
	}

	stringify() {
		return this.quantity + " " + this.measurement + " " + this.name;
	}

	json() {
		return JSON.stringify(this);
	}
}

var app = new Vue({
	el: "#displaySlider",

	data: () => {
		return {
			rows: 3,
			test: new Ingredient("chili powder", 2, "tbsp.", false)
		};
	},

	methods: {
		hello: function() {
			console.log("This is a function");
		}
	},

	mounted() {
		console.log(this.test);
	}
})