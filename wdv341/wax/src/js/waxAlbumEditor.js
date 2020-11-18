/*
	WaXchange
	November - December 2020
	Copyright (c) 2020 Tanner Babcock.
*/
import AlbumInputRow from "../vue/album-input-row.vue";
import TrackInputRow from "../vue/track-input-row.vue";

Vue.component('album-input-row', AlbumInputRow)
Vue.component('track-input-row', TrackInputRow)

var app = new Vue({
	el: "#editor",

	http: {
		emulateJSON: true,
		emulateHTTP: true
	},

	data: () => {
		return {
			file: false,
			uploaded: false,
			tracks: 2,
			showingTracks: false,
			tracksButton: "Showing Tracks",
			imageFilename: "",
			ajaxResult: "",
			album: {
				id: 0,
				title: "",
				artist: "",
				media: "",
				discs: 1,
				price: 5.99,
				// seller: "",		Don't worry about seller and buyer, these will be set by the PHP
				// buyer: "",       form handler.
				image: "",
				label: "",
				posted: "",
				tracklist: [
					{
						title: "Track One",
						length: "1:00"
					},
					{
						title: "Track Two",
						length: "1:00"
					}
				]
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

		SubmitAlbum() {
			if (this.file) {
				this.ajaxResult = "<p class=\"success\">Your album and album art image are being uploaded...</p>";
			}
			else {
				this.ajaxResult = "<p class=\"success\">Your album is being processed...</p>";
			}
		}
	}
})
