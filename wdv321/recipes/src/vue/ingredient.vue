<template>
	<tr class="ingredient" :id="myid">
		<td>
			<input type="number" :v-model="numVmodl" title="Enter the amount of the ingredient" alt="Enter the amount of the ingredient" :name="numName" :id="numName" :size="numSize" :maxlength="numSize" :value="quant" placeholder="#" @blur="$emit('numinput', parseInt($event.target.value))" />
		</td>
		<td>
			<select alt="Select a unit of measurement" title="Select a unit of measurement" :name="selName" :value="mmnt" :id="selName" :v-model="selVmodl" @change="$emit('measinput', $event.target.value)">
				<option value="" :selected="!mmnt">Units</option>
				<option value="whole" :selected="mmnt === 'whole'">whole</option>
				<option value="tbsp" :selected="mmnt === 'tbsp'">tbsp.</option>
				<option value="tsp" :selected="mmnt === 'tsp'">tsp.</option>
				<option value="cups" :selected="mmnt === 'cups'">cups</option>
				<option value="cans" :selected="mmnt === 'cans'">cans</option>
				<option value="cubes" :selected="mmnt === 'cubes'">cubes</option>
				<option value="g" :selected="mmnt === 'g'">grams</option>
				<option value="oz" :selected="mmnt === 'oz'">ounces</option>
				<option value="mg" :selected="mmnt === 'mg'">milligrams</option>
				<option value="lbs" :selected="mmnt === 'lbs'">lbs.</option>
				<option value="kg" :selected="mmnt === 'kg'">kilograms</option>
				<option value="gallon" :selected="mmnt === 'gallon'">gallons</option>
				<option value="quarts" :selected="mmnt === 'quarts'">quarts</option>
				<option value="pints" :selected="mmnt === 'pints'">pints</option>
				<option value="L" :selected="mmnt === 'L'">liters</option>
				<option value="mL" :selected="mmnt === 'mL'">milliliters</option>
			</select>
		</td>
		<td>
			<input type="text" :size="ingSize" :maxlength="ingSize" title="Enter the name of the ingredient" alt="Enter the name of the ingredient" :v-model="ingVmodl" placeholder="Name of the ingredient (sugar, oil, ginger, etc)" :name="ingName" :id="ingName" :value="ing" @blur="$emit('inginput', $event.target.value)" />
		</td>
		<td>
			Optional?
			<input type="checkbox" :v-model="optVmodl" :name="optName" :id="optName" value="yes" :checked="opt === 'yes'" @blur="$emit('optinput', $event.target.value)" />
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
		numSize: {
			type: String,
			default: "5"
		},
		ingSize: {
			type: String,
			default: "50"
		},
		mmnt: {
			type: String,
			default: ""
		},
		quant: {
			type: Number,
			required: true
		},
		ing: {
			type: String,
			required: true
		},
		opt: {
			type: String,
			default: "no"
		}
	},

	computed: {
		myid: function() { return "ingred" + this.id; },
		numName: function() { return "ingred" + this.id + "_quantity"; },
		ingName: function() { return "ingred" + this.id + "_name"; },
		selName: function() { return "ingred" + this.id + "_measurement"; },
		optName: function() { return "ingred" + this.id + "_opt"; },
		numVmodl: function() { return "recipe.ingredients[" + this.id + "].quantity"; },
		ingVmodl: function() { return "recipe.ingredients[" + this.id + "].name"; },
		selVmodl: function() { return "recipe.ingredients[" + this.id + "].measurement"; },
		optVmodl: function() { return "recipe.ingredients[" + this.id + "].opt"; }
	},

	methods: {
		changeunit(val) {
			this.recipe.ingredients[this.id].measurement = val;
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

.ingredient {
	width:100%;
	margin-top:3px;
	margin-bottom:3px;
}
.ingredient td {
	/* background-color:#12121f; */
	padding:4px;
	font-size:1.08em;
	@include WidthMargins(24%, 1px, 1px);
	color:#efefef;
	input[type="text"], input[type="number"] {
		background-color: $InputBg !important;
		-moz-appearance: none;
		appearance: none;
		border: 1px solid $InputBord !important;
		padding: 5px;
		color: $InputFg;
		font-size: 1.08em;
		margin:1px;
		width:80% !important;
		transition:background-color, color, border 0.2s ease 0s;
		&:hover {
			background-color: $InputHoverBg !important;
			color:$InputHoverFg !important;
			border:1px solid $InputHoverBord !important;
		}
	}
	select {
		color:white;
		font-size:1.08em !important;
		padding:5px;
		width:100% !important;
		background-color:$InputBg;
		border:1px solid $InputBord;
		&:hover {
			background-color:$InputHoverBg !important;
			color:$InputHoverFg !important;
			border:1px solid $InputHoverBord;
		}
	}
}

.ingredient td:first-child {
	text-align:right;
	margin-right:3px;
	input {
		text-align:right;
		letter-spacing:0.9em;
	}
}

.ingredient td:nth-child(3) {
	width:35%;
}
.ingredient td:nth-child(4) {
	width:15%;
}

</style>