<template>
	<tr>
		<td>
			<label :for="name"><b v-text="label"></b>:</label>
		</td>
		<td>
			<b v-if="label === 'Price'">$</b>
			<input :v-model="vmodl" :value="value" type="text" :title="title" :alt="title" :name="name" :size="size" :maxlength="maxlen" :placeholder="plchold" @blur="$emit('input', $event.target.value)" />
		</td>
	</tr>
</template>

<script>
export default {
	props: {
		value: {
			type: String,
			required: true
		},
		name: {
			type: String,
			required: true
		},
		label: {
			type: String,
			required: true
		},
		title: {
			type: String,
			required: true
		},
		size: {
			type: String,
			default: "80"
		},
		maxlen: {
			type: String,
			default: "80"
		},
		plchold: {
			type: String,
			default: "Enter some text here"
		}
	},

	computed: {
		vmodl: function() {
			return "this.album." + this.name;
		}
	}
};
</script>

<style lang="scss">

</style>
