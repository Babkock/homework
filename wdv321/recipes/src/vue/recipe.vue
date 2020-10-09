<template>
	<div class="recipe" :id="myid">
		<h2>{{ $vm0.recipes[myid].name }}</h2>
		<img :src="$vm0.recipes[myid].image" />
		<p><b>Serves: {{ $vm0.recipes[myid].serves }}</b></p>
		<p><b>Preparation Time:</b> {{ $vm0.recipes[myid].preparation.quantity }} {{ $vm0.recipes[myid].preparation.measurement }}</p>
		<p><b>Cooking Time:</b> {{ $vm0.recipes[myid].cooking.quantity }} {{ $vm0.recipes[myid].cooking.measurement }}</p>
		<p><b>Difficulty:</b> {{ $vm0.recipes[myid].difficulty }}</p>
		<h3>Ingredients:</h3>
		<ul v-if="$vm0.recipes[myid].ingredients">
			<li v-for="(ing, index) in $vm0.recipes[myid].ingredients" :key="index">
				<b v-text="ing.quantity"></b> {{ ing.measurement }} {{ ing.name }}
				<i v-if="ing.optional">(Optional)</i>
			</li>
		</ul>
		<br />
		<ol v-if="$vm0.recipes[myid].steps">
			<li v-for="(step, index) in $vm0.recipes[myid].steps" :key="index">
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