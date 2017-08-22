<script>
$(function() {
  marked.setOptions({
    sanitize: true
  });
  $('pre').addClass('prettyprint');
  $('#content').html(marked($('#content').text()));
});
</script>
