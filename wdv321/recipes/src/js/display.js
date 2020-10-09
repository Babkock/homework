/*
	Dynamic Recipes Project
	October - November 2020
	Copyright (c) 2020 Tanner Babcock
*/
require('./ingredient.js');

import RecipeBlock from "../vue/recipe-block.vue";
Vue.component('recipe', RecipeBlock);

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