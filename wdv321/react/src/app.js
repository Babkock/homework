/*
	My First React App
	November 12, 2020
	Tanner Babcock
*/
import React from 'react';
import ReactDOM from 'react-dom';

const template = 
<div>
	<h2>Hello Reacting World!</h2>
	<p>This is my very first React app compiled with Webpack.</p>
</div>

ReactDOM.render(template, document.getElementById('app'));

