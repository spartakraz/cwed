/// general-purpose utility routines
var CW_jsutils = {
  /** checks if an object is defined
   *  @param {Object}
   *  @return boolean
   */
  objectDefined: function (obj) {
    return (typeof obj !== "undefined");
  },
  /** checks if an object is set to <tt>NULL</tt>
   *  @param {Object}
   *  @return boolean
   */
  isNull: function (obj) {
    return (null === obj);
  },
  /** checks whether a value is number
   *  @return boolean
   */
  isNumber: function (aValue) {
    return !isNaN(aValue);
  },
  /**
   * checks if user agent is Google Chrome
   * @return boolean
   */
  isChrome: function () {
    return (-1 !== navigator.userAgent.indexOf("Chrome"));
  },
  /** checks if user agent is Opera
   *  @return boolean
   */
  isOpera: function () {
    return ((-1 !== navigator.userAgent.indexOf("Opera")) ||
            (-1 !== navigator.userAgent.indexOf("OPR")));
  },
  /** checks if user agent is Safari
   *  @return boolean
   */
  isSafari: function () {
    return (-1 !== navigator.userAgent.indexOf("Safari"));
  },
  /** checks if user agent is Firefox
   *  @return boolean
   */
  isFirefox: function () {
    return (-1 !== navigator.userAgent.indexOf("Firefox"));
  },
  /** checks if user agent is MS Internet Explorer
   *  @return boolean
   */
  isMSIE: function () {
    return (-1 !== navigator.userAgent.indexOf("MSIE"));
  },
  /** creates an object for sending ajax requests to PHP scripts
   *  @return <tt>XMLHttpRequest</tt>
   */
  createAjaxObject: function () {
    var obj = null;
    try {
      obj = new XMLHttpRequest();
    } catch (e) {
      try {
        obj = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        try {
          obj = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
          alert(e.toString());
          return null;
        }
      }
    }
    return obj;
  },
  /** sends an Ajax GET request off to a PHP script on server
   *  @param <tt>XMLHttpRequest</tt> an ajax object through which to send the request
   *  @param string URL of the PHP script
   *  @return boolean whether or not the request was sent off successfully
   */
  sendAjaxGet: function (ajaxObj, url) {
    if (false === this.objectDefined(ajaxObj)) {
      return false;
    }
    try {
      with (ajaxObj) {
        open("GET", url, true);
        send(null);
      }
      return true;
    } catch (e) {
      alert(e);
      return false;
    }
  },
  /** sends an Ajax POST request off to a PHP script on server
   *  @param <tt>XMLHttpRequest</tt> an ajax object through which to send the request
   *  @param string URL of the PHP script
   *  @param string data to be sent with the request
   *  @return boolean whether or not the request was sent off successfully
   */
  sendAjaxPost: function (ajaxObj, url, data) {
    if (false === this.objectDefined(ajaxObj)) {
      return false;
    }
    try {
      with (ajaxObj) {
        open("POST", url, true);
        setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        send(data);
      }
      return true;
    } catch (e) {
      alert(e);
      return false;
    }
  },
  /** imitation of PHP's <tt>sleep()</tt> function
   *  @param int
   */
  makeSleep: function (ms) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
      if ((new Date().getTime() - start) > ms) {
        break;
      }
    }
  }
};
