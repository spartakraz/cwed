/*
 *   Defines a class CW_BufferManager for storing and managing buffers. Each buffer is an
 *   object defined as {fileName, fileContents, line, x, y, height}  representing basename and contents of
 *   the file, number of the current line, the current scroll position in pixels, and the size of the
 *   visible area (minus scrollbars)
 */
/* Default constructor of the class. Sets default values for private fields which store total number of
 * the currently opened buffers, index of the active buffer and an array of buffer objects.
 */
function CW_BufferManager() {
  this.count_ = 0;
  this.currentIdx_ = -1;
  this.buffers_ = new Array();
}
/* adds new buffer specified by given object
 */
CW_BufferManager.prototype.add = function (aObj) {
  this.count_++;  
  this.currentIdx_ = this.count_ - 1;
  this.buffers_[this.currentIdx_] = aObj;
  
};
/* Returns total number of the currently opened buffers
 */
CW_BufferManager.prototype.count = function () {
  return this.count_;
};
/* Returns index of the active buffer
 */
CW_BufferManager.prototype.currentIdx = function () {
  return this.currentIdx_;
};
/* Activates buffer with given index
 */
CW_BufferManager.prototype.setCurrentIdx = function (aIdx) {
  this.currentIdx_ = aIdx;
};
/* Returns the buffer with given index
 */
CW_BufferManager.prototype.itemAt = function (idx) {
  return (idx >= this.count_) ? null : this.buffers_[idx];
};
/* returns index of the buffer with specified file name
 */
CW_BufferManager.prototype.findByName = function (aFileName) {
  var retVal = -1;
  for (i = 0; i < this.count_; i++) {
    var elem = this.buffers_[i];
    if (elem.fileName === aFileName) {
      retVal = i;
      break;
    }
  }
  return retVal;
};
/* a global variable through which other JS modules access the class's functionality
 */
var gBufferManager = new CW_BufferManager();
