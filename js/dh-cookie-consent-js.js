//All the cookie setting stuff
function dhSetCookie(cookieName, cookieValue, nDays) {
	var today = new Date();
	var expire = new Date();
	if (nDays==null || nDays==0) nDays=1;
	expire.setTime(today.getTime() + 3600000*24*nDays);
	document.cookie = cookieName+"="+escape(cookieValue)+ ";expires="+expire.toGMTString()+"; path=/";
}
function dhReadCookie(cookieName) {
	var theCookie=" "+document.cookie;
	var ind=theCookie.indexOf(" "+cookieName+"=");
	if (ind==-1) ind=theCookie.indexOf(";"+cookieName+"=");
	if (ind==-1 || cookieName=="") return "";
	var ind1=theCookie.indexOf(";",ind+1);
	if (ind1==-1) ind1=theCookie.length;
	// Returns true if the versions match
	return DHcc_vars.version == unescape(theCookie.substring(ind+cookieName.length+2,ind1));
}
function dhDeleteCookie(cookieName) {
	document.cookie = cookieName + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/';
}
function dhAcceptCookies() {
	dhSetCookie('dhAccCookies', DHcc_vars.version, DHcc_vars.expiry);
	jQuery("html").removeClass('has-cookie-bar');
	jQuery("html").css("margin-top","0");
	jQuery("#dh-cookie-bar").fadeOut();
}
// The function called by the timer
function dhccCloseNotification() {
		dhAcceptCookies();
}
// The function called if first page only is specified
function dhccFirstPage() {
	if ( DHcc_vars.method ) {
		dhSetCookie('dhAccCookies', DHcc_vars.version, DHcc_vars.expiry);
	}
}
jQuery(document).ready(function($){
	$('.x_close').on('click', function(){
		dhAcceptCookies();
	});
});
