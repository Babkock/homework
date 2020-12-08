<template>
	<tr>
		<td>
			<label :for="name"><b v-text="labe"></b>:</label>
		</td>
		<td>
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
		labe: {
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
@import "../css/variables.scss";

input[type="text"], input[type="number"], input[type="password"], input[type="file"] {
	@include Appearance();
}

input[type="text"], input[type="number"], select, input[type="password"], input[type="file"] {
	@include BackBorderColor(#141414, 2px solid black, #cfcfcf);
	padding:7px;
	width:80%;
	font-size:1.14em;
	transition:background, border, color 0.2s ease 0s;
	&:hover {
		@include BackBorderColor(#181818, 2px solid #202020, #efefef);
		font-size:1.14em;
	}
	&:active {
		@include BackBorderColor(#1c1c1c, 2px solid #242424, #f9f9f9);
		font-size:1.14em;
	}
}

input[name="price"] {
	width:79%;
	font-size:1.14em;
}

select {
	width:82%;
	font-size:1.14em;
	appearance:auto !important;
	-moz-appearance:auto !important;
}

.main-album-info {
	tbody tr {
		width:100% !important;
	}
	tbody tr td {
		width:50%;
		padding:3px;
		label {
			font-size:1.14em !important;
		}
	}
	tbody tr td:first-child {
		text-align:right;
	}
	tbody tr td:nth-child(2) {
		text-align:left;
	}
}
</style>
