<template>
	<div class="search-bar">
		<input type="text" id="search" v-show="searchType === '' || searchType === 'artist'" :v-model="avmodl" :value="sartist" title="Search for an artist here" alt="Search for an artist here" placeholder="Search Artists" size="90" maxlength="90" @blur="$emit('ainput', $event.target.value); sartist = $event.target.value" />
		<input type="text" id="search" v-show="searchType === 'album'" :v-model="bvmodl" :value="salbum" title="Search for an album here" alt="Search for an album here" placeholder="Search Albums" size="90" maxlength="90" @blur="$emit('binput', $event.target.value); salbum = $event.target.value" />
		<select v-model="searchType" id="stype" title="Choose whether to search Artists or Albums" alt="Choose whether to search Artists or Albums">
			<option value="artist">Artist</option>
			<option value="album">Album</option>
		</select>
		<select :v-model="cvmodl" id="country" name="country" title="Show only listings from this country" alt="Show only listings from this country" @change="$emit('cinput', $event.target.value); scountry = $event.target.value">
			<option selected>Anywhere</option>
			<option value="us">United States</option>
			<option value="ca">Canada</option>
			<option value="mx">Mexico</option>
			<option value="uk">United Kingdom</option>
			<option value="ie">Ireland</option>
			<option value="au">Australia</option>
			<option value="fr">France</option>
			<option value="ru">Russian Federation</option>
			<option value="es">Spain</option>
			<option value="de">Germany</option>
			<option value="pl">Poland</option>
			<option value="it">Italy</option>
			<option value="fi">Finland</option>
			<option value="lx">Luxembourg</option>
			<option value="no">Norway</option>
			<option value="dk">Denmark</option>
			<option value="se">Sweden</option>
			<option value="nl">Netherlands</option>
			<option value="ba">Bosnia and Herzegovina</option>
			<option value="ch">Switzerland</option>
			<option value="is">Iceland</option>
			<option value="cn">China</option>
			<option value="jp">Japan</option>
			<option value="kr">South Korea</option>
			<option value="ph">Philippines</option>
			<option value="cz">Czech Republic</option>
			<option value="lv">Latvia</option>
			<option value="br">Brazil</option>
			<option value="am">Armenia</option>
			<option value="az">Azerbaijan</option>
			<option value="ua">Ukraine</option>
			<option value="at">Austria</option>
			<option value="tr">Turkey</option>
			<option value="in">India</option>
			<option value="hu">Hungary</option>
			<option value="ro">Romania</option>
		</select>
		<button id="submit" @click="Search()">Search</button>
	</div>
</template>

<script>
export default {
	props: {
		sartist: {
			type: String,
			default: ""
		},
		salbum: {
			type: String,
			default: ""
		},
		scountry: {
			type: String,
			default: ""
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
			if (this.searchType === "artist") {
				if ((this.sartist == undefined) || (this.sartist.length == 0)) {
					if ((this.scountry.length > 1) && (this.scountry !== "Anywhere"))
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?c=" + this.scountry;
					else
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse";
				}
				else {
					if ((this.scountry.length > 1) && (this.scountry !== "Anywhere"))
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?a=" + encodeURI(this.sartist) + "&c=" + this.scountry;				
					else
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?a=" + encodeURI(this.sartist);
				}
			}
			else if (this.searchType === "album") {
				if ((this.salbum == undefined) || (this.salbum.length == 0)) {
					if ((this.scountry.length > 1) && (this.scountry !== "Anywhere"))
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?c=" + this.scountry;
					else
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse";
				}
				else {
					if ((this.scountry.length > 1) && (this.scountry !== "Anywhere"))
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?b=" + encodeURI(this.salbum) + "&c=" + this.scountry;
					else
						window.location.href = "https://tannerbabcock.com/homework/wdv341/wax/browse?b=" + encodeURI(this.salbum);
				}
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
		border-bottom:3px solid black;
	}
	#stype {
		@include WidthMargins(16%, -2px, -2px);
		font-size:1.25em;
		padding:8px;
		appearance:auto;
		-moz-appearance:auto;
	}
	#country {
		width:20%;
		font-size:1.25em;
		padding:8px;
		margin-right:-2px;
		appearance:auto;
		-moz-appearance:auto;
	}
	#submit {
		width:10%;
		@include Appearance();
		@include BackBorderColor(#131313, 1px solid black, #dfdfdf);
		font-size:1.25em;
		border-radius:0px 24px 24px 0px;
		padding-top:10px;
		padding-bottom:10px;
		box-shadow:none !important;
		&:hover {
			@include BackBorderColor(#181818, 1px solid black, #efefef);
		}
		&:active {
			@include BackBorderColor(#101010, 1px solid black, #d4d4d4);
		}
	}

}

</style>
