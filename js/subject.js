$('#frmForumReply').submit(function(){
    $.ajax({
        method:"POST",
        url:"../apis/api-add-reply.php",
        data: $('#frmForumReply').serialize(),
        dataType:"JSON"
    }).
    done(function(jData){
        console.log('comment has been added');
    }).
    fail(function(e){
      console.log(e);
        console.log('error')
    })
}) 