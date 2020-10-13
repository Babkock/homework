<template>
	<div class="recipe" :id="myid">
		<h2>{{ this.recipes[myid].title }}</h2>
		<img :src="this.recipes[myid].image" />
		<p><b>Serves: {{ this.recipes[myid].serves }}</b></p>
		<p><b>Preparation Time:</b> {{ this.recipes[myid].preparation.quantity }} {{ this.recipes[myid].preparation.measurement }}</p>
		<p><b>Cooking Time:</b> {{ this.recipes[myid].cooking.quantity }} {{ this.recipes[myid].cooking.measurement }}</p>
		<p><b>Difficulty:</b> {{ this.recipes[myid].difficulty }}</p>
		<h3>Ingredients:</h3>
		<ul v-if="this.recipes[myid].ingredients">
			<li v-for="(ing, index) in this.recipes[myid].ingredients" :key="index">
				<b v-text="ing.quantity"></b> {{ ing.measurement }} {{ ing.name }}
				<i v-if="ing.optional">(Optional)</i>
			</li>
		</ul>
		<br />
		<ol v-if="this.recipes[myid].steps">
			<li v-for="(step, index) in this.recipes[myid].steps" :key="index">
				{{ step }}
			</li>
		</ol>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: Number,
			required: true
		}
	}
};
</script>

<style lang="scss">

</style>