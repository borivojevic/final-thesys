<div data-role="page">

<div data-role="header" data-theme="d" data-position="inline">
	<h1>Slanje poruke</h1>
</div>

<div data-role="content" data-theme="c">
	<p>Poruka je georeferencirana za trenutnu lokaciju. Nakon snimanja poruke ona postaje vidljiva na mapi.</p>
	
	<div data-role="fieldcontain">
		<label for="textarea">Text poruke:</label>
		<textarea cols="40" rows="8" name="messageTextarea" id="messageTextarea"></textarea>
	</div>

	<a href="javascript:saveGeoMessageOnServer();" data-role="button" data-theme="b">Snimi</a>       
	<a href="javascript:void();" data-role="button" data-rel="back" data-theme="c">Nazad</a>    
</div>
</div>
