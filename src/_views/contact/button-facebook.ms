
{{! TODO: Make custom button so YouTube and Facebook matches? }}

{{!https://developers.facebook.com/docs/plugins/like-button}}
<div class="fb-like" data-href="https://facebook.com/triangelos" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/{{LOCALE}}/sdk.js#xfbml=1&version=v2.5&appId=307412509315861";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
