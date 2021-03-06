/*
	waxAlbumEditor.js

	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import InputRow from "../vue/input-row.vue";
import TrackRow from "../vue/track-row.vue";

Vue.component('input-row', InputRow)
Vue.component('track-row', TrackRow)

let app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			file: false,
			uploaded: "{{UPLOADED}}",
			saved: false,
			tracks: "{{NUMBER_OF_TRACKS}}",
			showingTracks: true,
			tracksButton: "Hide Tracks",
			imageFilename: "",
			ajaxResult: "",
			editMsg: "{{EDITING}}",
			album: {
				id: "{{ALBUM_ID}}", // int
				title: "{{ALBUM_TITLE}}",
				artist: "{{ALBUM_ARTIST}}",
				media: "{{ALBUM_MEDIA}}",
				discs: "{{ALBUM_DISCS}}", // int
				price: "{{ALBUM_PRICE}}", // float
				seller: "{{USERNAME}}",
				buyer: "{{ALBUM_BUYER}}",
				image: "{{ALBUM_IMAGE}}",
				label: "{{ALBUM_LABEL}}",
				posted: "{{ALBUM_POSTED}}", // date
				country: "{{ALBUM_COUNTRY}}",
				tracklist: "{{ALBUM_TRACKLIST}}", // JS object
				year: "{{ALBUM_YEAR}}",  // int
				cond: "{{ALBUM_COND}}",
				currency: "{{ALBUM_CURRENCY}}",
				purchased: "{{ALBUM_PURCHASED}}", // date
				sellerid: "{{SELLERID}}",  // int
				buyerid: "{{BUYERID}}"   // int
			}
		};
	},

	/* Button handlers */
	methods: {
		/* Add a new, empty track to the Album */
		AddTrack() {
			this.album.tracklist.push({
				title: "Untitled",
				length: ""
			});
			this.tracks++;
		},

		/* Remove the last track from the Album */
		RemoveTrack() {
			this.album.tracklist.splice(this.tracks - 1, 1);
			this.tracks--;
		},

		/* Show or Hide the track listing */
		ToggleTracks() {
			this.showingTracks = ((this.showingTracks === true) ? false : true);
			this.tracksButton = ((this.showingTracks === true) ? "Hide Tracks" : "Show Tracks");
		},

		/* Format a date string */
		NicePosted(d) {
			let jsDate = new Date(Date.parse(d.replace(/[-]/g,'/')));
			return jsDate.toDateString();
		},

		/* Submit the entire Album form */
		SubmitAlbum() {
			if (this.file) {
				this.ajaxResult = "<p class=\"success\">Your album and album art image are being uploaded...</p>";
			}
			else {
				this.ajaxResult = "<p class=\"success\">Your album is being processed...</p>";
			}
			if ((this.album.title.length == 0) || (this.album.artist.length == 0) || (this.album.price == 0) || (this.album.media.length == 0) || (this.album.label.length == 0) || (this.album.currency.length == 0) || (this.album.country.length == 0) || (this.album.year === "")) {
				this.ajaxResult = "<p class=\"error\">One or more fields are empty.</p>";
			}
			else {
				let formData = new FormData();

				if (this.file) {
					formData.append("image", this.$refs.image.files[0]);
				}
				formData.append("albumJson", JSON.stringify(this.album));

				let editMode = document.querySelector("#mode").value;
				if (editMode === "new") {
					this.$http.post("album", formData).then((response) => {
						this.ajaxResult = response.data;
					}, () => {
						this.ajaxResult = "<p class=\"error\">Communication with the server failed. Please try again later.</p>";
						console.error("Could not write() album '" + this.album.title + "' with mode 'new'");
					});
				}
				else {
					this.$http.post("album?id=" + this.album.id, formData).then((response) => {
						this.ajaxResult = response.data;
					}, () => {
						this.ajaxResult = "<p class=\"error\">Communication with the server failed. Please try again later.</p>";
						console.error("Could not update() album '" + this.album.title + "' with mode 'edit'");
					});
				}
			}
		}
	}
})
