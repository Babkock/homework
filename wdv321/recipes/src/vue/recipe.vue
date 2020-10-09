<template>
	<div class="recipe" :id="myid">
		<h2>{{ this.recipe.name }}</h2>
		<img :src="this.recipe.image" />
		<p><b>Serves: {{ this.recipe.serves }}</b></p>
		<p><b>Preparation Time:</b> {{ this.recipe.preparation.quantity }} {{ this.recipe.preparation.measurement }}</p>
		<p><b>Cooking Time:</b> {{ this.recipe.cooking.quantity }} {{ this.recipe.cooking.measurement }}</p>
		<p><b>Difficulty:</b> {{ this.recipe.difficulty }}</p>
		<h3>Ingredients:</h3>
		<ul v-if="this.recipe.ingredients">
			<li v-for="(ing, index) in this.recipe.ingredients" :key="index">
				<b v-text="ing.quantity"></b> {{ ing.measurement }} {{ ing.name }}
				<i v-if="ing.optional">(Optional)</i>
			</li>
		</ul>
		<br />
		<ol v-if="this.recipe.steps">
			<li v-for="(step, index) in this.recipe.steps" :key="index">
				{{ step }}
			</li>
		</ol>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: String,
			required: true
		}
	}
};
</script>

<style lang="scss">

</style>