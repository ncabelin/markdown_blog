<script>
$(function() {
  marked.setOptions({
    sanitize: true
  });
  $('#content').html(marked($('#content').text()));
  $('#preview').html(marked($('#markdown').val()));
  $('#markdown').keyup(function() {
    var val = $(this).val();
    $('#preview').html(marked(val));
  });
});
</script>
