<template>
	<div class="search-bar">
		<input type="text" id="search" v-if="this.searchtype === 'artist'" :v-model="avmodl" :value="artist" title="Search for an artist here" alt="Search for an artist here" placeholder="Search Artists" size="90" maxlength="90" @blur="$emit('ainput', $event.target.value)" />
		<input type="text" id="search" v-else :v-model="bvmodl" :value="album" title="Search for an album here" alt="Search for an album here" placeholder="Search Albums" size="90" maxlength="90" @blur="$emit('binput', $event.target.value)" />
		<select v-model="this.searchType" id="stype" name="stype" title="Choose whether to search Artists or Albums" alt="Choose whether to search Artists or Albums">
			<option selected>Searching by</option>
			<option value="artist" :selected="stype === 'artist'">Artist</option>
			<option value="album" :selected="stype === 'album'">Album</option>
		</select>
		<select v-model="this.country" id="country" name="country" title="Show only listings from this country" alt="Show only listings from this country">
			<option selected>Anywhere</option>
			<option value="us" :selected="country === 'us'">United States</option>
			<option value="ca" :selected="country === 'ca'">Canada</option>
			<option value="mx" :selected="country === 'mx'">Mexico</option>
			<option value="uk" :selected="country === 'uk'">United Kingdom</option>
			<option value="ie" :selected="country === 'ie'">Ireland</option>
			<option value="fr" :selected="country === 'fr'">France</option>
			<option value="ru" :selected="country === 'ru'">Russian Federation</option>
			<option value="es" :selected="country === 'es'">Spain</option>
			<option value="de" :selected="country === 'de'">Germany</option>
			<option value="pl" :selected="country === 'pl'">Poland</option>
			<option value="lx" :selected="country === 'lx'">Luxembourg</option>
			<option value="dk" :selected="country === 'dk'">Denmark</option>
			<option value="se" :selected="country === 'se'">Sweden</option>
		</select>
		<button id="submit" @click="Search()">Search</button>
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
	},

	methods: {
		Search() {
			if (this.searchtype === "artist") {
				if (this.country.length > 1)
					window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?a=" + encodeURI(this.artist) + "&c=" + this.country;
				else
					window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?a=" + encodeURI(this.artist);
			}
			else if (this.searchtype === "album") {
				if (this.country.length > 1)
					window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?b=" + encodeURI(this.album) + "&c=" + this.country;
				else
					window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?b=" + encodeURI(this.album);
			}
		}
	}
};
</script>

<style lang="scss">
@import "../css/variables.scss";

.search-bar {
	display:block;
	@include WidthMargins(92%, 4%, 4%);
	#search {
		width:50%;
		@include Appearance();
		@include BackBorderColor(#101010, 2px solid black, #cfcfcf);
		padding:7px;
		padding-left:11px;
		font-size:1.4em;
		border-radius:24px 0px 0px 24px;
	}
	#stype {
		@include WidthMargins(17%, -2px, -2px);
		@include Appearance();
		font-size:1.25em;
		padding:8px;
	}
	#country {
		width:20%;
		@include Appearance();
		font-size:1.25em;
		padding:8px;
		margin-right:-4px;
	}
	#submit {
		width:10%;
		@include Appearance();
		@include BackBorderColor(#202020, 1px solid black, #dfdfdf);
		font-size:1.25em;
		border-radius:0px 24px 24px 0px;
	}

}

</style>
