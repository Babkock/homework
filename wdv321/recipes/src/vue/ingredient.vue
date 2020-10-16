<template>
	<tr class="ingredient" :id="myid">
		<td>
			#
			<input type="text" :v-model="numVmodl" :value="id" :title="title" :alt="title" :name="numName" :size="numSize" :maxlength="numSize" placeholder="#" @blur="$emit('numinput', $event.target.value)" />
		</td>
		<td>
			<select alt="Select a unit of measurement" title="Select a unit of measurement" :name="selName" :v-model="selVmodl" @change="$emit('measinput', $event.target.value)">
				<option value="" selected>Units per...</option>
				<option value="whole">whole</option>
				<option value="tbsp">tbsp.</option>
				<option value="tsp">tsp.</option>
				<option value="cups">cups</option>
				<option value="cans">cans</option>
				<option value="cubes">cubes</option>
				<option value="g">grams</option>
				<option value="ounces">ounces</option>
				<option value="mg">milligrams</option>
				<option value="lbs">lbs.</option>
				<option value="kg">kilograms</option>
				<option value="gallon">gallons</option>
				<option value="quarts">quarts</option>
				<option value="pints">pints</option>
				<option value="L">liters</option>
				<option value="mL">milliliters</option>
			</select>
		</td>
		<td>
			<input type="text" :size="ingSize" :maxlength="ingSize" :v-model="ingVmodl" placeholder="Name of the ingredient (sugar, oil, ginger, etc)" @blur="$emit('inginput', $event.target.value)" />
		</td>
		<td>
			Optional?
			<input type="checkbox" :v-model="optVmodl" :name="optName" value="yes" @blur="$emit('optinput', $event.target.value)" />
		</td>
	</tr>
</template>

<script>
export default {
	props: {
		id: {
			type: Number,
			required: true
		},
		title: {
			type: String,
			required: true
		},
		numSize: {
			type: String,
			default: "5"
		},
		ingSize: {
			type: String,
			default: "50"
		}
	},

	computed: {
		myid: function() { return "ingred" + this.id; },
		numName: function() { return "ingred" + this.id + "_quantity"; },
		ingName: function() { return "ingred" + this.id + "_name"; },
		selName: function() { return "ingred" + this.id + "_measurement"; },
		optName: function() { return "ingred" + this.id + "_optional"; },
		numVmodl: function() { return "this.recipe.ingredients[" + this.id + "].quantity"; },
		ingVmodl: function() { return "this.recipe.ingredients[" + this.id + "].name"; },
		selVmodl: function() { return "this.recipe.ingredients[" + this.id + "].measurement"; },
		optVmodl: function() { return "this.recipe.ingredients[" + this.id + "].optional"; }

	},

	methods: {
		changeunit(val) {
			this.recipe.ingredients[this.id].measurement = val;
		}
	}
};
</script>

<style lang="scss">
.ingredient {
	width:100%;
	margin-top:3px;
	margin-bottom:3px;
}
.ingredient td {
	background-color:#12121f;
	padding:4px;
	font-size:1.08em;
	width:24%;
	margin-left:1px;
	margin-right:1px;
	color:white;
	input[type="text"] {
		background-color: #121212 !important;
		-moz-appearance: none;
		appearance: none !important;
		border: 1px solid #171717 !important;
		padding: 5px;
		color: #eee !important;
		font-size: 1.08em;
		margin:1px;
		transition:background-color, color, border 0.2s ease 0s;
		&:hover {
			background-color: #202020 !important;
			color:white !important;
			border:1px solid #303d30 !important;
		}
	}
	input:not(input[type="checkbox"]) {
		-moz-appearance:none;
		appearance:none;
		color:white !important;
		background-color:#121212 !important;
		border:1px solid #171717 !important;
		font-size:1.08em;
		padding:5px;
		width:80% !important;
	}
	select {
		-moz-appearance:none;
		appearance:none;
		color:white;
		padding:5px;
		width:100% !important;
		background-color:#121212 !important;
		border:1px solid #192919;
		&:hover {
			background-color:#203020;
			color:white !important;
			border:1px solid #304130;
		}
		option {
			padding:5px;
			background-color:#121212 !important;
			border:1px solid #191919;
			&:hover {
				background-color:green !important;
				border:1px solid #192c19;
			}
		}
	}
}
</style>
