<template>
	<div class="search-bar">
		<input type="text" id="search" v-if="stype === 'artist'" :v-model="avmodl" :value="artist" title="Search for an artist here" alt="Search for an artist here" plchold="Search Artists" size="90" maxlength="90" @blur="$emit('ainput', $event.target.value)" />
		<input type="text" id="search" v-else :v-model="bvmodl" :value="album" title="Search for an album here" alt="Search for an album here" plchold="Search Albums" size="90" maxlength="90" @blur="$emit('binput', $event.target.value)" />
		<select v-model="this.searchType" id="stype" name="stype" title="Choose whether to search Artists or Albums" alt="Choose whether to search Artists or Albums">
			<option selected>Search Type</option>
			<option value="artist" :selected="stype === 'artist'">Artist</option>
			<option value="album" :selected="stype === 'album'">Album</option>
		</select>
		<select v-model="this.country" id="country" name="country" title="Show only listings from this country" alt="Show only listings from this country">
			<option selected>Anywhere</option>
			<option value="us" :selected="country === 'us'">United States</option>
			<option value="ca" :selected="country === 'ca'">Canada</option>
			<option value="mx" :selected="country === 'mx'">Mexico</option>
			<option value="uk" :selected="country === 'uk'">United Kingdom</option>
		</select>
	</div>
</template>

<script>
export default {
	props: {
		artist: {
			type: String,
			default: ""
		},
		album: {
			type: String,
			default: ""
		},
		country: {
			type: String,
			default: ""
		},
		stype: {
			type: String,
			default: "artist"
		}
	},

	computed: {
		avmodl: function() {
			return "this.artist";
		},
		bvmodl: function() {
			return "this.album";
		},
		cvmodl: function() {
			return "this.country";
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

.search-bar {
	display:block;
	@include WidthMargins(90%, 5%, 5%);
	#search {
		width:69%;
		@include Appearance();
		@include BackBorderColor(#101010, 2px solid black, #cfcfcf);
		padding:6px;
		font-size:1.2em;
	}

}

</style>
