<template>
	<tr class="ingredient" :id="myid">
		<td>
			#
			<input type="text" :v-model="numVmodl" :value="myid" :title="title" :alt="title" :name="numName" :size="numSize" :maxlength="numSize" placeholder="#" @blur="$emit('numinput', $event.target.value)" />
		</td>
		<td>
			<select alt="Select a unit of measurement" title="Select a unit of measurement" :name="selName" :v-model="selVmodl" v-on:change="changeunit($event.target.value)">
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

</style>
