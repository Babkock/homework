/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
import RecipeBlock from "../vue/recipe-block.vue";
Vue.component('recipe', RecipeBlock);

class Ingredient {
	constructor(ingName, ingQuantity, ingQuantMst) {
		this.name = ingName;
		this.quantity = ingQuantity;
		this.measurement = ingQantMst;
	}

	stringify() {
		return this.quantity + " " + this.measurement + " " + this.name;
	}
}

class Recipe {
	
}

var app = new Vue({
	el: "#displaySlider",

	data: () => {

	}
})