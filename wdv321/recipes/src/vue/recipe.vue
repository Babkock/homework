<template>
	<div class="recipe" :id="myid">
		<h2><slot name="title"></slot></h2>
		<div class="imgbox">
			<slot name="img"></slot>
		</div>
		<slot name="info"></slot>
		<h3>Ingredients:</h3>
		<slot name="ingredients"></slot>
		<br />
		<h3>Instructions:</h3>
		<slot name="steps"></slot>
	</div>
</template>

<script>
export default {
	props: {
		myid: {
			type: Number,
			required: true
		},
		filename: {
			type: String,
			required: true
		}
	}
};
</script>

<style lang="scss">
.recipe {
	color:white;
	h2 a, h2 a:visited, h2 a:active, h2 a:link {
		color:aqua;
		text-shadow:3px 3px #078;
		transition:color, text-shadow 0.2s ease 0s;
	}
	h2 a:hover {
		color:lime;
		text-shadow:3px 3px #086;
		text-decoration:none !important;
	}
	p {
		font-size:1.09em;
	}
	p b {
		font-size:1.1em;
	}
	ol {
		padding:3px;
		text-align:left;
		margin-left:1.2em;
		li {
			font-size:1.08em;
			line-height:1.6;
		}
	}
	ul {
		li {
			font-size:1.08em;
			line-height:1.6;
		}
	}

	.imgbox {
		text-align:center;
		border:1px solid #dfdfdf;
		opacity:0.9;
		margin-left:6%;
		margin-right:6%;
		&:hover {
			opacity:1;
			border:1px solid white;
		}
		img {
			width:100%;
			height:100%;
		}
	}
}
</style>
