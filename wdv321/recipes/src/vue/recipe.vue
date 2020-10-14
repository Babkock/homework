<template>
	<div class="recipe" :id="myid">
		<h2>{{ this.recipes[myid].title }}</h2>
		<div class="imgbox">
			<img :src="this.recipes[myid].image" />
		</div>
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
		},
		filename: {
			type: String,
			required: true
		}
	}
};
</script>

<style lang="scss">
.recipe {
	color:white;
	background-color:rgba(0, 0, 0, 0.1);
	h2 {
		color:aqua;
		text-shadow:1px 2px #004455;
	}
	p {
		font-size:1.09em;
	}
	p b {
		font-size:1.1em;
	}
	ol {
		border:1px solid gray;
		padding:3px;
		text-align:left;
		margin-left:1.2em;
		li {
			font-size:1.08em;
			line-height:1.5;
		}
	}

	.imgbox {
		text-align:center;
		border:1px solid #dfdfdf;
		opacity:0.9;
		margin-left:4%;
		margin-right:4%;
		&:hover {
			opacity:1;
			border:1px solid white;
		}
	}
}
</style>
