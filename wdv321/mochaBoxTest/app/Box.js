// JavaScript Document

var Box = function(length, width, height) {
  this.length = length;
  this.width = width;
  this.height = height;
};

Box.prototype.getVolume = function() {
  return this.length * this.width * this.height;
};

module.exports = Box;