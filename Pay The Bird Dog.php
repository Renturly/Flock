/* Mixpanel Events */
/* The INN is Paid For: your Cash */

/* Cohorts */
<a href="https://www.accesstheflock.io/buyer/990">NC $500K SFR</a>

<a href="https://www.accesstheflock.io/buyer/1573">Seattle</a>

<form>
<label for="Bring_Me"><a href="https://www.accesstheflock.io/buyer/list">Bring me your email for the location</a></label>

<input onchange="dollar()" id="Bring_Me" name="Bring_Me" value="email">
</form>

<script src="bower_components/mixpanel/mixpanel-jslib-snippet.min.js"></script>

<script type="text/javascript">
function dollar() 
{
	if (document.getElementById("Bring_Me").value != null)
	{
		mixpanel.track("Renturly",{
			referrer: document.referrer,
		});
	}
}
</script>
