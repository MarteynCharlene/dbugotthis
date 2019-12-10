<footer>© Charlene Marteyn || KEA PROJECT 2019 </footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<?= $sLinkToScript ?? '' ?>
<script>
$(document).ready(function(){
  $("#addTopicBtn").click(function(){
    $("#btnShowAddSubject").toggle();
  });

});
</script>
</body>
</html>