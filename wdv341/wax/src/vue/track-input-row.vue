<template>
	<tr>
		<td>
			<b>{{ index + 1 }}.</b>
		</td>
		<td>
			<input type="text" :name="titlename" :v-model="titlevmod" :value="ttitle" title="Track Title" alt="Track Title" placeholder="Untitled" size="100" maxlength="100" @blur="$emit('tinput', $event.target.value)" />
		</td>
		<td>
			<input type="text" :name="lengthname" :v-model="lengthvmod" :value="tlength" title="Track Duration" alt="Track Duration" placeholder="00:00" size="5" maxlength="5" @blur="$emit('linput', $event.target.value)" />
		</td>
	</tr>
</template>

<script>
export default {
	props: {
		index: {
			type: Number,
			required: true
		},
		ttitle: {
			type: String,
			required: false
		},
		tlength: {
			type: String,
			required: false
		}
	},

	computed: {

	}
};
</script>

<style lang="scss">

</style>
